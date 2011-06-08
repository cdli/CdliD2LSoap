<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/adamlundrigan/zfD2L/blob/master/LICENSE
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
 * Grade Object API
 */
class D2LWS_Grade_Object_API extends D2LWS_Common
{

    /**
     * Default Constructor
     * @param $i D2LWS_Instance - Instance to assign
     */
    public function __construct(D2LWS_Instance $i = NULL)
    {
        parent::__construct($i);
    }

    /**
     * Loadd all grade objects for a specific org unit
     * @param int|D2LWS_OrgUnit_<type>_Model $ou
     * @return array<D2LWS_Grade_Object_Model>
     * @throws D2LWS_Grade_Object_Exception_InvalidArgument
     * @throws D2LWS_Grade_Object_Exception_NotFound
     * @throws D2LWS_Grade_Object_Exception_MalformedResponse
     */
    public function findAllByOrgUnit($ou)
    {
        $i = $this->getInstance();

        if ( is_object($ou) && method_exists($ou, "getID") )
        {
            $ou = $ou->getID();
        }
        else
        {
            throw new D2LWS_Grade_Object_Exception_InvalidArgument();
        }

        //TODO: Handle exceptions from SOAP client?
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.grade.wsdl'))
            ->setLocation($i->getConfig('webservice.grade.endpoint'))
            ->GetGradeObjectsByOrgUnit(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($ou),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->GradeObjects) && $result->GradeObjects instanceof stdClass )
        {
            if ( isset($result->GradeObjects->GradeObjectInfo) && is_array($result->GradeObjects->GradeObjectInfo) )
            {
                if ( count($result->GradeObjects->GradeObjectInfo) > 0 )
                {
                    // Compose into array of domain model objects
                    $ResultSet = array();
                    foreach ( $result->GradeObjects->GradeObjectInfo as $item )
                    {
                        $ResultSet[] = new D2LWS_Grade_Object_Model($item);
                    }

                    // return it!
                    return $ResultSet;
                }
                else
                {
                    //TODO: More description error message?
                    throw new D2LWS_Grade_Object_Exception_NotFound('OrgUnitID=' . $ou);
                }
            }
            else
            {
                //TODO: More description error message?
                throw new D2LWS_Grade_Object_Exception_MalformedResponse("GradeObjectInfo not array");
            }
        }
        else
        {
            //TODO: More description error message?
            throw new D2LWS_Grade_Object_Exception_NotFound('OrgUnitID=' . $ou);
        }
    }
    
}