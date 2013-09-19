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
 * User Account Model
 */
class D2LWS_User_Model extends D2LWS_Abstract_Model
{

    /**
     * Initialize Default Data Structure
     */
    public function init() 
    {
        $this->_data = new stdClass();
        $this->_data->UserId = new stdClass();

        $this->_data->UserId->Id = 0;
        $this->_data->UserId->Source = "Desire2Learn";

        $this->_data->UserName = new stdClass();
        $this->_data->UserName->_ = "";

        $this->_data->OrgDefinedId = new stdClass();
        $this->_data->OrgDefinedId->_ = 0;

        $this->_data->RoleId = new stdClass();
        $this->_data->RoleId->_ = 0;

        $this->_data->Password = new stdClass();
        $this->_data->Password->_ = "";

        $this->_data->FirstName = new stdClass();
        $this->_data->FirstName->_ = "";

        $this->_data->LastName = new stdClass();
        $this->_data->LastName->_ = "";

        $this->_data->FormsOfContact = new stdClass();
        $this->_data->FormsOfContact->FormOfContactInfo = new stdClass();
        $this->_data->FormsOfContact->FormOfContactInfo->Type = '';
        $this->_data->FormsOfContact->FormOfContactInfo->Name = '';
        $this->_data->FormsOfContact->FormOfContactInfo->Value = '';

        $this->_data->Demographics = new stdClass();
        $this->_data->Demographics->Gender = new stdClass();
        $this->_data->Demographics->Gender->_ = 'Unknown';
        $this->_data->Demographics->BirthDate = new stdClass();
        $this->_data->Demographics->BirthDate->_ = '0001-01-01T00:00:00-00:00';
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
    public function getGender() 
    { 
        if ( isset($this->_data->Demographics->Gender->_) ) {
            return $this->_data->Demographics->Gender->_;
        } elseif ( isset($this->_data->Demographics->Gender) ) {
            return $this->_data->Demographics->Gender;
        } else {
            return 'Unknown';
        }
    }
    
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
     * @return string - Birth Date (YYYY-mm-ddTHH:mm:ss+ZZ:ZZ)
     */
    public function getBirthDate()
    {
        if ( isset($this->_data->Demographics->BirthDate->_) ) {
            return $this->_data->Demographics->BirthDate->_;
        } elseif ( isset($this->_data->Demographics->BirthDate) ) {
            return $this->_data->Demographics->BirthDate;
        } else {
            return 0;
        }
    }
    
    /**
     * Set Birth Date
     * @param $BirthDate int|string - Birth Date
     * @return $this
     */
    public function setBirthDate($BirthDate) 
    {
        // If given a numerical timestamp, convert it
        if (preg_match("/^[0-9]+$/i", trim($BirthDate))) {
            $BirthDate = date("Y-m-d\TH:i:sP", $BirthDate);
        }
        @$this->_data->Demographics->BirthDate->_ = $BirthDate; return $this; 
    }
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return @$this->_data; }
}
