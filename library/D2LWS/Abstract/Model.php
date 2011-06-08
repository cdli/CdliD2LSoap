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