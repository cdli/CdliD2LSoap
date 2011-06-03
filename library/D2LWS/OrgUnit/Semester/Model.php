<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Semester OU Model
 */
class D2LWS_OrgUnit_Semester_Model
{
    const OUTYPE = "Semester";
    
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
     * Retrieve the organization identifier (OrgUnitID)
     * @return integer - Org Unit ID
     */
    public function getID() { return $this->_data->OrgUnitId->Id; }
    
    /**
     * Set the organization identifier (OrgUnitID)
     * @param $id integer - Identifier
     * @return $this
     */
    public function setID($id) { $this->_data->OrgUnitId->Id = intval($id); return $this; }

    /**
     * Retrieve the organization name
     * @return string - Name
     */
    public function getName() { return $this->_data->Name; }
    
    /**
     * Set the organization name
     * @param $name string - Name
     * @return $this
     */
    public function setName($name) { $this->_data->Name = $name; return $this; }

    /**
     * Retrieve the organization code
     * @return string - Code
     */
    public function getCode() { return $this->_data->Code; }
    
    /**
     * Set the organization code
     * @param $code string - Code
     * @return $this
     */
    public function setCode($code) { $this->_data->Code = $code; return $this; }

    /**
     * Retrieve the organization path
     * @return string - Path
     */
    public function getPath() { return $this->_data->Path; }
    
    /**
     * Set the organization path
     * @param $path string - Path
     * @return $this
     */
    public function setPath($path) { $this->_data->Path = $path; return $this; }   

    /**
     * Determine if this department is active
     * @return boolean - True if active, false otherwise
     */
    public function isActive() { return $this->_data->IsActive; }
    
    /**
     * Set the 'active' flag
     * @param $tf boolean - True=active, false=inactive
     * @return $this
     */
    public function setIsActive($tf) { $this->_data->IsActive = $tf; return $this; }   
    
    /**
     * Retrieve the organization start date
     * @return timestamp - Start Date
     */
    public function getStartDate() { return $this->_data->StartDate; }
    
    /**
     * Set the organization start date
     * @param $sDate timestamp - Start Date (YYYY-mm-ddTHH:MM:SS)
     * @return $this
     */
    public function setStartDate($sDate) { $this->_data->StartDate = $sDate; return $this; }  
    
    /**
     * Retrieve the organization end date
     * @return timestamp - End Date
     */
    public function getEndDate() { return $this->_data->EndDate; }
    
    /**
     * Set the organization end date
     * @param $eDate timestamp - End Date (YYYY-mm-ddTHH:MM:SS)
     * @return $this
     */
    public function setEndDate($eDate) { $this->_data->EndDate = $eDate; return $this; }  
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return $this->_data; }
    
    public function getOrgUnitTypeID() { return self::OUTYPE; }
    public function getOrgUnitTypeDesc() { return "Semester"; }
}