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
     * Delete expired activation codes
     * @return model_coremail_subscribes
     */
    public function removeExpired()
    {
        $this->query('DELETE FROM '.RAD.'subscribers_activationurl WHERE date_confirmed=0 AND date_created<:expires', array(
            'expires' => (time() - 5*24*3600)
        ));
        return $this;
    }

    /**
     * Confirm e-mail
     * @param $code
     */
    public function confirm($code)
    {
        $this->query('UPDATE '.RAD.'subscribers_activationurl SET date_confirmed=:now WHERE sac_url=:code AND date_confirmed=0', array('now'=>time(), 'code'=>$code));
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