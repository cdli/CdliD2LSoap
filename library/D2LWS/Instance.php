<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

/**
 * Filesystem path where library is installed
 */
define("D2LWS_BASE", dirname(__FILE__));

/**
 * Determine whether we should use our own internal autoloader
 */
if ( !defined("D2LWS_MANUAL_AUTOLOADER") )
    define("D2LWS_MANUAL_AUTOLOADER", false);

/**
 * Server instance
 */
class D2LWS_Instance
{
    /**
     * Path to the D2LWS configuration file
     * @type string
     */
    protected $_configFile = "";
    
    /**
     * Configuration storage
     * @type Zend_Config
     */
    protected $_config = NULL;
    
    /**
     * Stores an instance of the SOAP client
     * @type D2LWS_Soap_Client_Interface
     */
    protected $_soapObj = NULL;    
    
    /**
     * Stores an instance of the D2L authenticator
     * @type D2LWS_Authenticate
     */
    protected $_authObj = NULL;
    
    /**
     * Create new Desire2Learn Web Service (D2LWS) instance
     * @param $configFile string - Path to configuration file
     */
    public function __construct($configFile, $configSection=NULL)
    {
        if ( file_exists(realpath($configFile)) )
        {
            $this->_configFile = $configFile;
            $this->_config = new Zend_Config_Ini($configFile, ( is_null($configSection) ? APPLICATION_ENV : $configSection ) );
        }
        else
        {
            throw new D2LWS_Exception_ConfigurationFileNotFound($configFile);
        }
    }
    
    /**
     * Retrieve a configuration variable
     * @param $variable string - Variable key
     * @return string - Variable value
     */
    public function getConfig($variable)
    {
        $parts = explode(".", $variable);
        if ( strlen(trim($variable)) > 0 &&  count($parts) > 0 )
        {
            $val = $this->_config;
            foreach ( $parts as $p )
            {
                if ( isset($val->{$p}) )
                {
                    $val = $val->{$p};
                }
                else
                {
                    return false;
                }
            }
            
            // Replace placeholder values
            while ( true )
            {
                if ( preg_match_all("/\[\[\+([A-Z0-9.]+)\]\]/i", $val, $matches) )
                {
                    foreach ( $matches[1] as $mk=>$match )
                    {
                        $cfgVal = $this->getConfig($match);
                        $val = str_replace($matches[0][$mk], $cfgVal, $val);
                    }
                }
                else
                {
                    break;
                }
            }
            
            return $val;
        }
        return false;
    }
    
    /**
     * Retrieve the SOAP client instance
     * @return Instance of D2LWS_Soap_Client
     */
    public function getSoapClient()
    {
        if ( is_null($this->_soapObj) )
        {
            $this->_soapObj = new D2LWS_Soap_Client(NULL, array('trace'=>1, 'exceptions'=>1));
            $this->_soapObj->setInstance($this);
        }
        //AAL 20110202 -- 'clone' gets around an issue with the SOAP client
        // setWsdl() and setLocation() only work the first time
        // Subsequent calls don't seem to change the endpoint URL
        return $this->_soapObj instanceof D2LWS_Soap_Client
            ? clone $this->_soapObj
            : $this->_soapObj;
    }

    /**
     * Set SOAP client instance
     * @param D2LWS_Soap_Client_Interface $sc
     * @return D2LWS_Instance fluent interface
     */
    public function setSoapClient(D2LWS_Soap_Client_Interface $sc)
    {
        $this->_soapObj = $sc;
        return $this;
    }    
    
    /**
     * Get authentication manager
     * @return D2LWS_Authenticate - Authentication manager instance
     */
    public function getAuthManager()
    {
        if ( is_null($this->_authObj) )
        {
            $this->_authObj = new D2LWS_Authenticate();
            $this->_authObj->setInstance($this);
        }
        return $this->_authObj;
    }

    /**
     * Set authentication manager instance
     * @param D2LWS_Authenticate $auth
     * @return D2LWS_Instance fluent interface
     */
    public function setAuthManager(D2LWS_Authenticate $auth)
    {
        $this->_authObj = $auth;
        return $this;
    }
    
    /**
     * Convenience method for D2LWS_Authenticate::getToken()
     * @return string - Authentication Token
     */
    public function getAuthToken()
    {
        return $this->getAuthManager()->getToken();
    }

}

// If requested, use our own internal autoloader
// This is not necessary if we are integrating with a
// Zend_Application-based web portal, as it has it's
// own internal autoloader we can hook into
if ( D2LWS_MANUAL_AUTOLOADER )
{
    spl_autoload_register(function($class){
        require_once D2LWS_BASE
            . DIRECTORY_SEPARATOR
            . ".."
            . DIRECTORY_SEPARATOR
            . preg_replace("|[^a-z0-9-.]|i", DIRECTORY_SEPARATOR, $class)
            . ".php";
    });
}