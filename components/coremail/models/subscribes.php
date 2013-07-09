<?php
/**
 * For subscribes admin
 * @author Denys Yackushev
 * @package Taberna
 */
class model_coremail_subscribes extends rad_model
{
    private $_cached_settings = null;

    function getSettings()
    {
        return $this->_cached_settings;
    }

    /**
     * Delete activation URL record
     * @param string $code Activation code
     * @return bool Success flag
     * @todo Check the function is working OK
     */
    function deleteActivationURL($code)
    {
        $this->query('DELETE FROM '.RAD.'subscribers_activationurl WHERE sac_url=?', array($code));
        if((int)$this->getPDO()->errorCode()) {
            throw new rad_exception($this->getPDO()->errorCode(), print_h($this->getPDO()->errorInfo(), true));
        }
        return true;
    }

    /**
     * Get Activation URL record(s)
     * @return null|struct_coremail_subscribers_activationurl
     */
    function getActivationUrl()
    {
        $q = new rad_query();
        $q->from(RAD.'subscribers_activationurl');
        $q->select('*');
        if($this->getState('sac_type')) {
            $q->where('sac_type = :sac_type')->value( array( 'sac_type'=>(int)$this->getState('sac_type') ) );
        }
        if($this->getState('sac_url')) {
            $q->where('sac_url = :sac_url')->value( array( 'sac_url'=>$this->getState('sac_url') ) );
        }
        if($this->getState('sac_scrid')) {
           $q->where('sac_scrid = :sac_scrid')->value( array( 'sac_scrid'=>$this->getState('sac_scrid') ) );
        }
        if( $res = $this->query($q->toString(), $q->getValues()) ){
            $result = new struct_coremail_subscribers_activationurl($res);
            return $result;
        } else {
            return null;
        }
    }
}