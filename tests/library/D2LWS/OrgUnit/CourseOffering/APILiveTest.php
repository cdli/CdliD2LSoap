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
 * PHPUnit live-server test for D2LWS_OrgUnit_CourseOffering_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_CourseOffering
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_CourseOffering_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_CourseOffering_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_CourseOffering_API($api);
    }
    
    /**
     * Fetch our test course offering by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->testOptions['live']['course_offering']['ouid'];
        
        $objCourseOffering = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_CourseOffering_Model', $objCourseOffering);        
        $this->assertEquals($ouid, $objCourseOffering->getID());
        
        return $objCourseOffering;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_CourseOffering_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $objCourseOffering = $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test course offering by code and ensure correct one is returned
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByCodeWhichExists(D2LWS_OrgUnit_CourseOffering_Model $co)
    {
        $objCourseOffering = $this->service->findByCode($co->getCode());
        $this->assertInstanceOf('D2LWS_OrgUnit_CourseOffering_Model', $objCourseOffering);        
        $this->assertEquals($co, $objCourseOffering);
        
        return $objCourseOffering;
    }
    
    /**
     * Attempt to fetch a non-existent course code
     * @expectedException D2LWS_OrgUnit_CourseOffering_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        // Generate a code which (likely) won't exist in the system
        $code = sha1(uniqid(""));
        $objCourseOffering = $this->service->findByCode($code);
    }
    
}
