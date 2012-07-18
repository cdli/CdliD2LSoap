<?php
/**
 * CdliD2LSoap - PHP5 Wrapper for Desire2Learn Web Services
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
 * PHPUnit test for D2LWS_OrgUnit_CourseOffering_Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Model
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_CourseOffering
 */
class D2LWS_OrgUnit_CourseOffering_ModelTest extends GenericTestCase
{

    /**
     * Test that constructor works as expected
     */
    public function testCreateNewInstanceWithValidConstructorArgument()
    {
        $mock = $this->_createMockDataObject();
        $oRole = new D2LWS_OrgUnit_CourseOffering_Model($mock);
        $this->assertEquals($mock, $oRole->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing no argument to the constructor
     */
    public function testCreateNewInstanceWithoutConstructorArgument()
    {
        $oRole = new D2LWS_OrgUnit_CourseOffering_Model();
        $this->assertInstanceOf('stdClass', $oRole->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNewInstanceWithInvalidConstructorArgument()
    {
        $oRole = new D2LWS_OrgUnit_CourseOffering_Model('shouldNotAcceptString');
    }

    /**
     * Ensure that model returns information about it's type
     */
    public function testModelReturnsCorrectTypeInformation()
    {
        $oModel = $this->_createMockModel();
        $this->assertEquals('CourseOffering', $oModel->getOrgUnitTypeID());
        $this->assertEquals('Course Offering', $oModel->getOrgUnitTypeDesc());
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

        // Assert that field was updated
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

        // Assert that field was updated
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
        $testObj->setCode(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the field was updated
        $this->assertEquals(99, $testObj->getCode());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Code');
    }

    /**
     * Test that setPath and getPath work as expected
     */
    public function testSetAndGetPath()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Path
        $testObj->setPath(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the field was updated
        $this->assertEquals(99, $testObj->getPath());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Path');
    }
    
    /**
     * Test that setTemplateID and getTemplateID work as expected
     */
    public function testSetAndGetTemplateID()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Template ID
        $testObj->setTemplateID(1234);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the field was updated
        $this->assertEquals(1234, $testObj->getTemplateID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'TemplateID');
    }
    
    /**
     * Test that setTemplateSource and getTemplateSource work as expected
     */
    public function testSetAndGetTemplateSource()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Template Source
        $testObj->setTemplateSource('Test');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the field was updated
        $this->assertEquals('Test', $testObj->getTemplateSource());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'TemplateSource');
    }
    
    /**
     * Test that setTemplate and getTemplate work as expected
     */
    public function testSetAndGetTemplate()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Template Object
        $tpl = new D2LWS_OrgUnit_CourseTemplate_Model();
        $tpl->setID(123456);
        $testObj->setTemplate($tpl);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the field was updated
        $this->assertEquals(123456, $testObj->getTemplateID());
        $this->assertEquals('Desire2Learn', $testObj->getTemplateSource());
        
        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, array('TemplateID'));
    }
    
    /**
     * Test that setIsActive and isActive work as expected
     */
    public function testSetAndGetActive()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        $arg = !$baseObj->isActive();

        // Set the "Is Active" flag
        $testObj->setIsActive($arg);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that "Is Active" flag field was updated
        $this->assertEquals($arg, $testObj->isActive());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Active');
    }

    /**
     * Test that setIsActive and isActive work as expected
     * @todo Update model to enforce boolean argument
     */
    public function testSetActiveShouldNotAcceptNonBooleanArgument()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the "Is Active" flag
        $testObj->setIsActive('something');

        // Assert that "Is Active" flag was updated
        $this->assertNotEquals('something', (string)$testObj->isActive());
    }

    /**
     * Test that setStartDate and getStartDate work as expected
     */
    public function testSetAndGetStartDate()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the Start Date field
        $testObj->setStartDate('2011-06-04T05:12:34');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the Start Date field was updated
        $this->assertEquals('2011-06-04T05:12:34', $testObj->getStartDate());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'StartDate');
    }

    /**
     * Test that setEndDate and getEndDate work as expected
     */
    public function testSetAndGetEndDate()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the End Date field
        $testObj->setEndDate('2011-06-04T05:12:34');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the field was updated
        $this->assertEquals('2011-06-04T05:12:34', $testObj->getEndDate());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'EndDate');
    }

    /**
     * Test that setCanRegister and canRegister work as expected
     */
    public function testSetAndGetCanRegister()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        $arg = !$baseObj->canRegister();

        // Set the "Can Register" flag
        $testObj->setCanRegister($arg);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that "Can Register" flag was updated
        $this->assertEquals($arg, $testObj->canRegister());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'CanRegister');
    }

    /**
     * Test that setIsActive and isActive work as expected
     * @todo Update model to enforce boolean argument
     */
    public function testSetCanRegisterShouldNotAcceptNonBooleanArgument()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the "Can Register" flag
        $testObj->setCanRegister('something');

        // Assert that "Can Register" flag was updated
        $this->assertNotEquals('something', (string)$testObj->canRegister());
    }

    /**
     * Test that setAllowSections and AllowSections work as expected
     */
    public function testSetAndGetAllowSections()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        $arg = !$baseObj->allowsSections();

        // Set the "Allows Sections" flag
        $testObj->setAllowSections($arg);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that "Allows Sections" flag was updated
        $this->assertEquals($arg, $testObj->allowsSections());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'AllowSections');
    }

    /**
     * Test that setIsActive and isActive work as expected
     * @todo Update model to enforce boolean argument
     */
    public function testSetAllowSectionsShouldNotAcceptNonBooleanArgument()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the "Allows Sections" flag
        $testObj->setAllowSections('something');

        // Assert that "Allows Sections" flag was updated
        $this->assertNotEquals('something', (string)$testObj->allowsSections());
    }

    /**
     * Create mock model object
     */
    protected function _createMockModel()
    {
         return new D2LWS_OrgUnit_CourseOffering_Model();
    }
}