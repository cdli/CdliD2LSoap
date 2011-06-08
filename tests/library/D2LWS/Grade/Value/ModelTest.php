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
 
}