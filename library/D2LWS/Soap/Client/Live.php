<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
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
 * SOAP Client
 */
class D2LWS_Soap_Client_Live implements D2LWS_Soap_Client
{
    /**
     * D2LWS Instance
     * @type D2LWS_Instance
     */
    protected $_instance = NULL;
    
    protected $_constructorArgs = array();
    
    protected $_wsdl;
    
    protected $_location;
    
    protected $_clients = array();
    
    /**
     * Default constructor for SOAP client
     * @param $wsdl string - WSDL file
     * @param $options array - Options
     */
    public function __construct($wsdl = NULL, $options = NULL)
    {
        $this->_constructorArgs = array(
            'wsdl' => $wsdl,
            'options' => $options
        );
    }    

    /**
     * Invoke method on remote server
     * @param string $method
     * @param array $args
     * @return mixed Result of remote call
     */
    public function __call($method, $args)
    {
        $clientKey = md5($this->getWsdl() . "@" . $this->getLocation());
        if ( !isset($this->_clients[$clientKey]) ) {
            $this->_clients[$clientKey] = new D2LWS_Soap_Client_Live_Client(
                $this->_constructorArgs['wsdl'],
                $this->_constructorArgs['options']
            );
            $this->_clients[$clientKey]->setInstance($this->getInstance());
            
            if ($this->getLocation()) {
                $this->_clients[$clientKey]->setLocation($this->getLocation());
            }
            if ($this->getWsdl()) {
                $this->_clients[$clientKey]->setWsdl($this->getWsdl());
            }
        }
        return $this->_clients[$clientKey]->__call($method, $args);
    }

    public function setLocation($location)
    {
        $this->_location = $location;
        return $this;
    }
    public function getLocation()
    {
        return $this->_location;
    }

    public function setWsdl($wsdl)
    {
        $this->_wsdl = $wsdl;
        return $this;
    }
    
    public function getWsdl()
    {
        return empty($this->_wsdl) 
                ? $this->_constructorArgs['wsdl']
                : $this->_wsdl;
    }
    
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
