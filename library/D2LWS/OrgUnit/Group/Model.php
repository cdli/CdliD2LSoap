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
 * Group Model
 */
class D2LWS_OrgUnit_Group_Model extends D2LWS_OrgUnit_Model
{
    protected $OUTYPE = "Group";
    protected $OUDESC = "Group";
    
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
        
        $this->_data->GroupTypeId = new stdClass();
        $this->_data->GroupTypeId->Id = NULL;
        $this->_data->GroupTypeId->Source = 'Desire2Learn';

        $this->_data->OwnerOrgUnitId = new stdClass();
        $this->_data->OwnerOrgUnitId->Id = NULL;
        $this->_data->OwnerOrgUnitId->Source = 'Desire2Learn';
        
        $this->_data->Description = new stdClass();
        $this->_data->Description->Text = "";
        $this->_data->Description->IsHtml = 1;
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
    public function isDescriptionHTML() { return $this->_data->Description->IsHtml; }
    
    /**
     * Set the IsHtml flag for Description field
     * @param $tf bool - true=HTML, false=plain
     * @return $this
     */
    public function setIsDescriptionHTML($tf) { $this->_data->Description->IsHtml = ($tf==true); return $this; }
    
    /**
     * Retrieve ID of Group Type which contains this group
     * @return int
     */
    public function getGroupTypeID()
    {
        return $this->_data->GroupTypeId->Id;
    }
    
    /**
     * Set the ID of Group Type which contains this group
     * @param int $ouid
     * @return $this 
     */
    public function setGroupTypeID($ouid)
    {
        $this->_data->GroupTypeId->Id = is_null($ouid) ? NULL : intval($ouid);
        return $this;   
    }  
    
    /**
     * Get the ID of OrgUnit which owns this group
     * @return int
     */
    public function getOwnerOrgUnitID()
    {
        return $this->_data->OwnerOrgUnitId->Id;
    }
    
    /**
     * Set the ID of OrgUnit which owns this group
     * @param int $ouid
     * @return $this 
     */
    public function setOwnerOrgUnitID($ouid)
    {
        $this->_data->OwnerOrgUnitId->Id = is_null($ouid) ? NULL : intval($ouid);
        return $this;   
    }  

}