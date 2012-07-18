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
 * PHPUnit test for D2LWS_Grade_Object_Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Model
 * @group D2LWS_Grade
 * @group D2LWS_Grade_Object
 */
class D2LWS_Grade_Object_ModelTest extends GenericTestCase
{
    /**
     *
     * @var D2LWS_Grade_Object_Model 
     */
    protected $baseObj;
    
    /**
     * 
     * @var D2LWS_Grade_Object_Model 
     */
    protected $testObj;
        
    /**
     * Pre-Test Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->baseObj = new D2LWS_Grade_Object_Model();
        $this->testObj = new D2LWS_Grade_Object_Model();
        
        $this->assertEquals($this->baseObj, $this->testObj);
    }    

    /**
     * Test that constructor works as expected
     */
    public function testCreateNewInstanceWithValidConstructorArgument()
    {
        $mock = new stdClass();
        $mock->Name = "TestObject";
        $objGrade = new D2LWS_Grade_Object_Model($mock);
        $raw = $objGrade->getRawData();
        $this->assertInstanceOf('stdClass', $raw);
        $this->assertObjectHasAttribute('Name', $raw);
        $this->assertEquals($mock->Name, $raw->Name);
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing no argument to the constructor
     */
    public function testCreateNewInstanceWithoutConstructorArgument()
    {
        $objGrade = new D2LWS_Grade_Object_Model();
        $this->assertInstanceOf('stdClass', $objGrade->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNewInstanceWithInvalidConstructorArgument()
    {
        $objGrade = new D2LWS_Grade_Object_Model('shouldNotAcceptString');
    }        

    /**
     * Test that setID and getID work as expected
     */
    public function testSetAndGetID()
    {
        
        // Set the Role ID
        $this->testObj->setID(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(99, $this->testObj->getID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'ID');
    }    

    /**
     * Test that setName and getName work as expected
     */
    public function testSetAndGetName()
    {
        
        // Set the Role ID
        $this->testObj->setName('MyName');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals('MyName', $this->testObj->getName());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'Name');
    }

    /**
     * Test that setType and getType work as expected
     */
    public function testSetAndGetType()
    {
        
        // Set the Role ID
        $this->testObj->setType('Calculated');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals('Calculated', $this->testObj->getType());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'Type');
    }

    /**
     * Test that setOrgUnitID and getOrgUnitID work as expected
     */
    public function testSetAndGetOrgUnitID()
    {
        
        // Set the Role ID
        $this->testObj->setOrgUnitID(9999);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(9999, $this->testObj->getOrgUnitID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'OrgUnitID');
    }
 
    /**
     * @dataProvider providerIsTypeMethods
     * @param type $method Method under test
     * @param type $expectedType Expected type
     */
    public function testIsTypeMethods($type, $trueMethod)
    {
        $this->testObj->setType($type);
        
        $allMethods = array(
            'isNumeric',
            'isPassFail',
            'isSelectBox',
            'isText',
            'isCalculated',
            'isFormula',
            'isCalculatedFinalGrade',
            'isAdjustedFinalGrade',
            'isCategory'
        );
        foreach ( $allMethods as $testMethod )
        {
            $testMethod == $trueMethod
                ? $this->assertTrue($this->testObj->{$testMethod}())
                : $this->assertFalse($this->testObj->{$testMethod}());
        }
    }
    
    /**
     * Data Provider for testIsTypeMethods
     * @return array 
     */
    public function providerIsTypeMethods()
    {
        return array(
            array('Numeric', 'isNumeric'),
            array('PassFail', 'isPassFail'),
            array('SelectBox', 'isSelectBox'),
            array('Text', 'isText'),
            array('Calculated', 'isCalculated'),
            array('Formula', 'isFormula'),
            array('CalculatedFinalGrade', 'isCalculatedFinalGrade'),
            array('AdjustedFinalGrade', 'isAdjustedFinalGrade'),
            array('Category', 'isCategory')
        );
    }
}