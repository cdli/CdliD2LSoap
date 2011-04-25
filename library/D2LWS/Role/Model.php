<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: Model.php 5 2011-01-25 16:49:24Z adamlundrigan $
 *
 */

 
/**
 * Role Model
 */
class D2LWS_Role_Model
{

    protected $_data = NULL;
    
    /**
     * Default Constructor
     * @param $soapResponse stdClass - Response from SOAP call
     */
    public function __construct(stdClass $soapResponse = NULL)
    {
        $this->_data = $soapResponse;
    }
    
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
    public function getRoleName() { return $this->_data->RoleName->_; }
    
    /**
     * Set Rolename
     * @param $uname string - Rolename
     * @return $this
     */
    public function setRoleName($uname) { $this->_data->RoleName->_ = $uname; return $this; }
        
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