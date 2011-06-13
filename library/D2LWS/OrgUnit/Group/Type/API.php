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
 * Group Type API
  */
class D2LWS_OrgUnit_Group_Type_API extends D2LWS_Common
{
        
    public function findByID($GroupID, $OwnerID)
    {
        $i = $this->getInstance();        

        try
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->GetGroupType(array(
                    'GroupTypeId'=>array(
                        'Id'=>intval($GroupID),
                        'Source'=>'Desire2Learn'
                    ),
                    'OwnerOrgUnitId'=>array(
                        'Id'=>intval($OwnerID),
                        'Source'=>'Desire2Learn'
                    )
                ));
            if ( $result instanceof stdClass && isset($result->GroupType) && $result->GroupType instanceof stdClass )
            {
                $GroupType = new D2LWS_OrgUnit_Group_Type_Model($result->GroupType);
                return $GroupType;
            }
        }
        catch ( D2LWS_Soap_Client_Exception $ex ) 
        {
        }

        throw new D2LWS_OrgUnit_Group_Type_Exception_NotFound("GroupId={$GroupID}, OwnerID={$OwnerID}");
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
     * @param D2LWS_OrgUnit_Group_Type_Model $gt
     * @return bool success?
     */
    public function save(D2LWS_OrgUnit_Group_Type_Model &$gt)
    {
        $i = $this->getInstance();     
        $arr = $this->_makeRequestStruct($gt);        
        
        if ( is_null($gt->getID()) )
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateGroupType($arr);
            
            if ( $result instanceof stdClass && isset($result->GroupType) && $result->GroupType instanceof stdClass )
            {
                $gt = new D2LWS_OrgUnit_Group_Type_Model($result->GroupType);
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
     * Delete Group Type from D2L
     * @param D2LWS_OrgUnit_Group_Type_Model $gt
     * @return type 
     */
    public function delete(D2LWS_OrgUnit_Group_Type_Model $gt)
    {
        if ( !is_null($gt->getID()) )
        {
            $i = $this->getInstance();
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->DeleteGroupType(array(
                    'GroupTypeId'=>array(
                        'Id'=>$gt->getID(),
                        'Source'=>'Desire2Learn'
                    ),
                    'OwnerOrgUnitId'=>array(
                        'Id'=>$gt->getOwnerOrgUnitID(),
                        'Source'=>'Desire2Learn'
                    )
                ));
            
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