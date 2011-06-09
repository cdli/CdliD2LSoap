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
 * PHPUnit test for D2LWS_OrgUnit_Department_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Department
 */
class D2LWS_OrgUnit_Department_APITest extends GenericTestCase
{
    
    /**
     * Test method findByID() when Department exists
     */
    public function testFindByIdentifierWhichExists()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // Department containing single stdClass object with information
        // pertaining to the offering.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetDepartment",
            function($args) {            
                $modelObj = new D2LWS_OrgUnit_Department_Model();
                $modelObj->setID($args['OrgUnitId']['Id']);
                
                $result = new stdClass();
                $result->Department = $modelObj->getRawData();
                return $result;
            }
        );

        // Find the grade objects
        $apiDepartment = new D2LWS_OrgUnit_Department_API($mock);
        $objDepartment = $apiDepartment->findByID(99);

        $this->assertInstanceOf('D2LWS_OrgUnit_Department_Model', $objDepartment);
        $this->assertEquals(99, $objDepartment->getID());
    }
     
    /**
     * Test method findByID() when Department does not exist
     * @expectedException D2LWS_OrgUnit_Department_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an empty stdClass instance
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetDepartment",
            function($args) {            
                $result = new stdClass();
                return $result;
            }
        );

        // Find the grade objects
        $apiDepartment = new D2LWS_OrgUnit_Department_API($mock);
        $objDepartment = $apiDepartment->findByID(99);
    }

}
