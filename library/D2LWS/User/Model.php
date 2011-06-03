<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: Model.php 17 2011-02-02 19:44:24Z adamlundrigan $
 *
 */
 
/**
 * User Account Model
 */
class D2LWS_User_Model
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
     * Get D2L User ID
     * @return int - D2L User ID
     */
    public function getUserID() { return @$this->_data->UserId->Id ?: NULL; }
    
    /**
     * Set D2L User ID
     * @param $uid int - UserID
     * @return $this
     */
    public function setUserID($uid) { @$this->_data->UserId->Id = $uid; return $this; }
    
    /**
     * Get Username
     * @return string - Username
     */
    public function getUserName() { return @$this->_data->UserName->_ ?: NULL; }
    
    /**
     * Set Username
     * @param $uname string - Username
     * @return $this
     */
    public function setUserName($uname) { @$this->_data->UserName->_ = $uname; return $this; }
    
    /**
     * Get Org Defined ID
     * @return string - Org Defined ID
     */
    public function getOrgDefinedID() { return @$this->_data->OrgDefinedId->_ ?: NULL; }
    
    /**
     * Set Org Defined ID
     * @param $orgid mixed - Org Defined ID
     * @return $this
     */
    public function setOrgDefinedID($orgid) { @$this->_data->OrgDefinedId->_ = $orgid; return $this; }
    
    /**
     * Get Role ID
     * @return string - Role ID
     */
    public function getRoleID() { return @$this->_data->RoleId->_ ?: NULL; }
    
    /**
     * Set Role ID
     * @param $roleid mixed - Role ID
     * @return $this
     */
    public function setRoleID($roleid) { @$this->_data->RoleId->_ = $roleid; return $this; }
    
    /**
     * Get Password
     * @return string - Password
     */
    public function getPassword() { return @$this->_data->Password->_ ?: NULL; }
    
    /**
     * Set Password
     * @param $pword string - Password
     * @return $this
     */
    public function setPassword($pword) { @$this->_data->Password->_ = $pword; return $this; }
    
    /**
     * Get First Name
     * @return string - First Name
     */
    public function getFirstName() { return @$this->_data->FirstName->_ ?: NULL; }
    
    /**
     * Set First Name
     * @param $fname string - First Name
     * @return $this
     */
    public function setFirstName($fname) { @$this->_data->FirstName->_ = $fname; return $this; }
        
    /**
     * Get Last Name
     * @return string - Last Name
     */
    public function getLastName() { return @$this->_data->LastName->_ ?: NULL; }
    
    /**
     * Set Last Name
     * @param $lname string - Last Name
     * @return $this
     */
    public function setLastName($lname) { @$this->_data->LastName->_ = $lname; return $this; }
        
    /**
     * Get Email Address
     * @return string - Email Address
     */
    public function getEmailAddress() { return @$this->_data->FormsOfContact->FormOfContactInfo->Value; }
    
    /**
     * Set Email Address
     * @param $email string - Email Address
     * @return $this
     */
    public function setEmailAddress($email) 
    {
        @$this->_data->FormsOfContact->FormOfContactInfo->Type = 'Email';
        @$this->_data->FormsOfContact->FormOfContactInfo->Name = 'ExternalEmail';
        @$this->_data->FormsOfContact->FormOfContactInfo->Value = $email;
        return $this; 
    }
    
    /**
     * Get Gender
     * @return string - Gender
     */
    public function getGender() { return ( isset($this->_data->Demographics->Gender->_) ? $this->_data->Demographics->Gender->_ : 'Unknown' ); }
    
    /**
     * Set Gender
     * @param $gender string - Gender
     * @return $this
     */
    public function setGender($gender) 
    {
        @$this->_data->Demographics->Gender->_ = $gender; return $this; 
    }
    
    /**
     * Get Birth Date
     * @return int - Birth Date
     */
    public function getBirthDate() { return ( isset($this->_data->Demographics->BirthDate->_) ? @$this->_data->Demographics->BirthDate->_ : 0 ); }
    
    /**
     * Set Birth Date
     * @param $BirthDate int - Birth Date
     * @return $this
     */
    public function setBirthDate($BirthDate) { @$this->_data->Demographics->BirthDate->_ = $BirthDate; return $this; }
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return @$this->_data; }
}