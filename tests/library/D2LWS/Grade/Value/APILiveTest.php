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
 * PHPUnit live-server test for D2LWS_Grade_Value_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_Grade
 * @group D2LWS_Grade_Value
 * @group D2LWS_Live
 */
class D2LWS_Grade_Value_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_Grade_Value_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_Grade_Value_API($api);
    }
    
    /**
     * Fetch all the grade values from our test course offering
     */
    public function testCanFetchAllGradeValuesFromCourseOffering()
    {
        $CourseOffering = $this->getTestCourseOffering();
        $gObjSet = $this->service->findAllByOrgUnit($CourseOffering);

        $this->assertInternalType('array', $gObjSet);
        $this->assertContainsOnly('D2LWS_Grade_Value_Model', $gObjSet);
        $this->assertEquals(7, count($gObjSet));
    }
    
    /**
     * Fetch all the grade values from our empty test course offering
     * @expectedException D2LWS_Grade_Value_Exception_MalformedResponse
     * @todo Is an exception really the proper response to zero results? 
     */
    public function testCanFetchAllGradeValuesFromEmptyCourseOffering()
    {
        $CourseOffering = $this->getTestEmptyCourseOffering();
        $gObjSet = $this->service->findAllByOrgUnit($CourseOffering);
    }
    
}