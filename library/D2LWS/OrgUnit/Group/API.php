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
 * Group OU API
 */
class D2LWS_OrgUnit_Group_API extends D2LWS_Common
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
            $Group = new D2LWS_OrgUnit_Group_Model($result->Group);
            return $Group;
        }
        else
        {
            throw new D2LWS_OrgUnit_Group_Exception_NotFound('Id=' . $id);
        }
    }
        
    /**
     * Find Group by Code
     * @param string $code
     * @return D2LWS_OrgUnit_Group_Model 
     */
    public function findByCode($code)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetGroupByCode(array(
                'Code'=>$code
            ));
        
        if ( $result instanceof stdClass && isset($result->Group) && $result->Group instanceof stdClass )
        {
            $Group = new D2LWS_OrgUnit_Group_Model($result->Group);
            return $Group;
        }
        else
        {
            throw new D2LWS_OrgUnit_Group_Exception_NotFound('Code=' . $code);
        }
    }    
 
    /**
     * Save Group to D2L
     * @param D2LWS_OrgUnit_Group_Model $g
     * @return bool success?
     */
    public function save(D2LWS_OrgUnit_Group_Model &$g)
    {
        $i = $this->getInstance();     
        $arr = $this->_makeRequestStruct($g);        
        if ( is_null($g->getID()) )
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateGroup($arr);
            
            if ( $result instanceof stdClass && isset($result->Group) && $result->Group instanceof stdClass )
            {
                $g = new D2LWS_OrgUnit_Group_Model($result->Group);
                return true;
            }
        }
        else
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->UpdateGroup($arr);
            
            return ( $result instanceof stdClass );
        }
        
        return false;
    }    

    /**
     * Create SOAP Request datastructure from model
     * @param D2LWS_OrgUnit_Group_Model $gm
     * @return stdClass Request Structure
     */
    protected function _makeRequestStruct(D2LWS_OrgUnit_Group_Model $gm)
    {
        $result = new stdClass();
        $result->Name = $gm->getName();
        $result->Code = $gm->getCode();
        
        $result->Description = new stdClass();
        $result->Description->Text = $gm->getDescription();
        $result->Description->IsHtml = $gm->isDescriptionHTML();
        
        $result->GroupTypeId = new stdClass();
        $result->GroupTypeId->Id = $gm->getGroupTypeID();
        $result->GroupTypeId->Source = 'Desire2Learn';

        $result->OwnerOrgUnitId = new stdClass();
        $result->OwnerOrgUnitId->Id = $gm->getOwnerOrgUnitId();
        $result->OwnerOrgUnitId->Source = 'Desire2Learn';

        // If there is an ID, format request as update
        if ( !is_null($gm->getID()) )
        {
            $updateResult = new stdClass();
            $updateResult->Group = $result;
            $updateResult->Group->OrgUnitId = new stdClass();
            $updateResult->Group->OrgUnitId->Id = $gm->getID();
            $updateResult->Group->OrgUnitId->Source = 'Desire2Learn';
            return $updateResult;
        }
        
        return $result;
    }
}