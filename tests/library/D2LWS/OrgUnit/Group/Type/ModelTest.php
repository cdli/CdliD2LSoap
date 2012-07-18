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
 * PHPUnit test for D2LWS_OrgUnit_Group_Type_Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Model
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Group
 * @group D2LWS_OrgUnit_Group_Type
 */
class D2LWS_OrgUnit_Group_Type_ModelTest extends GenericTestCase
{

    /**
     * Test that constructor works as expected
     */
    public function testCreateNewInstanceWithValidConstructorArgument()
    {
        $mock = $this->_createMockDataObject();
        $oGroupType = new D2LWS_OrgUnit_Group_Type_Model($mock);
        $this->assertEquals($mock, $oGroupType->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing no argument to the constructor
     */
    public function testCreateNewInstanceWithoutConstructorArgument()
    {
        $oGroupType = new D2LWS_OrgUnit_Group_Type_Model();
        $this->assertInstanceOf('stdClass', $oGroupType->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNewInstanceWithInvalidConstructorArgument()
    {
        $oGroupType = new D2LWS_OrgUnit_Group_Type_Model('shouldNotAcceptString');
    }

    /**
     * Ensure that model returns information about it's type
     */
    public function testModelReturnsCorrectTypeInformation()
    {
        $oModel = $this->_createMockModel();
        $this->assertEquals('GroupType', $oModel->getOrgUnitTypeID());
        $this->assertEquals('Group Type', $oModel->getOrgUnitTypeDesc());
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
     * Test that setOwnerOrgUnitID and getOwnerOrgUnitID work as expected
     */
    public function testSetAndGetOwnerOrgUnitID()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the ID
        $testObj->setOwnerOrgUnitID(99999);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that ID field was updated
        $this->assertEquals(99999, $testObj->getOwnerOrgUnitID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'OwnerOrgUnitID');
    }

    /**
     * Test that setOwnerOrgUnitRole and getOwnerOrgUnitRole work as expected
     */
    public function testSetAndGetOwnerOrgUnitRole()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        // Set the ID
        $testObj->setOwnerOrgUnitRole('CourseOffering');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that ID field was updated
        $this->assertEquals('CourseOffering', $testObj->getOwnerOrgUnitRole());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, 'OwnerOrgUnitRole');
    }
    
    /**
     * Test that setOwner works as expected
     */
    public function testSetOwner()
    {
        $testObj = $this->_createMockModel();
        $baseObj = $this->_createMockModel();

        $owner = new D2LWS_OrgUnit_CourseOffering_Model();
        $owner->setID(9999);
        
        // Set the owner
        $testObj->setOwner($owner);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($testObj, $baseObj);

        // Assert that owner fields were updated
        $this->assertEquals($owner->getID(), $testObj->getOwnerOrgUnitID());
        $this->assertEquals($owner->getOrgUnitTypeID(), $testObj->getOwnerOrgUnitRole());
        
        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($testObj, $baseObj, array(
            'OwnerOrgUnitID',
            'OwnerOrgUnitRole'
        ));
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
        'Description'=>array(
            'get'=>'getDescription',
            'set'=>'setDescription'
        ),
        'IsDescriptionHTML'=>array(
            'get'=>'isDescriptionHTML',
            'set'=>'setIsDescriptionHTML'
        ),
        'OwnerOrgUnitID'=>array(
            'get'=>'getOwnerOrgUnitID',
            'set'=>'setOwnerOrgUnitID'
        ),
        'OwnerOrgUnitRole'=>array(
            'get'=>'getOwnerOrgUnitRole',
            'set'=>'setOwnerOrgUnitRole'
        )
    );

    /**
     * Create an empty mock object
     */
    protected function _createMockDataObject()
    {
        return $this->_createMockModel()->getRawData();
    }

    /**
     * Create mock model object
     */
    protected function _createMockModel()
    {
         return new D2LWS_OrgUnit_Group_Type_Model();
    }
}