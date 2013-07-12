<?php
class app
{
    const CONFIG_DB = '../config.db.php';
    const CONFIG = '../config.php';
    const DUMP = '../dump.sql';
    const HTACCESS = '../.htaccess';

    public static $action = 'start';
    public static $lang = 'ru';
    protected static $instance = null;

    static function run()
    {
        try {
            self::getInstance()->action = is_numeric($_GET['r']) ? 'step' . $_GET['r'] : self::$action;

            self::setLanguage(self::$lang);

            $action = self::getInstance()->action;

            if (!method_exists('app', $action))
                throw new Exception(self::lang('action_ex'));

            self::getInstance()->$action();
        } catch (Exception $ex) {
            self::setVar('content', '<p class="error_msg round">' . $ex->getMessage() . '</p>');
            self::setVar('title', self::lang('error'));
        }

        $layout = 'tmpl/_layout.php';

        if (!file_exists($layout))
            echo '<p style="color:red;">' . self::lang('layout_ex') . '</p>';
        else
            include_once $layout;
    }

    static function lang($name)
    {
        return htmlspecialchars(empty(self::getInstance()->lang[$name]) ? $name : self::getInstance()->lang[$name]);
    }

    static function redirect($url)
    {
        header('Location: ' . $url);
        die();
    }

    static function render($view, $vars = array())
    {
        $tmpl = 'tmpl/' . $view . '.php';

        if (!file_exists($tmpl))
            throw new Exception(self::lang('view_ex'));

        foreach ($vars as $k => $v)
            $$k = $v;

        ob_start();

        include_once $tmpl;

        self::setVar('content', ob_get_contents());

        ob_end_clean();
    }

    static function setLanguage($val)
    {
        $lang = 'lang/' . (empty($_SESSION['lang']) ? $val : $_SESSION['lang']) . '.php';

        if (!file_exists($lang))
            throw new Exception('Language file "' . $lang . '" is not found.');

        self::getInstance()->lang = include $lang;
    }

    static function getInstance()
    {
        if (self::$instance === null) self::$instance = new self;
        return self::$instance;
    }

    static function isAjax()
    {
        return (isset($_POST['method']) and $_POST['method'] == 'ajax');
    }

    static function loadModel($name)
    {
        if (!file_exists('model/' . $name . '.php'))
            throw new Exception(self::lang('model_ex'));

        $model = include('model/' . $name . '.php');

        foreach ($model as $key => $arr)
            if (isset($_SESSION[$key]))
                $model[$key]['value'] = $_SESSION[$key];

        return $model;
    }

    //Get app variable
    static function getVar($name)
    {
        return isset(self::getInstance()->$name) ? self::getInstance()->$name : null;
    }

    //Set app variable
    static function setVar($name, $value)
    {
        self::getInstance()->$name = $value;
    }

    //Recursive nomination rights to the folder
    static function chmod($path, $recursive = true, $chmod = 0777)
    {
        $result = true;

        if (file_exists($path) && is_dir($path)) {
            if (!is_writable($path) and !chmod($path, $chmod))
                $result = false;
            elseif ($recursive) {
                $dirHandle = opendir($path);

                while (false !== ($file = readdir($dirHandle))) {
                    if ($file != '.' and $file != '..' and substr($file, 0, 1) != '.') {
                        $tmpPath = $path . '/' . $file;

                        if (is_dir($tmpPath) and !self::chmod($tmpPath, $recursive, $chmod))
                            $result = false;
                    }
                }

                closedir($dirHandle);
            }
        } else
            $result = false;

        return $result;
    }

    //Actions

    //Language's choice
    public function start()
    {
        if (isset($_POST['lang'])) {

            $_SESSION['lang'] = trim($_POST['lang']);

            self::setLanguage($_SESSION['lang']);

            self::redirect('/install/1');
        }
        self::setVar('title', self::lang('start_title'));
        self::render('start');
    }

    //License agreement
    public function step1()
    {
        $hasErrors = false;

        $fields = self::loadModel('step1');

        if (isset($_POST['license'])) {

            $fields['license']['value'] = trim($_POST['license']);

            if (empty($fields['license']['value']) and $fields['license']['required']) {
                $fields['license']['error'] = self::lang('step1_error1');
                $hasErrors = true;
            } else
                self::redirect('/install/2');
        }

        self::setVar('title', self::lang('step1_title'));
        self::render('step1', array('f' => $fields, 'hasErrors' => $hasErrors));
    }

