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
 * OrgUnit API
 */
class D2LWS_OrgUnit_API extends D2LWS_Common
{

    public function getChildrenOf($ouid)
    {
        $i = $this->getInstance();        
        
        $result = new stdClass();
        $ChildOrgUnits = array();
        foreach ( array('CourseTemplate', 'CourseOffering', 'Group', 'Section', 'Department', 'Semester') as $Type )
        {
            $Function = "GetChild{$Type}s";
            $InfoField = "{$Type}Info";
            
            $typeResult = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->$Function(array(
                    'OrgUnitId'=>array(
                        'Id'=>$ouid,
                        'Source'=>'Desire2Learn'
                    )
                ));
            
            if ( $typeResult instanceof stdClass && isset($typeResult->ChildOrgUnits) && isset($typeResult->ChildOrgUnits->$InfoField) )
            {
                // Inconsistency: If only a single child is returned, $InfoField is not an array
                if ( !is_array($typeResult->ChildOrgUnits->$InfoField) )
                {
                    $typeResult->ChildOrgUnits->$InfoField = array($typeResult->ChildOrgUnits->$InfoField);
                }
                
                foreach ( $typeResult->ChildOrgUnits->$InfoField as $ouObj )
                {
                    $ouObj->OrgUnitRole = $Type;
                    $ChildOrgUnits[] = $ouObj;
                }
            }
        }
        

        $Children = array();        
        if ( count($ChildOrgUnits) > 0 )
        {
            
            foreach ( $ChildOrgUnits as $OUI )
            {
                $subid = $OUI->OrgUnitId->Id;
                $ouAPI = $this->getSubtypeAPI($OUI->OrgUnitRole);
                if ( $ouAPI instanceof D2LWS_Common )
                {
                    // Create a new instance of the model for this Org Unit type
                    // We already have the data to build it, so why not...
                    $className = preg_replace("/_API$/i", "_Model", get_class($ouAPI));
                    $Children[$subid] = new $className($OUI);
                }
                else
                {
                    var_dump($result);
                    die();
                }
            }
        }
        
        return $Children;
    }

    public function getSubtypeAPI($type)
    {
        $type = preg_replace("/[^a-z0-9]/i", "", $type);
        if ( strlen($type) > 0 )
        {
            $Class = preg_replace("/_API$/", "_{$type}_API", __CLASS__);
            if ( class_exists($Class) && is_subclass_of($Class, "D2LWS_Common") )
            {
                $api = new $Class($this->getInstance());
                return $api;
            }
        }
        
        return NULL;
    }
    
}