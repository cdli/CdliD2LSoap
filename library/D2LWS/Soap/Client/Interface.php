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
 * SOAP Client Interface
 */
interface D2LWS_Soap_Client_Interface
{
    /**
     * Default constructor for SOAP client
     * @param $wsdl string - WSDL file
     * @param $options array - Options
     */
    public function __construct($wsdl = NULL, $options = NULL);

    /**
     * Invoke method on remote server
     * @param string $method
     * @param array $args
     * @return mixed Result of remote call
     */
    public function __call($method, $args);

    public function setLocation($location);
    public function getLocation();

    public function setWsdl($wsdl);
    public function getWsdl();

    /**
     * Set D2LWS instance
     * @param $inst Instance to assign
     * @return $this
     */
    public function setInstance(D2LWS_Instance $inst);

    /**
     * Get D2LWS instance
     * @return D2LWS instance
     */
    public function getInstance();
}