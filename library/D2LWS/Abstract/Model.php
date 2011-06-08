<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Abstract Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
abstract class D2LWS_Abstract_Model
{
    
    /**
     * SOAP Response Object
     * @var stdClass
     */
    protected $_data = NULL;
    
    /**
     * Default Constructor
     * @param stdClass $default SOAP Response Object
     */
    public function __construct(stdClass $default = NULL)
    {
        // Set up default data structure
        $this->init();
        
        // Override from constructor argument
        $this->_data = (object) array_merge(
            (array) $this->_data,
            (array) $default
        );
    }
    
    /**
     * Function used to set up default data structure
     */
    abstract function init();
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData()
    {
        return $this->_data; 
    }
    
}