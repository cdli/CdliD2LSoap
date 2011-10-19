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
 * PHPUnit test for D2LWS_OrgUnit_Group_Type_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Group
 * @group D2LWS_OrgUnit_Group_Type
 */
class D2LWS_OrgUnit_Group_Type_APITest extends GenericTestCase
{
    
    /**
     * Test method findByID() when Group Type exists
     */
    public function testFindByIdentifierWhichExists()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // GroupType containing single stdClass object with information
        // pertaining to the group type.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupType",
            function($args) {            
                $modelObj = new D2LWS_OrgUnit_Group_Type_Model();
                $modelObj->setID($args['GroupTypeId']['Id']);
                $modelObj->setOwnerOrgUnitID($args['OwnerOrgUnitId']['Id']);
                
                $result = new stdClass();
                $result->GroupType = $modelObj->getRawData();
                return $result;
            }
        );

        // Find the grade objects
        $apiGType = new D2LWS_OrgUnit_Group_Type_API($mock);
        $objGType = $apiGType->findByID(99, 199);

        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Type_Model', $objGType);
        $this->assertEquals(99, $objGType->getID());
    }
     
    /**
     * Test method findByID() when Group does not exist
     * @expectedException D2LWS_OrgUnit_Group_Type_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an empty stdClass instance
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupType",
            function($args) {            
                $result = new stdClass();
                return $result;
            }
        );

        // Find the grade objects
        $apiGType= new D2LWS_OrgUnit_Group_Type_API($mock);
        $objGType = $apiGType->findByID(99,199);
    }
    
    /**
     * Test method getTypesByOrgUnit() when a single Group Type exists
     */
    public function testGetTypesByOrgUnitWhenOUHasSingleGroupType()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // GroupType containing single stdClass object with information
        // pertaining to the group type.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupTypes",
            function($args) {            
                $modelObj = new D2LWS_OrgUnit_Group_Type_Model();
                $modelObj->setOwnerOrgUnitID($args['OwnerOrgUnitId']['Id']);
                
                $result = new stdClass();
                $result->GroupTypes = new stdClass();
                $result->GroupTypes->GroupTypeInfo = $modelObj->getRawData();
                return $result;
            }
        );

        // Find the grade objects
        $apiGType = new D2LWS_OrgUnit_Group_Type_API($mock);
        $objGTSet = $apiGType->getTypesByOrgUnitID(199);

        $this->assertInternalType('array', $objGTSet);
        $this->assertContainsOnly('D2LWS_OrgUnit_Group_Type_Model', $objGTSet);
        $this->assertEquals(1, count($objGTSet));
    }
      
    /**
     * Test method getTypesByOrgUnit() when no Group Type exists
     */
    public function testGetTypesByOrgUnitWhenOUHasZeroGroupTypes()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // GroupType containing single stdClass object with information
        // pertaining to the group type.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupTypes",
            function($args) {            
                $result = new stdClass();
                $result->GroupTypes = new stdClass();
                return $result;
            }
        );

        // Find the grade objects
        $apiGType = new D2LWS_OrgUnit_Group_Type_API($mock);
        $objGTSet = $apiGType->getTypesByOrgUnitID(199);

        $this->assertInternalType('array', $objGTSet);
        $this->assertContainsOnly('D2LWS_OrgUnit_Group_Type_Model', $objGTSet);
        $this->assertEquals(0, count($objGTSet));
    }
    
      
    /**
     * Test method getTypesByOrgUnit() when no Group Type exists
     * @expectedException D2LWS_OrgUnit_Group_Type_Exception_NotFound
     */
    public function testGetTypesByOrgUnitReturnsAMalformedResponse()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // GroupType containing single stdClass object with information
        // pertaining to the group type.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupTypes",
            function($args) {            
                return null;
            }
        );

        // Find the grade objects
        $apiGType = new D2LWS_OrgUnit_Group_Type_API($mock);
        $objGTSet = $apiGType->getTypesByOrgUnitID(199);
    }
    
    public function testReindexByName()
    {
        $set = array();
        $set[0] = new D2LWS_OrgUnit_Group_Type_Model();
        $set[0]->setID(9999)->setName('Test1');
        $set[1] = new D2LWS_OrgUnit_Group_Type_Model();
        $set[1]->setID(9998)->setName('Test2');
        
        
        $mock = $this->_getInstanceManagerWithMockSoapClient();
        $service = new D2LWS_OrgUnit_Group_Type_API($mock);
        
        $newset = $service->reindexByName($set);
        $this->assertInternalType('array', $newset);
        $this->assertArrayHasKey('Test1', $newset);
        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Type_Model', $newset['Test1']);
        $this->assertEquals(9999, $newset['Test1']->getID());
        $this->assertArrayHasKey('Test2', $newset);
        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Type_Model', $newset['Test2']);
        $this->assertEquals(9998, $newset['Test2']->getID());
    }
    
}
