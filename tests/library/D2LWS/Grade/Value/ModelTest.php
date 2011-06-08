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
 * PHPUnit test for D2LWS_Grade_Value_Model
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Model
 * @group D2LWS_Grade
 * @group D2LWS_Grade_Value
 */
class D2LWS_Grade_Value_ModelTest extends GenericTestCase
{
    /**
     *
     * @var D2LWS_Grade_Value_Model 
     */
    protected $baseObj;
    
    /**
     * 
     * @var D2LWS_Grade_Value_Model 
     */
    protected $testObj;
        
    /**
     * Pre-Test Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->baseObj = new D2LWS_Grade_Value_Model();
        $this->testObj = new D2LWS_Grade_Value_Model();
        
        $this->assertEquals($this->baseObj, $this->testObj);
    }    

    /**
     * Test that constructor works as expected
     */
    public function testCreateNewInstanceWithValidConstructorArgument()
    {
        $mock = new stdClass();
        $mock->Name = "TestValue";
        $objGrade = new D2LWS_Grade_Value_Model($mock);
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
        $objGrade = new D2LWS_Grade_Value_Model();
        $this->assertInstanceOf('stdClass', $objGrade->getRawData());
    }

    /**
     * Test that we can create a "blank" instance of the model
     * by providing NULL argument to the constructor
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNewInstanceWithInvalidConstructorArgument()
    {
        $objGrade = new D2LWS_Grade_Value_Model('shouldNotAcceptString');
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
     * Test that setStudentID and getStudentID work as expected
     */
    public function testSetAndGetStudentID()
    {
        
        // Set the Role ID
        $this->testObj->setStudentID(99);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(99, $this->testObj->getStudentID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'StudentID');
    }
   
    /**
     * Test that setGradeObjectID and getGradeObjectID work as expected
     */
    public function testSetAndGetGradeObjectID()
    {
        
        // Set the Role ID
        $this->testObj->setGradeObjectID(999);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(999, $this->testObj->getGradeObjectID());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'GradeObjectID');
    } 

    /**
     * Test that setPointsNumerator and getPointsNumerator work as expected
     */
    public function testSetAndGetPointsNumerator()
    {
        
        // Set the Role ID
        $this->testObj->setPointsNumerator(25);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(25, $this->testObj->getPointsNumerator());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'PointsNumerator');
    }

    /**
     * Test that setPointsDenominator and getPointsDenominator work as expected
     */
    public function testSetAndGetPointsDenominator()
    {
        
        // Set the Role ID
        $this->testObj->setPointsDenominator(50);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(50, $this->testObj->getPointsDenominator());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'PointsDenominator');
    }

    /**
     * Test that setWeightedNumerator and getWeightedNumerator work as expected
     */
    public function testSetAndGetWeightedNumerator()
    {
        
        // Set the Role ID
        $this->testObj->setWeightedNumerator(50);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(50, $this->testObj->getWeightedNumerator());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'WeightedNumerator');
    }

    /**
     * Test that setWeightedDenominator and getWeightedDenominator work as expected
     */
    public function testSetAndGetWeightedDenominator()
    {
        
        // Set the Role ID
        $this->testObj->setWeightedDenominator(100);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals(100, $this->testObj->getWeightedDenominator());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'WeightedDenominator');
    }
 
    /**
     * Test that setGradeText and getGradeText work as expected
     */
    public function testSetAndGetGradeText()
    {
        
        // Set the Role ID
        $this->testObj->setGradeText('Test Test Test');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals('Test Test Test', $this->testObj->getGradeText());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'GradeText');
    }
   
    /**
     * Test that setStatus and getStatus work as expected
     */
    public function testSetAndGetStatus()
    {
        
        // Set the Role ID
        $this->testObj->setStatus('DivideByZero');

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertEquals('DivideByZero', $this->testObj->getStatus());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'Status');
    }  
    
    /**
     * Test the isOK function
     */
    public function testIsOK()
    {
        $this->assertFalse($this->testObj->isOK());
        $this->testObj->setStatus('OK');
        $this->assertTrue($this->testObj->isOK());
    }    
    
    /**
     * Test that setIsDropped and isDropped work as expected
     */
    public function testSetIsDroppedAndIsDropped()
    {
        
        // Set the Role ID
        $this->testObj->setIsDropped(true);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertTrue($this->testObj->isDropped());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'IsDropped');
    }  
    
    /**
     * Test that setIsReleased and isReleased work as expected
     */
    public function testSetIsReleasedAndIsReleased()
    {
        
        // Set the Role ID
        $this->testObj->setIsReleased(true);

        // Assert that a change occurred in the test object
        $this->assertNotEquals($this->testObj, $this->baseObj);

        // Assert that Role ID field was updated
        $this->assertTrue($this->testObj->isReleased());

        // Assert that no other return values were affected
        $this->_assertModelsSameExcept($this->testObj, $this->baseObj, 'IsReleased');
    } 
    
}