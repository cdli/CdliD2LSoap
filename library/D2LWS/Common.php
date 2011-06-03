<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

/**
 * Common base class
 */
class D2LWS_Common
{

    /**
     * D2LWS Instance
     * @type D2LWS_Instance
     */
    protected $_instance = NULL;
    
    /**
     * Default Constructor
     * @param $i D2LWS_Instance - Instance to assign
     */
    public function __construct(D2LWS_Instance $i = NULL)
    {
        if ( !is_null($i) ) $this->setInstance($i);
    }
    
    /**
     * Set D2LWS instance
     * @param $inst D2LWS_Instance - Instance to assign
     * @return $this
     */
    public function setInstance(D2LWS_Instance $inst)
    {
        $this->_instance = $inst;
        return $this;
    }
    
    /**
     * Get D2LWS instance
     * @return D2LWS_Instance - D2LWS instance
     */
    public function getInstance() { return $this->_instance; }

}