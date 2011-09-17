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

        $this->_data = new stdClass();
        
        $this->_data->OrgUnitId = new stdClass();;        
        $this->_data->OrgUnitId->Id = NULL;
        $this->_data->OrgUnitId->Source = 'Desire2Learn';
        
        $this->_data->TemplateId = new stdClass();;        
        $this->_data->TemplateId->Id = NULL;
        $this->_data->TemplateId->Source = 'Desire2Learn';
        
        $this->_data->Name = '';
        $this->_data->Code = '';
        $this->_data->Path = '';
        $this->_data->IsActive = false;
        $this->_data->StartDate = '2008-08-08T08:08:08';
        $this->_data->EndDate = '2009-08-08T08:08:08';
        $this->_data->CanRegister = false;
        $this->_data->AllowSections = false;
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
     * Get Course Template OUID
     * @return int
     */
    public function getTemplateID() { return $this->_data->TemplateId->Id; }

    /**
     * Set Course Template OUID
     * @param int $id Template OUID
     * @return $this
     */
    public function setTemplateID($id) { $this->_data->TemplateId->Id = $id; return $this; }
    
    /**
     * Get Course Template Source
     * @return string 
     */
    public function getTemplateSource() { return $this->_data->TemplateId->Source; }
    
    /**
     * Set Course Template Source
     * @param string $source Template Source
     * @return $this
     */
    public function setTemplateSource($source) { $this->_data->TemplateId->Source = $source; return $this; }
    
    /**
     * Set Course Template
     * @param D2LWS_OrgUnit_CourseTemplate_Model $tpl Template
     * @return $this;
     */
    public function setTemplate(D2LWS_OrgUnit_CourseTemplate_Model $tpl)
    {
        $this->setTemplateID($tpl->getID());
        $this->setTemplateSource('Desire2Learn');
        return $this;
    }
    
    /**
     * Determine if this department is active
     * @return boolean - True if active, false otherwise
     */
    public function isActive() { return ($this->_data->IsActive==true); }
    
    /**
     * Set the 'active' flag
     * @param $tf boolean - True=active, false=inactive
     * @return $this
     */
    public function setIsActive($tf) { $this->_data->IsActive = ($tf==true); return $this; }   
    
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
    public function canRegister() { return ($this->_data->CanRegister==true); }
    
    /**
     * Set the 'CanRegister' flag
     * @param $tf boolean - True for yes, false otherwise
     * @return $this
     */
    public function setCanRegister($tf) { $this->_data->CanRegister = ($tf==true); return $this; }   
     
    /**
     * Determine if this course offering allows sections
     * @return boolean - True if yes, false otherwise
     */
    public function allowsSections() { return ($this->_data->AllowSections==true); }
    
    /**
     * Set the 'AllowSections' flag
     * @param $tf boolean - True for yes, false otherwise
     * @return $this
     */
    public function setAllowSections($tf) { $this->_data->AllowSections = ($tf==true); return $this; }   

}