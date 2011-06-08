<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Course Offering OU Model
 */
class D2LWS_OrgUnit_CourseOffering_Model extends D2LWS_OrgUnit_Model
{
    protected $OUTYPE= "CourseOffering";
    protected $OUDESC = "Course Offering";
    
    /**
     * Initialize Default Data Structure
     */
    public function init() 
    {
        parent::init();
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
     * Determine if this course offering is open for new registrations
     * @return boolean - True if open, false otherwise
     */
    public function canRegister() { return $this->_data->CanRegister; }
    
    /**
     * Set the 'CanRegister' flag
     * @param $tf boolean - True for yes, false otherwise
     * @return $this
     */
    public function setCanRegister($tf) { $this->_data->CanRegister = $tf; return $this; }   
     
    /**
     * Determine if this course offering allows sections
     * @return boolean - True if yes, false otherwise
     */
    public function allowsSections() { return $this->_data->AllowSections; }
    
    /**
     * Set the 'AllowSections' flag
     * @param $tf boolean - True for yes, false otherwise
     * @return $this
     */
    public function setAllowSections($tf) { $this->_data->AllowSections = $tf; return $this; }   

}