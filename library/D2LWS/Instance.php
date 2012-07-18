<?php
/**
 * CdliD2LSoap - PHP5 Wrapper for Desire2Learn Web Services
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/adamlundrigan/zfD2L/blob/master/LICENSE
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
 * Filesystem path where library is installed
 */
define("D2LWS_BASE", __DIR__);

/**
 * Determine whether we should use our own internal autoloader
 */
if ( !defined("D2LWS_MANUAL_AUTOLOADER") ) {
    define("D2LWS_MANUAL_AUTOLOADER", false);
}

/**
 * Server instance
 */
class D2LWS_Instance
{
    /**
     * Configuration Source Data (Paths and Arrays)
     * @type array
     */
    protected $_configSources = array();
    
    /**
     * Configuration storage
     * @type Zend_Config
     */
    protected $_config = NULL;
    
    /**
     * Stores an instance of the SOAP client
     * @type D2LWS_Soap_Client
     */
    protected $_soapObj = NULL;    
    
    /**
     * Stores an instance of the D2L authenticator
     * @type D2LWS_Authenticate
     */
    protected $_authObj = NULL;
    
    /**
     * Create new Desire2Learn Web Service (D2LWS) instance
     * @param $configuration Configuration sources
     */
    public function __construct($configuration)
    {
        $this->_configSources = (array)$configuration;
        $this->loadConfiguration();
    }

    /**
     * Iterate over provided configuration folder locations and load the files,
     * merging them into a single large configuration array
     */
    protected function loadConfiguration()
    {
        $mergedConfig = array();
        $configFileNames = array();

        // Preload the base configuration file, if it exists
        $baseConfigFile = __DIR__ . '/../../configs/defaults.config.php';
        if (is_file($baseConfigFile))
        {
            $this->_config = include_once $baseConfigFile;
        }

        if (!isset($this->_configSources['dirs']) && !isset($this->_configSources['config'])) {
            throw new D2LWS_Exception_MalformedConfiguration('Must specify at least one config source');
        }

        if (isset($this->_configSources['dirs']))
        {
            foreach ( (array)$this->_configSources['dirs'] as $dir ) 
            {
                if (is_dir($dir))
                {
                    $it = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator(
                            $dir,
                            RecursiveDirectoryIterator::SKIP_DOTS
                        ),
                        RecursiveIteratorIterator::CHILD_FIRST
                    );
            
                    $configFiles = array();
                    foreach ( $it as $file ) 
                    {
                        if (preg_match("{\.config\.php$}", $file->getFilename()))
                        {
                            $fileConfig = include_once $file->getRealPath();
                            if ( is_array($fileConfig) )
                            {
                                array_push($configFileNames, $file->getFileName());
                                $configFiles[$file->getFileName()] = $fileConfig;
                            }
                        }
                    }
                }
                elseif (is_file($dir))
                {
                    $dir = realpath($dir);
                    $configFiles[$dir] = include_once $dir;
                }
                else
                {
                    throw new D2LWS_Exception_ConfigurationFileNotFound('Directory not found: ' . $dir);
                }

                ksort($configFiles);
                foreach ( $configFiles as $fileName=>$fileConfig ) 
                {
                    $mergedConfig = array_replace_recursive($mergedConfig, $fileConfig);
                }
            }
        }

        if (isset($this->_configSources['config']) && is_array($this->_configSources['config']))
        {
            $mergedConfig = array_replace_recursive($mergedConfig, $this->_configSources['config']);
        }

        // Merge loaded configuration into global default configuration
        $this->_config = array_replace_recursive($this->_config, $mergedConfig);
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
                if ( isset($val[$p]) )
                {
                    $val = $val[$p];
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
            $options = array(
                'trace'=>1,
                'exceptions'=>1,
            );

            $clientClass = $this->getConfig('adapter');
            if (!empty($clientClass))
            {
                if (!preg_match('/^D2LWS_/', $clientClass))
                {
                    $clientClass = 'D2LWS_Soap_Client_Adapter_'.$clientClass;
                }
                $options['clientClassName'] = $clientClass;
            }

            $this->_soapObj = new D2LWS_Soap_Client_ClientCollection(NULL, $options);
            $this->_soapObj->setInstance($this);
        }
        return $this->_soapObj;
    }

    /**
     * Set SOAP client instance
     * @param D2LWS_Soap_Client $sc
     * @return D2LWS_Instance fluent interface
     */
    public function setSoapClient(D2LWS_Soap_Client $sc)
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
    // Add D2LWS library to the include path
    set_include_path(D2LWS_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . PATH_SEPARATOR . get_include_path());
    
    // Push the D2LWS Autoloader
    spl_autoload_register(function($class){
        if ( preg_match("{^(D2LWS|Zend)_}", $class) ) 
        {
            require_once 
                preg_replace("|[^a-z0-9-.]|i", DIRECTORY_SEPARATOR, $class)
                . ".php";
        }
    });
}
