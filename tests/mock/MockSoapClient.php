<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: Instance.php 10 2011-01-26 18:55:45Z adamlundrigan $
 *
 */

/**
 * Mock SOAP Client
 */
class MockSoapClient extends Zend_Soap_Client implements D2LWS_Soap_Client_Interface
{

    /**
     * Stores registered callbacks
     * @var array
     */
    protected $_callbacks = array();

    /**
     * Default constructor for SOAP client
     * @param $wsdl string - WSDL file
     * @param $options array - Options
     */
    public function __construct($wsdl = NULL, $options = NULL)
    {
    }

    /**
     * Add a mock response to a specific call
     * @param string $service
     * @param string $method
     * @param mixed $callback
     * @return MockSoapClient fluent interface
     */
    public function addCallback($service, $method, $callback)
    {
        if ( !isset($this->_callbacks[$service]) )
            $this->_callbacks[$service] = array();
        $this->_callbacks[$service][$method] = $callback;
        return $this;
    }

    /**
     * Perform a mock SOAP call and return the result
     * @param string $service
     * @param string $method
     * @param array $args
     * @return mixed Result of callback, or false for no callback
     * @throws Exception if no appropriate callback registered
     */
    protected function doCallback($service, $method, $args)
    {
        if ( isset($this->_callbacks[$service][$method]) )
        {
            return call_user_func_array($this->_callbacks[$service][$method], $args);
        }
        else
        {
            echo "No callback registered for {$service}::{$method}";
            throw new Exception("No callback registered for {$service}::{$method}");
        }
    }

    /**
     * Invoke method on remote server
     * @param string $method
     * @param array $args
     * @return mixed Result of remote call
     */
    public function __call($method, $args)
    {
        $wsdlParts = pathinfo($this->getWsdl());
        $service = preg_replace("/Service(-v[0-9.]+$)?$/i", "", $wsdlParts['filename']);
        return $this->doCallback($service, $method, $args);
    }    

    /**
     * D2LWS Instance
     * @type D2LWS_Instance
     */
    protected $_instance = NULL;

    /**
     * Set D2LWS instance
     * @param $inst Instance to assign
     * @return $this
     */
    public function setInstance(D2LWS_Instance $inst)
    {
        $this->_instance = $inst;
        return $this;
    }

    /**
     * Get D2LWS instance
     * @return D2LWS instance
     */
    public function getInstance() { return $this->_instance; }

}