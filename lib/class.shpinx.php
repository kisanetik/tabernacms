<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amangion
 * Date: 08.02.13
 * Time: 13:00
 * To change this template use File | Settings | File Templates.
 */
class rad_shpinx extends rad_singleton
{
    protected $_sphinx = null;
    protected function __construct()
    {
        include SPHINXPATH . 'sphinxapi.php';
        $this->_sphinx = new SphinxClient();
        $this->_sphinx->SetServer(rad_config::getParam('sphinx.host'), rad_config::getParam('sphinx.port'));
        $this->_sphinx->SetMatchMode(SPH_MATCH_EXTENDED);
    }

    public function getSpinx() {
        return $this->_sphinx;
    }
}