    //Check of a configuration of the server
    public function step2()
    {
        $hasErrors = false;

        $fields = self::loadModel('step2');

        if (version_compare(PHP_VERSION, '5.1.3', '<')) {
            $fields['php_version']['error'] = self::lang('php_version_');
            $hasErrors = true;
        }

        if (!extension_loaded('gd') and !dl('gd.so')) {
            $fields['gd']['error'] = self::lang('gd_');
            $hasErrors = true;
        }

        if (!extension_loaded('pdo')) {
            $fields['pdo']['error'] = self::lang('pdo_');
            unset($fields['pdo_mysql']);
            $hasErrors = true;
        } elseif (!extension_loaded('pdo_mysql')) {
            $fields['pdo_mysql']['error'] = self::lang('pdo_mysql_');
            $hasErrors = true;
        }

        if (!function_exists('mb_strlen') or !function_exists('mb_substr')) {
            $fields['mb']['error'] = self::lang('mb_');
            $hasErrors = true;
        }

        if (!self::chmod('../', false)) {
            $fields['root']['error'] = self::lang('root_');
            $hasErrors = true;
        }

        if (!self::chmod('../syscache/compiled/', false)) {
            $fields['compiled']['error'] = self::lang('compiled_');
            $hasErrors = true;
        }

        if (!self::chmod('../syscache/cached/', false)) {
            $fields['cached']['error'] = self::lang('cached_');
            $hasErrors = true;
        }

        if (!self::chmod('../cache')) {
            $fields['img']['error'] = self::lang('img_');
            $hasErrors = true;
        }

        self::setVar('title', self::lang('step2_title'));
        self::render('step2', array('f' => $fields, 'hasErrors' => $hasErrors));
    }

    //Control of connection to a DB
    public function step3()
    {
        $hasErrors = false;

        $fields = self::loadModel('step3');

        if (!empty($_POST)) {
            foreach ($fields as $key => $arr) {
                $fields[$key]['value'] = trim($_POST[$key]);

                if (empty($fields[$key]['value']) and $fields[$key]['required']) {
                    $fields[$key]['error'] = self::lang('required');
                    $hasErrors = true;
                }
            }

            if (self::isAjax()) {
                $error = false;

                ob_start();
                try {
                    $dbh = new PDO("mysql:host={$fields['host']['value']};dbname={$fields['dbname']['value']}",
                        $fields['login']['value'],
                        $fields['password']['value']
                    );
                } catch (PDOException $e) {
                    if ($e->getCode() == 1049)
                        $error = self::lang('dbname_error');
                    else
                        $error = self::lang('host_error');
                }
                ob_end_clean();

                if (!$error)
                    foreach ($fields as $key => $arr)
                        $_SESSION[$key] = $arr['value'];

                die($error);
            } elseif (!$hasErrors) {
                self::redirect('/install/4');
            }
        }

        self::setVar('title', self::lang('step3_title'));
        self::render('step3', array('f' => $fields, 'hasErrors' => $hasErrors));
    }

    //Site control
    public function step4()
    {
        $hasErrors = false;

        $fields = self::loadModel('step4');

        if (!empty($_POST)) {

            foreach ($fields as $key => $arr) {
                $fields[$key]['value'] = trim($_POST[$key]);

                if (empty($fields[$key]['value']) and $fields[$key]['required']) {
                    $fields[$key]['error'] = self::lang('required');
                    $hasErrors = true;
                }
            }

            if (!$hasErrors) {
                if (!((bool)filter_var($fields['admin_email']['value'], FILTER_VALIDATE_EMAIL))) {
                    $fields['admin_email']['error'] = self::lang('invalid_email');
                    $hasErrors = true;
                }
                if (!((bool)filter_var($fields['sys_email']['value'], FILTER_VALIDATE_EMAIL))) {
                    $fields['sys_email']['error'] = self::lang('invalid_email');
                    $hasErrors = true;
                }
                if (!$hasErrors) {
                    foreach ($fields as $key => $arr)
                        $_SESSION[$key] = $fields[$key]['value'];

                    self::redirect('/install/5');
                }
            }
        }

        self::setVar('title', self::lang('step4_title'));
        self::render('step4', array('f' => $fields, 'hasErrors' => $hasErrors));
    }

