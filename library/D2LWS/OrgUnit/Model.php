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
abstract class D2LWS_OrgUnit_Model
{
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return $this->_data; }
    
    public function getOrgUnitTypeID() { return $this->OUTYPE; }
    public function getOrgUnitTypeDesc() { return $this->OUDESC; }
    
}