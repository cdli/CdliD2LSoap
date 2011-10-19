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
 * PHPUnit test for D2LWS_OrgUnit_Section_Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Model
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Section
 */
class D2LWS_OrgUnit_Section_ModelTest extends GenericTestCase
{

    /**
     * Test that constructor works as expected
     */
    public function testCreateNewInstanceWithValidConstructorArgument()
    {
        $mock = $this->_createMockDataObject();
        $oSection = new D2LWS_OrgUnit_Section_Model($mock);
        $this->assertEquals($mock, $oSection->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing no argument to the constructor
     */
    public function testCreateNewInstanceWithoutConstructorArgument()
    {
        $oSection = new D2LWS_OrgUnit_Section_Model();
        $this->assertInstanceOf('stdClass', $oSection->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNewInstanceWithInvalidConstructorArgument()
    {
        $oSection = new D2LWS_OrgUnit_Section_Model('shouldNotAcceptString');
    }

    /**
     * Ensure that model returns information about it's type
     */
    public function testModelReturnsCorrectTypeInformation()
    {
        $oModel = $this->_createMockModel();
        $this->assertEquals('Section', $oModel->getOrgUnitTypeID());
        $this->assertEquals('Section', $oModel->getOrgUnitTypeDesc());
    }

    /**
     * Test that setID and getID work as expected
     */
    public function testSetAndGetID()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the ID
        $testObj->setID(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that ID field was updated
        $this->assertEquals(99, $testObj->getID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'ID');
    }

    /**
     * Test that setName and getName work as expected
     */
    public function testSetAndGetName()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Name
        $testObj->setName(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that Name field was updated
        $this->assertEquals(99, $testObj->getName());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Name');
    }

    /**
     * Test that setCode and getCode work as expected
     */
    public function testSetAndGetCode()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Code
        $testObj->setCode('SectionCode');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the Code field was updated
        $this->assertEquals('SectionCode', $testObj->getCode());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Code');
    }

    /**
     * Test that setDescription and getDescription work as expected
     */
    public function testSetAndGetDescription()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Description
        $testObj->setDescription('Test Test Test Test');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the Description field was updated
        $this->assertEquals('Test Test Test Test', $testObj->getDescription());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Description');
    }

    /**
     * Test that setIsDescriptionHTML and isDescriptionHTML work as expected
     */
    public function testSetAndGetIsDescriptionHTML()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Description to not HTML
        $testObj->setIsDescriptionHTML(false);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the Description field was updated
        $this->assertFalse($testObj->isDescriptionHTML());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'IsDescriptionHTML');
        
        $testObj->setIsDescriptionHTML(true);
        $this->assertTrue($testObj->isDescriptionHTML());
    }

    /**
     * Test that setCourseOfferingID and getCourseOfferingID work as expected
     */
    public function testSetAndGetCourseOfferingID()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the ID
        $testObj->setCourseOfferingID(2999);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that ID field was updated
        $this->assertEquals(2999, $testObj->getCourseOfferingID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'CourseOfferingID');
    }

    /**
     * Test that setCourseOfferingSource and getCourseOfferingSource work as expected
     */
    public function testSetAndGetCourseOfferingSource()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Source
        $testObj->setCourseOfferingSource('External');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that Source field was updated
        $this->assertEquals('External', $testObj->getCourseOfferingSource());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'CourseOfferingSource');
    }
    
    public function testSetCourseOffering()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();
        
        //@todo Currently unable to set Id->Source of Course Offering
        $co = new D2LWS_OrgUnit_CourseOffering_Model();
        $co->setID(2999);
        
        // Set the Course Offering object
        $testObj->setCourseOffering($co);
        
        // Assert that ID and Source fileds were updated
        $this->assertEquals(2999, $testObj->getCourseOfferingID());
        $this->assertEquals('Desire2Learn', $testObj->getCourseOfferingSource());
        
        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, array(
            'CourseOfferingID'
        ));
    }
    
    /**
     * Create mock model object
     */
    protected function _createMockModel()
    {
         return new D2LWS_OrgUnit_Section_Model();
    }
}