    //Installation
    public function step5()
    {
        $error = array();

        if (!empty($_POST)) {

            ini_set('max_execution_time', '240');

            if (!file_exists(self::CONFIG_DB))
                $error[] = self::lang('dbconfig_failed');
            elseif (!is_writable(self::CONFIG_DB))
                $error[] = self::lang('dbconfig_failed2');

            if (!file_exists(self::CONFIG))
                $error[] = self::lang('config_failed');
            elseif (!is_writable(self::CONFIG))
                $error[] = self::lang('config_failed2');

            if (!file_exists(self::HTACCESS))
                $error[] = self::lang('htaccess_failed');

            if (!file_exists(self::DUMP))
                $error[] = self::lang('dump_failed');

            if (empty($error)) {
                if (false === ($cdb_array = @file(self::CONFIG_DB)) or false === ($cdb = @fopen(self::CONFIG_DB, 'w+')))
                    $error[] = self::lang('dbconfig_failed3');
                else {
                    foreach ($cdb_array as $k => $line) {
                        if (strpos($line, "config['db_config']['db_hostname']"))
                            $line = '$config[\'db_config\'][\'db_hostname\']=\'' . $_SESSION['host'] . '\';' . PHP_EOL;
                        else if (strpos($line, "config['db_config']['db_username']"))
                            $line = '$config[\'db_config\'][\'db_username\']=\'' . $_SESSION['login'] . '\';' . PHP_EOL;
                        else if (strpos($line, "config['db_config']['db_password']"))
                            $line = '$config[\'db_config\'][\'db_password\']=\'' . $_SESSION['password'] . '\';' . PHP_EOL;
                        else if (strpos($line, "config['db_config']['db_databasename']"))
                            $line = '$config[\'db_config\'][\'db_databasename\']=\'' . $_SESSION['dbname'] . '\';' . PHP_EOL;
                        fwrite($cdb, $line);
                    }
                    fclose($cdb);
                }

                if (false === ($conf_array = @file(self::CONFIG)) or false === ($conf = @fopen(self::CONFIG, 'w+')))
                    $error[] = self::lang('config_failed3');
                else {
                    foreach ($conf_array as $k => $line) {
                        if (strpos($line, "config['page.defaultTitle']"))
                            $line = '$config[\'page.defaultTitle\']=\'' . $_SESSION['slogan'] . '\';' . PHP_EOL;
                        else if (strpos($line, "config['admin.mail']"))
                            $line = '$config[\'admin.mail\']=\'' . $_SESSION['admin_email'] . '\';' . PHP_EOL;
                        else if (strpos($line, "config['system.mail']"))
                            $line = '$config[\'system.mail\']=\'' . $_SESSION['sys_email'] . '\';' . PHP_EOL;
                        fwrite($conf, $line);
                    }
                    fclose($conf);
                }

                if (empty($error)) {

                    if (false === ($dump = @fopen(self::DUMP, 'r')))
                        $error[] = self::lang('dump_failed2');

                    if (empty($error)) {
                        try {
                            $dbh = new PDO(
                                "mysql: host={$_SESSION['host']}; dbname={$_SESSION['dbname']}",
                                $_SESSION['login'],
                                $_SESSION['password']
                            );

                            $query = '';

                            while (!feof($dump)) {
                                $line = trim(fgets($dump));
                                if (substr($line, 0, 2) != '--') {
                                    $query .= $line;
                                    if (substr($query, -1) == ';') {
                                        $dbh->exec($query);
                                        $query = '';
                                    }
                                }
                            }
                        } catch (PDOException $ex) {
                            $error[] = self::lang('pdo_ex');
                            //DEBUG:
                            //$error[] = print_r($ex, true);
                            //$error[] = print_r($_SESSION, true);
                        }
                        fclose($dump);

                        if (empty($error)) {

                            foreach ($_SESSION as $key => $val)
                                if ($key != 'lang')
                                    unset($_SESSION[$key]);

                            self::redirect('/install/6');
                        }
                    }
                }
            }
        }

        self::setVar('title', self::lang('step5_title'));
        self::render('step5', array('error' => $error));
    }

    public function step6()
    {
        self::setVar('title', self::lang('step6_title'));

        self::render('step6');
    }
}