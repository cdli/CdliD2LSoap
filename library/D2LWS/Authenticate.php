<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: Authenticate.php 18 2011-02-07 15:53:03Z adamlundrigan $
 *
 */

/**
 * Server Authentication
 * @todo Move to new "Authentication" module?
 */
class D2LWS_Authenticate extends D2LWS_Common
{

    /**
     * The Active Authentication Token
     * @type string
     */
    protected $_token = "";

    /**
     * Number of times this token can be used
     * @type int
     */    
    protected $_tokenMaxUse = 0;

    /**
     * Timestamp when this token expires
     * @type int
     */        
    protected $_tokenExpires = 0;


    /**
     * Create new Desire2Learn Web Service (D2LWS) instance
     * @param $instance D2LWS_Instance - Server instance to connect to
     */
    public function __construct(D2LWS_Instance $instance = NULL)
    {
        if ( !is_null($instance) )
        {
            $this->setInstance($instance);
        }
    }
    
    /** 
     * Set server instance
     * @param $instance D2LWS_Instance - Instance to save
     * @return $this
     */
    public function setInstance(D2LWS_Instance $instance)
    {
        parent::setInstance($instance);
        return $this;
    }
    
    /**
     * Get an authentication token
     * @return string - Valid authentication token
     * @throws D2LWS_Soap_Client_Exception_AuthenticationFailed - Authentication with D2L server fails
     */
    public function getToken()
    {
        if ( $this->tokenHasExpired() )
        {
            if ( !$this->authenticate() )
            {
                throw new D2LWS_Soap_Client_Exception_AuthenticationFailed();
            }
        }
        
        $this->_tokenMaxUse--;
        return $this->_token;
    }
    
    
    /**
     * Check to see if auth token has expired
     * @return boolean - True if expired, false otherwise
     */
    public function tokenHasExpired()
    {
        return ( is_null($this->_token) || $this->_tokenMaxUse == 0 || $this->_tokenExpires <= time() );
    }
    
    /**
     * Authenticate against D2L web service
     * @return boolean - true if authenticated, false otherwise
     */
    protected function authenticate()
    {
        $i = $this->getInstance();
        try
        {
            $now = time();

            $result = $i->getSoapClient()
                        ->setWsdl($i->getConfig('webservice.auth.wsdl'))
                        ->setLocation($i->getConfig('webservice.auth.endpoint'))
                        ->Authenticate2(array(
                            'Username'=>$i->getConfig('server.username'),
                            'Password'=>$i->getConfig('server.password'),
                            'Purpose'=>'Web Service',
                            'DevKey'=>$i->getConfig('server.developerkey')
                        ));
            if ( $result instanceof stdClass && isset($result->status) && $result->status == "Success" )
            {
                $this->_token = $result->token;
                $this->_tokenMaxUse = $result->tokenSettings->maxUsageCount;
                $this->_tokenExpires = $now + $result->tokenSettings->lifetimeInSeconds;
                return true;
            }
            else
            {
                return false;
            }
            
        }
        catch ( Exception $ex )
        {
            return false;
        }
    }

}