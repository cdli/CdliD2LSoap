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
 * Section OU Model
 */
class D2LWS_OrgUnit_Section_Model extends D2LWS_OrgUnit_Model
{
    protected $OUTYPE = "Section";
    protected $OUDESC = "Section";
    
    /**
     * Initialize Default Data Structure
     */
    public function init() 
    {
        parent::init();
        
        $this->_data->OrgUnitId = new stdClass();
        $this->_data->OrgUnitId->Id = NULL;
        $this->_data->OrgUnitId->Source = 'Desire2Learn';        
        
        $this->_data->Name = "";
        $this->_data->Code = "";
        
        $this->_data->Description = new stdClass();
        $this->_data->Description->Text = "";
        $this->_data->Description->IsHtml = 1;
        
        $this->_data->CourseOfferingId = new stdClass();
        $this->_data->CourseOfferingId->Id = NULL;
        $this->_data->CourseOfferingId->Source = 'Desire2Learn';
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
     * Retrieve the group type description
     * @return string - Description
     */
    public function getDescription() { return $this->_data->Description->Text; }
    
    /**
     * Set the group type description
     * @param $description string - Description
     * @return $this
     */
    public function setDescription($description) { $this->_data->Description->Text = $description; return $this; }
  
    /**
     * Is Description field in HTML?
     * @return bool
     */
    public function isDescriptionHTML() { return ($this->_data->Description->IsHtml==true); }
    
    /**
     * Set the IsHtml flag for Description field
     * @param $tf bool - true=HTML, false=plain
     * @return $this
     */
    public function setIsDescriptionHTML($tf) { $this->_data->Description->IsHtml = ($tf==true); return $this; }    

    /**
     * Get Course Offering OUID
     * @return int
     */
    public function getCourseOfferingID() { return $this->_data->CourseOfferingId->Id; }

    /**
     * Set Course Offering OUID
     * @param int $id Course Offering OUID
     * @return $this
     */
    public function setCourseOfferingID($id) { $this->_data->CourseOfferingId->Id = $id; return $this; }
    
    /**
     * Get Course Offering Source
     * @return string 
     */
    public function getCourseOfferingSource() { return $this->_data->CourseOfferingId->Source; }
    
    /**
     * Set Course Offering Source
     * @param string $source Course Offering Source
     * @return $this
     */
    public function setCourseOfferingSource($source) { $this->_data->CourseOfferingId->Source = $source; return $this; }
    
    /**
     * Set Course Offering
     * @param D2LWS_OrgUnit_CourseOffering_Model $tpl CourseOffering
     * @return $this;
     */
    public function setCourseOffering(D2LWS_OrgUnit_CourseOffering_Model $tpl)
    {
        $this->setCourseOfferingID($tpl->getID());
        $this->setCourseOfferingSource('Desire2Learn');
        return $this;
    }

}