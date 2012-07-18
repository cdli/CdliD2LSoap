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
 * PHPUnit test for D2LWS_OrgUnit_CourseTemplate_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_CourseTemplate
 */
class D2LWS_OrgUnit_CourseTemplate_APITest extends GenericTestCase
{
    
    /**
     * Test method findByID() when Course Template exists
     */
    public function testFindByIdentifierWhichExists()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an stdClass object with attribute
        // CourseTemplate containing single stdClass object with information
        // pertaining to the offering.
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetCourseTemplate",
            function($args) {            
                $modelObj = new D2LWS_OrgUnit_CourseTemplate_Model();
                $modelObj->setID($args['OrgUnitId']['Id']);
                
                $result = new stdClass();
                $result->CourseTemplate = $modelObj->getRawData();
                return $result;
            }
        );

        // Find the grade objects
        $apiTemplate = new D2LWS_OrgUnit_CourseTemplate_API($mock);
        $objTemplate = $apiTemplate->findByID(99);

        $this->assertInstanceOf('D2LWS_OrgUnit_CourseTemplate_Model', $objTemplate);
        $this->assertEquals(99, $objTemplate->getID());
    }
     
    /**
     * Test method findByID() when Course Template does not exist
     * @expectedException D2LWS_OrgUnit_CourseTemplate_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return an empty stdClass instance
        $mock->getSoapClient()->addCallback("OrgUnitManagement", "GetCourseTemplate",
            function($args) {            
                $result = new stdClass();
                return $result;
            }
        );

        // Find the grade objects
        $apiTemplate = new D2LWS_OrgUnit_CourseTemplate_API($mock);
        $objTemplate = $apiTemplate->findByID(99);
    }
    
}
