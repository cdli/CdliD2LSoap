<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * OrgUnit Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
abstract class D2LWS_OrgUnit_Model extends D2LWS_Abstract_Model
{
    
    /**
     * Initialize Default Data Structure
     */
    public function init() 
    {
        $this->_data = new stdClass();
    }
    
    /**
     * Return the Org Unit Type
     * @return type 
     */
    public function getOrgUnitTypeID() { return $this->OUTYPE; }
    public function getOrgUnitTypeDesc() { return $this->OUDESC; }
    
}