<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Group Type Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
class D2LWS_OrgUnit_Group_Type_Model extends D2LWS_OrgUnit_Model
{
    protected $OUTYPE = "GroupType";
    protected $OUDESC = "Group Type";
    
    /**
     * Initialize Default Data Structure
     */
    public function init() 
    {
        parent::init();
        
        $this->_data->GroupTypeId = new stdClass();
        $this->_data->GroupTypeId->Id = NULL;
        $this->_data->GroupTypeId->Source = 'Desire2Learn';
        
        $this->_data->Name = "";
        
        $this->_data->Description = new stdClass();
        $this->_data->Description->Text = "";
        $this->_data->Description->IsHtml = 1;
        
        $this->_data->OwnerIdentifier = new stdClass();
        $this->_data->OwnerIdentifier->OrgUnitId = new stdClass();
        $this->_data->OwnerIdentifier->OrgUnitId->Id = NULL;
        $this->_data->OwnerIdentifier->OrgUnitId->Source = 'Desire2Learn';
        $this->_data->OwnerIdentifier->OrgUnitRole = NULL;
        
         //# of automatic subgroups to create
        $this->_data->EnrollmentQuantity = 0;
        
        $this->_data->IsAutoEnroll = false;
        $this->_data->RandomizeEnrollments = false;
        $this->_data->EnrollmentStyle = 'Manual';        
    }

    /**
     * Retrieve the identifier (GroupTypeId)
     * @return integer - Group Type ID
     */
    public function getID() { return $this->_data->GroupTypeId->Id; }
    
    /**
     * Set the identifier (GroupTypeId)
     * @param $id integer|null - Identifier
     * @return $this
     */
    public function setID($id) 
    {
        $this->_data->GroupTypeId->Id = is_null($id) ? NULL : intval($id);
        return $this;
    }

    /**
     * Retrieve the group type name
     * @return string - Name
     */
    public function getName() { return $this->_data->Name; }
    
    /**
     * Set the group type name
     * @param $name string - Name
     * @return $this
     */
    public function setName($name) { $this->_data->Name = $name; return $this; }

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
     * Retrieve OrgUnitID of Group Type's owner
     * @return int
     */
    public function getOwnerOrgUnitID()
    {
        return $this->_data->OwnerIdentifier->OrgUnitId->Id;
    }
    
    /**
     * Set OrgUnitID of Group Type's owner
     * @param int $ouid
     * @return $this 
     */
    public function setOwnerOrgUnitID($ouid)
    {
        $this->_data->OwnerIdentifier->OrgUnitId->Id = is_null($ouid) ? NULL : intval($ouid);
        return $this;   
    }    
    
    /**
     * Retrieve OrgUnit Role of Group Type's owner
     * @return int
     */
    public function getOwnerOrgUnitRole()
    {
        return $this->_data->OwnerIdentifier->OrgUnitRole;
    }
    
    /**
     * Set Role of Group Type owner OrgUnit
     * @param string $role
     * @return $this 
     */
    public function setOwnerOrgUnitRole($role)
    {
        $this->_data->OwnerIdentifier->OrgUnitRole = $role;
        return $this;
    }
    
    /**
     * Set Owner OrgUnit details from model
     * @param D2LWS_OrgUnit_Model $model 
     * @return $this
     */
    public function setOwner(D2LWS_OrgUnit_Model $model)
    {
        $this->setOwnerOrgUnitID($model->getID());
        $this->setOwnerOrgUnitRole($model->getOrgUnitTypeID());
        return $this;
    }
    
}