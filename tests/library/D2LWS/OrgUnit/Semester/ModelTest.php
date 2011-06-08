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
 * PHPUnit test for D2LWS_OrgUnit_Semester_Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Model
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Semester
 */
class D2LWS_OrgUnit_Semester_ModelTest extends GenericTestCase
{

    /**
     * Test that constructor works as expected
     */
    public function testCreateNewInstanceWithValidConstructorArgument()
    {
        $mock = $this->_createMockDataObject();
        $oRole = new D2LWS_OrgUnit_Semester_Model($mock);
        $this->assertEquals($mock, $oRole->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing no argument to the constructor
     */
    public function testCreateNewInstanceWithoutConstructorArgument()
    {
        $oRole = new D2LWS_OrgUnit_Semester_Model();
        $this->assertNull($oRole->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     */
    public function testCreateNewInstanceWithNullConstructorArgument()
    {
        $oRole = new D2LWS_OrgUnit_Semester_Model(NULL);
        $this->assertNull($oRole->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNewInstanceWithInvalidConstructorArgument()
    {
        $oRole = new D2LWS_OrgUnit_Semester_Model('shouldNotAcceptString');
    }

    /**
     * Ensure that model returns information about it's type
     */
    public function testModelReturnsCorrectTypeInformation()
    {
        $oModel = $this->_createMockModel();
        $this->assertEquals('Semester', $oModel->getOrgUnitTypeID());
        $this->assertEquals('Semester', $oModel->getOrgUnitTypeDesc());
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
        $testObj->setCode(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that the Code field was updated
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

        // Assert that the Path field was updated
        $this->assertEquals(99, $testObj->getPath());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'Path');
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
        $this->assertNotEquals('something', $testObj->isActive());
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

        // Assert that the End Date field was updated
        $this->assertEquals('2011-06-04T05:12:34', $testObj->getEndDate());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'EndDate');
    }
    
    /**
     * Defines the methods we should test
     * @var array
     */
    protected $_methodsToTest = array(
        'ID'=>array(
            'get'=>'getID',
            'set'=>'setID'
        ),
        'Name'=>array(
            'get'=>'getName',
            'set'=>'setName'
        ),
        'Code'=>array(
            'get'=>'getCode',
            'set'=>'setCode'
        ),
        'Path'=>array(
            'get'=>'getPath',
            'set'=>'setPath'
        ),
        'Active'=>array(
            'get'=>'isActive',
            'set'=>'setIsActive'
        ),
        'StartDate'=>array(
            'get'=>'getStartDate',
            'set'=>'setStartDate'
        ),
        'EndDate'=>array(
            'get'=>'getEndDate',
            'set'=>'setEndDate'
        )
    );

    /**
     * Create an empty mock object
     */
    protected function _createMockDataObject()
    {
        $obj = new stdClass();
        
        $obj->OrgUnitId = new stdClass();
        $obj->OrgUnitId->Id = 0;
        $obj->OrgUnitId->Source = "Desire2Learn";

        $obj->Name = '';
        $obj->Code = '';
        $obj->Path = '';
        $obj->IsActive = false;
        $obj->StartDate = '';
        $obj->EndDate = '';

        return $obj;
    }

    /**
     * Create mock model object
     */
    protected function _createMockModel()
    {
         return new D2LWS_OrgUnit_Semester_Model($this->_createMockDataObject());
    }
}