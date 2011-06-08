<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Group Type API
  */
class D2LWS_OrgUnit_Group_Type_API extends D2LWS_Common
{
        
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetGroup(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->Group) && $result->Group instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Group_Model($result->Group);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Group_Exception_NotFound('Id=' . $id);
        }
    }
    
    public function getTypesByOrgUnitID($ouid)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetGroupTypes(array(
                'OwnerOrgUnitId'=>array(
                    'Id'=>intval($ouid),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->GroupTypes) && $result->GroupTypes instanceof stdClass )
        {
            $ResultSet = array();
            if ( !is_array(@$result->GroupTypes->GroupTypeInfo) )
            {
                $result->GroupTypes->GroupTypeInfo = array(
                    @$result->GroupTypes->GroupTypeInfo
                );
            }
            
            if ( count($result->GroupTypes->GroupTypeInfo) > 0 )
            {
                foreach ( $result->GroupTypes->GroupTypeInfo as $GroupType )
                {
                    if ( $GroupType instanceof stdClass )
                    {
                        $ResultSet[$GroupType->GroupTypeId->Id] = 
                            new D2LWS_OrgUnit_Group_Type_Model($GroupType);
                    }
                }
            }
            
            return $ResultSet;
        }
        else
        {
            throw new D2LWS_OrgUnit_Group_Type_Exception_NotFound('OwnerOrgUnitId=' . $ouid);
        }   
    }
 
    /**
     * Save Group Type to D2L
     * @param D2LWS_OrgUnit_Group_Type_Model $u
     * @return bool success?
     */
    public function save(D2LWS_OrgUnit_Group_Type_Model &$u)
    {
        $i = $this->getInstance();     
        $arr = $this->_makeRequestStruct($u);        
        
        if ( is_null($u->getID()) )
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateGroupType($arr);
            
            if ( $result instanceof stdClass && isset($result->GroupType) && $result->GroupType instanceof stdClass )
            {
                $u = new D2LWS_OrgUnit_Group_Type_Model($result->GroupType);
                return true;
            }
        }
        else
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->UpdateGroupType($arr);
            
            return ( $result instanceof stdClass );
        }
        
        return false;
    }
    
    /**
     * Reindex result set by item name
     * @param array $set
     * @return array
     */
    public function reindexByName($set)
    {
        $newSet = array();
        if ( count($set) > 0 )
        {
            foreach ( $set as $item )
            {
                $newSet[$item->getName()] = $item;
            }
        }
        return $newSet;
    }

    /**
     * Create SOAP Request datastructure from model
     * @param D2LWS_OrgUnit_Group_Type_Model $u
     * @return stdClass Request Structure
     */
    protected function _makeRequestStruct(D2LWS_OrgUnit_Group_Type_Model $u)
    {
        $result = new stdClass();
        $result->Name = $u->getName();
        
        $result->OwnerOrgUnitId = new stdClass();
        $result->OwnerOrgUnitId->Id = $u->getOwnerOrgUnitID();
        $result->OwnerOrgUnitId->Source = 'Desire2Learn';
        
        $result->Description = new stdClass();
        $result->Description->Text = $u->getDescription();
        $result->Description->IsHtml = $u->isDescriptionHTML();
        
        //TODO: Set up model methods for these
        $result->EnrollmentQuantity = 0;
        $result->IsAutoEnroll = false;
        $result->RandomizeEnrollments = false;
        $result->EnrollmentStyle = 'Manual';

        // If there is an ID, format request as update
        if ( !is_null($u->getID()) )
        {
            $updateResult = new stdClass();
            $updateResult->GroupType = $result;
            $updateResult->GroupType->GroupTypeId = new stdClass();
            $updateResult->GroupType->GroupTypeId->Id = $u->getID();
            $updateResult->GroupType->GroupTypeId->Source = 'Desire2Learn';
            return $updateResult;
        }
        
        return $result;
    }
}