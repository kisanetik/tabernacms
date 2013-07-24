<?php
/**
 * Container class for caching for langcodes
 *
 */
//TODO Create save functions on destroy and all of the caching
class rad_lang_container
{

    private $_langcodes = array();
    private $_template = '';
    private $_changedTemplates = NULL;
    /**
     * current language ID
     * @var integer
     */
    private $_langID = NULL;

    /**
     * Constructor - creates cache here!
     *
     */
    function __construct($templates = NULL)
    {
        if (is_array($templates)) {
            foreach($templates as $id=>$template) {
                $this->_readCacheFor($template);
            }
        }
        $this->_langID = rad_lang::getCurrentLangID();
    }

    /**
     * Main translator function that called from template
     *
     * @param $code string - Language code
     * @param $language string - Language like en,ru,us,uk
     *
     * @return string
     *
     */
    function _($code='',$language=NULL)
    {
        if(!$language) {
            $language = $this->_langID;
        }
        if( !isset( $this->_langcodes[$this->_template][$code] ) and ($language == $this->_langID)) {
            $this->_changedTemplates[$this->_template] = 1;
            $this->_langcodes[$this->_template][$code] = rad_lang::lang($code, $language, $this);
        } else {
            return rad_lang::lang($code, $language, $this);
        }// !isset
        return $this->_langcodes[$this->_template][$code];
    }

    /**
     * Sets the template name for codes
     *
     * @param string $name
     */
    function setTemplate($name='')
    {
        $this->_template = $name;
    }

    /**
     * Get the current template name for codes
     *
     */
    function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Saves all uncached lang codes
     */
    public function saveAllCache()
    {
        if(count($this->_changedTemplates)) {
            foreach($this->_changedTemplates as $template=>$lastValue){
                $this->_saveCacheFor($template);
            }
        }
        $cnf = rad_lang::getCacheNotFound();
        if(!empty($cnf)) {
            $cacheToSave = array();
            foreach($cnf as $code=>$id) {
                foreach($id as $idf) {
                    if(!empty($idf) and isset($idf['template']) and !empty($idf['language']) and !empty($code)) {
                        $cacheToSave[$idf['template']][$idf['language']][] = $code;
                    }
                }
            }
            foreach($cacheToSave as $template=>$idc) {
                $filename = $this->_template2fn($template).'nf';
                $idc = array($template=>$idc);
                if(file_exists($filename)) {
                    $ids = array_merge(array($template=>(array)json_decode(file_get_contents($filename))), $idc);
                }
                $fh = fopen( $filename , 'w+' );
                fwrite($fh,  json_encode($idc)."\r\n");
                fclose($fh);
            }
        }
    }

    /**
     * Translate template to need filename for caching
     * @param string $template
     * @return string filename
     */
    private function _template2fn($template)
    {
        $template_dr = str_replace('/','~',$template);
        return rad_config::getParam('lang.cacheDir').$this->_langID.md5($template_dr).'.cache';
    }

    /**
     * Saves cache for template
     * @package string $template - filename of the template
     */
    private function _saveCacheFor($template)
    {
        if( is_dir( rad_config::getParam('lang.cacheDir') ) ) {
            if(!empty($this->_langcodes[$template])) {
                $fh = fopen( $this->_template2fn($template) , 'w+' );
                foreach($this->_langcodes[$template] as $code=>$value) {
                    fwrite($fh,$code."\r\n");
                }
                fclose($fh);
            }
        } else {
            die('Directory for caching langcodes not exists!');
        }
    }

    /**
     * Reading cache for one template
     */
    private function _readCacheFor($template)
    {
        if( is_dir( rad_config::getParam('lang.cacheDir') ) ){
            $fn = $this->_template2fn( $template );
            if( file_exists($fn) ) {
                $tmp = file( $fn );
                $need_del = array("\r","\n","\t");
                $to_replace = array('','','');
                foreach($tmp as $file_line=>$code) {
                    $code = trim($code);
                    if( ($code) and (strlen($code)) ) {
                        $this->_langcodes[$template][str_replace($need_del,$to_replace,$code)] = null;
                    }
                }//foreach
            }//if fileexists
        }//if isdir
    }

    /**
     * Load cache for templates
     * @param array $templates
     */
    public function loadCacheForTemplates($templates)
    {
        if(is_array($templates) and count($templates)) {
            foreach($templates as $id=>$template) {
                $this->_readCacheFor($template);
            }
            $codes = array();
            foreach($this->_langcodes as $template=>$cod) {
                foreach($cod as $code=>$nul) {
                    $codes[] = $code;
                }
            }
            $codes = rad_lang::getCodeValues($codes);
            foreach($this->_langcodes as $template=>$cod) {
                foreach($cod as $code=>$nul) {
                    if( ($code) and (strlen($code)) and isset($codes[$code])) {
                        $this->_langcodes[$template][$code] = $codes[$code] or null;
                    }
                }
            }
        }
    }
}