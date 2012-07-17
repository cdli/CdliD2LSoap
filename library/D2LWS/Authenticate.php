<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/adamlundrigan/zfD2L/blob/0.1a0/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to adamlundrigan@cdli.ca so we can send you a copy immediately.
 * 
 * @copyright  Copyright (c) 2011 Centre for Distance Learning and Innovation
 * @license    New BSD License 
 * @author     Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author     Thomas Hawkins <thawkins@mun.ca>
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
     * Get number of uses remaining on current token
     * @return int
     */
    public function getTokenRemainingUseCount()
    {
        return $this->_tokenMaxUse;
    }
    
    /**
     * Get timestamp of token expiry
     * @return int
     */
    public function getTokenExpiry()
    {
        return $this->_tokenExpires;
    }
    
    /**
     * Get number of seconds remaining in token's life
     * @return int
     */
    public function getTokenTimeRemaining()
    {
        return ( $this->getTokenExpiry() - time() );
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
