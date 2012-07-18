<?php
/**
 * CdliD2LSoap - PHP5 Wrapper for Desire2Learn Web Services
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