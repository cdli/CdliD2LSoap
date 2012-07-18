<?php
/**
 * CdliD2LSoap - PHP5 Wrapper for Desire2Learn Web Services
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
 * PHPUnit test for D2LWS_Grade_Object_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_Grade
 * @group D2LWS_Grade_Object
 */
class D2LWS_Grade_Object_APITest extends GenericTestCase
{
    
    /**
     * Load all grade objects by org unit
     */
    public function testFindAllByOrgUnit()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an array of GradeObject records when
        // the specified OrgUnitID exists in D2L and has grade objects
        $mock->getSoapClient()->addCallback("GradesManagement", "GetGradeObjectsByOrgUnit",
            function($args) {            
                $result = new stdClass();
                $result->GradeObjects = new stdClass();
                $result->GradeObjects->GradeObjectInfo = array();
                
                for ( $i = 0; $i < 3; $i++ ) {
                    $modelObj = new D2LWS_Grade_Object_Model();                
                    $mockObj = $modelObj->getRawData();
                    $mockObj->OrgUnitId->Id = $args['OrgUnitId']['Id'];
                    $mockObj->OrgUnitId->Source = $args['OrgUnitId']['Source'];
                    $result->GradeObjects->GradeObjectInfo[] = $mockObj;
                }
                
                return $result;
            }
        );

        // Set up the OrgUnit
        $ou = new D2LWS_OrgUnit_CourseOffering_Model();
        $ou->setID(9999);
        
        // Find the grade objects
        $apiGObj = new D2LWS_Grade_Object_API($mock);
        $gObjSet = $apiGObj->findAllByOrgUnit($ou);

        $this->assertInternalType('array', $gObjSet);
        $this->assertContainsOnly('D2LWS_Grade_Object_Model', $gObjSet);
        $this->assertEquals(3, count($gObjSet));
    }
    
    /**
     * Load all grade objects by org unit
     * @expectedException D2LWS_Grade_Object_Exception_MalformedResponse
     * @todo Should zero results really throw an exception?
     */
    public function testFindAllByOrgUnitWhenOrgUnitHasNoGradeObjects()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an array of GradeObject records when
        // the specified OrgUnitID exists in D2L and has grade objects
        $mock->getSoapClient()->addCallback("GradesManagement", "GetGradeObjectsByOrgUnit",
            function($args) {            
                $result = new stdClass();
                $result->GradeObjects = new stdClass();                
                return $result;
            }
        );

        // Set up the OrgUnit
        $ou = new D2LWS_OrgUnit_CourseOffering_Model();
        $ou->setID(9999);
        
        // Find the grade objects
        $apiGObj = new D2LWS_Grade_Object_API($mock);
        $gObjSet = $apiGObj->findAllByOrgUnit($ou);
    }
    
    /**
     * Load all grade objects by org unit
     * @expectedException D2LWS_Grade_Object_Exception_InvalidArgument
     */
    public function testFindAllByOrgUnitWhenInstanceOfStdClassIsPassed()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();
    
        // Find the grade objects
        $apiGObj = new D2LWS_Grade_Object_API($mock);
        $gObjSet = $apiGObj->findAllByOrgUnit(new stdClass());        
    }
    
    /**
     * Load all grade objects by org unit
     * @expectedException D2LWS_Grade_Object_Exception_InvalidArgument
     */
    public function testFindAllByOrgUnitWhenNonObjectIsPassed()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();
        $mock->getSoapClient()->addCallback("GradesManagement", "GetGradeObjectsByOrgUnit",
            function($args) {}
        );
     
        // Find the grade objects
        $apiGObj = new D2LWS_Grade_Object_API($mock);
        $gObjSet = $apiGObj->findAllByOrgUnit('OhNoItsAString!'); 
    }
    
}