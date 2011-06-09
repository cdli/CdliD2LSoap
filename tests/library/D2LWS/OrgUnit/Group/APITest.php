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
 * PHPUnit test for D2LWS_OrgUnit_Group_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Group
 */
class D2LWS_OrgUnit_Group_APITest extends GenericTestCase
{
    
    /**
     * Test method findByID() when Group exists
     */
    public function testFindByIdentifierWhichExists()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // Group containing single stdClass object with information
        // pertaining to the group.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroup",
            function($args) {            
                $modelObj = new D2LWS_OrgUnit_Group_Model();
                $modelObj->setID($args['OrgUnitId']['Id']);
                
                $result = new stdClass();
                $result->Group = $modelObj->getRawData();
                return $result;
            }
        );

        // Find the grade objects
        $apiOffering = new D2LWS_OrgUnit_Group_API($mock);
        $objOffering = $apiOffering->findByID(99);

        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Model', $objOffering);
        $this->assertEquals(99, $objOffering->getID());
    }
     
    /**
     * Test method findByID() when Group does not exist
     * @expectedException D2LWS_OrgUnit_Group_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an empty stdClass instance
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroup",
            function($args) {            
                $result = new stdClass();
                return $result;
            }
        );

        // Find the grade objects
        $apiOffering = new D2LWS_OrgUnit_Group_API($mock);
        $objOffering = $apiOffering->findByID(99);
    }
    
    /**
     * Test method findByCode() when Group exists
     */
    public function testFindByCodeWhichExists()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // Group containing single stdClass object with information
        // pertaining to the group.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupByCode",
            function($args) {            
                $modelObj = new D2LWS_OrgUnit_Group_Model();
                $modelObj->setCode($args['Code']);
                
                $result = new stdClass();
                $result->Group = $modelObj->getRawData();
                return $result;
            }
        );

        // Find the grade objects
        $apiOffering = new D2LWS_OrgUnit_Group_API($mock);
        $objOffering = $apiOffering->findByCode('TestCode');

        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Model', $objOffering);
        $this->assertEquals('TestCode', $objOffering->getCode());
    }
     
    /**
     * Test method findByCode() when Group does not exist
     * @expectedException D2LWS_OrgUnit_Group_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an empty stdClass instance
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetGroupByCode",
            function($args) {            
                $result = new stdClass();
                return $result;
            }
        );

        // Find the grade objects
        $apiOffering = new D2LWS_OrgUnit_Group_API($mock);
        $objOffering = $apiOffering->findByCode('NonExistentCodeX');
    }
    
}
