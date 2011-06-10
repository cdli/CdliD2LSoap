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
 * Role Model
 */
class D2LWS_Role_Model extends D2LWS_Abstract_Model
{

    /**
     * Initialize Default Data Structure
     */
    public function init() {}
    
    /**
     * Get D2L Role ID
     * @return int - D2L Role ID
     */
    public function getRoleID() { return $this->_data->RoleId->Id; }
    
    /**
     * Set D2L Role ID
     * @param $uid int - RoleID
     * @return $this
     */
    public function setRoleID($uid) { $this->_data->RoleId->Id = $uid; return $this; }
    
    /**
     * Get Rolename
     * @return string - Rolename
     */
    public function getRoleName() { return $this->_data->Name; }
    
    /**
     * Set Rolename
     * @param $uname string - Rolename
     * @return $this
     */
    public function setRoleName($uname) { $this->_data->Name = $uname; return $this; }
        
    /**
     * Get Role Code
     * @return string - Role Code
     */
    public function getRoleCode() { return $this->_data->Code; }
    
    /**
     * Set Role Code
     * @param $code mixed - Role Code
     * @return $this
     */
    public function setRoleCode($code) { $this->_data->Code = $code; return $this; }
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return $this->_data; }
}