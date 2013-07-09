<?php 
/**
 * Taberna session model
 * @author Yackushev Denys
 * @package Taberna
 * @datecreated 05 October 2012
 *
 */
class model_coresession_taberna extends rad_model
{
    private $_loginService = 'http://login.tabernacms.com';
    
    /**
     * URL for partners service
     * @var string
     */
    private $_partnersService = 'http://partners.tabernacms.com';
    
    /**
     * Url for genere 3D images
     * @var string
     */
    //private $_threeDBinService = 'http://3dbin.tabernacms.com';
    private $_threeDBinService = 'http://3dbin.tabernacms.com';
    
    /**
     * Try to login to taberna ecommerce site
     * @param string $email
     * @param string $pass
     * @return struct_core_users|(int)error_code|false
     */
    public function login($email, $pass)
    {
        $res = $this->_getURL($this->_loginService, array(
                    'email'=>$email,
                    'pass'=>$pass,
                    'url'=>SITE_URL
                ));
        if(!empty($res)) {
            $res = json_decode($res);
            if($res->code==1 and !empty($res->user)) {
                return $res;
            } else {
                return (int)$res->code;
            }
        }
        return false;
    }
    
    private function _getURL($url, $postdata=array(), $files=array(), $method='POST')
    {
        foreach($postdata as $key=>$value) {
            if(is_array($value)) {
                foreach($value as $pdK=>$pdV) {
                    $postdataOK[$key.'['.$pdK.']'] = $pdV;
                }
            } else {
                $postdataOK[$key] = $value;
            }
        }
        if (count($files)) {
            //TODO: Написана какая-то херня по логике, нужно разбираться на реальных данных.
            foreach($files as $key=>$file) {
                if (empty($file['tmp_name']) and !empty($file[0])) {
                    foreach($file as $keyFile=>$idFile) {
                        $postdataOK[$key] = "@".$idFile['tmp_name'];
                    }
                } else {
                    $postdataOK['file'] = "@".$file['tmp_name'];
                }
            }
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POST, 1 );
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $postdataOK);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $postResult = curl_exec($ch);
        
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
        return $postResult;
    }
    
    public function getPartnersLicense($name)
    {
        return $this->_getUrl($this->_partnersService, array(
                'a'=>'license',
                'name'=>$name,
                'lang'=>$this->getCurrentLangID(),
                'email'=>$this->config('taberna.user'),
                'pass'=>$this->config('taberna.pass'),
                'url'=>SITE_URL
        ));
    }
    
    public function acceptLicense($pName)
    {
        $settingsItem = new struct_core_settings(array(
                'fldName'=>'partners.'.$pName.'.license',
                'fldValue'=>$this->getCurrentUser()->u_id,
                'rtype'=>'system',
                'description'=>'Value is the accepted license user id'
        ));
        $result = $this->_getURL($this->_partnersService, array(
                'a'=>'acceptLicense',
                'hash'=>serialize($settingsItem),
                'email'=>$this->config('taberna.user'),
                'pass'=>$this->config('taberna.pass'),
                'url'=>SITE_URL
        ));
        if((int)$result) {
            $settingsItem->save();
        }
        return $result;
    }
    
    public function genere3DBin($params) 
    {
        set_time_limit($this->config('partners.3dbin.time'));
        $params['action'] = 'upload';
        $params['lang'] = $this->getCurrentLangID();
        $params['email'] = $this->config('taberna.user');
        $params['pass'] = $this->config('taberna.pass');
        $params['url'] = SITE_URL;
        $transactionId = $this->_getUrl($this->_threeDBinService, $params, array('file'=>array(
                'tmp_name'=>CORECATALOG_IMG_PATH.$params['files'][0],
                'name'=>$params['files'][0])));
        if (!empty($transactionId)) {
            $transactionId = json_decode($transactionId);
            if(!empty($transactionId->code)) {
                die('ERROR_CODE:'.$transactionId->code);
            }
            $params['transaction_id'] = $transactionId->transaction_id;
            $params['action'] = 'addupload';
            if(count($params['files'])>1) {
                for($i=1;$i<count($params['files']);$i++) {
                    $transaction2Id = $this->_getUrl($this->_threeDBinService, $params, array('file'=>array(
                            'tmp_name'=>CORECATALOG_IMG_PATH.$params['files'][$i],
                            'name'=>$params['files'][$i])));
                }
            }
            if(!empty($params['logo']) and is_file($this->config('rootPath').$params['logo'])) {
                $params['action'] = 'addlogo';
                $t3 = $this->_getUrl($this->_threeDBinService, $params, array('file'=>array(
                        'tmp_name'=>$this->config('rootPath').$params['logo'],
                        'name'=>basename($params['logo']))));
            }
            $params['action'] = 'sendcompile';
            $transactionId = $this->_getUrl($this->_threeDBinService, $params);
            return $transactionId;
        } else {
            throw new rad_exception('Error when generating the transaction ID! Try later!');
        }
    }
    
    public function progress3DBin($params)
    {
        set_time_limit($this->config('partners.3dbin.time'));
        $params['action'] = 'progress';
        $params['lang'] = $this->getCurrentLangID();
        $params['email'] = $this->config('taberna.user');
        $params['pass'] = $this->config('taberna.pass');
        $params['url'] = SITE_URL;
        $res = $this->_getURL($this->_threeDBinService, $params);
        if(!empty($res)) {
            return $res;
        } else {
            return '-14';
        }
    }
    
    public function get3DBinFile($params)
    {
        if(empty($params['cat_id']) or !(int)$params['cat_id']) {
            throw new rad_exception('Cat id can\'t be empty when getting file!!! Some error!');
        }
        set_time_limit($this->config('partners.3dbin.time'));
        $params['action'] = 'getfile';
        $params['lang'] = $this->getCurrentLangID();
        $params['email'] = $this->config('taberna.user');
        $params['pass'] = $this->config('taberna.pass');
        $params['url'] = SITE_URL;
        $file = $this->_getURL($this->_threeDBinService, $params);
        $destination = DOWNLOAD_FILES_DIR.'3dbin'.DS.$params['cat_id'].'_'.md5(time().'3dbin').'.swf';
        if(!is_dir(dirname($destination))) {
            recursive_mkdir(dirname($destination), 0777);
        }
        safe_put_contents($destination, $file);
        return $destination;
    }
}