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
 * PHPUnit live-server test for D2LWS_OrgUnit_Department_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Department
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_Department_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_Department_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_Department_API($api);
    }
    
    /**
     * Fetch our test department by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->config['phpunit']['live']['department']['ouid'];
        
        $objDepartment = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_Department_Model', $objDepartment);        
        $this->assertEquals($ouid, $objDepartment->getID());
        
        return $objDepartment;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_Department_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $objDepartment = $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test course template by it's code
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByCodeWhichExists(D2LWS_OrgUnit_Department_Model $o)
    {
        $objDepartment = $this->service->findByCode($o->getCode());
        $this->assertInstanceOf('D2LWS_OrgUnit_Department_Model', $objDepartment);        
        $this->assertEquals($o,$objDepartment);
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_Department_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        $objDepartment = $this->service->findByCode(md5(uniqid("")));
    }
    
    public function testCreateDepartment()
    {
        $obj = new D2LWS_OrgUnit_Department_Model();
        $obj->setName('zfD2L Test Department')
            ->setCode('zfd2ltestdept')
            ->setPath($this->config['phpunit']['live']['storage']['basedir'] . '/zfd2ltestdept')
            ->setIsActive(true)
            ->setStartDate(date("Y-m-d\TH:i:s"))
            ->setEndDate(date("Y-m-d\TH:i:s", time()+600));

        $this->assertTrue($this->service->save($obj));
        $this->assertNotNull($obj->getID());
        
        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals($obj, $savedObj);
        
        return $obj;
    }
 
    /**
     * @depends testCreateDepartment
     */
    public function testUpdateDepartment(D2LWS_OrgUnit_Department_Model $obj)
    {
        $obj->setCode('zfd2ltestdept_update');

        $errMsg = 'None';
        try {
            $this->assertTrue($this->service->save($obj));
        } catch ( D2LWS_Soap_Client_Exception $ex ) {
            $errMsg = $ex->getMessage(); 
        }

        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals($obj, $savedObj, 'Exception: '.$errMsg);
        $this->assertEquals('zfd2ltestdept_update', $savedObj->getCode());
    }
    
    /**
     * @depends testCreateDepartment
     * @expectedException D2LWS_OrgUnit_Department_Exception_NotFound
     */
    public function testDeleteDepartment(D2LWS_OrgUnit_Department_Model $obj)
    {
        $this->assertTrue($this->service->delete($obj));
        $savedObj = $this->service->findByID($obj->getID());
    }
    
    /**
     * @depends testCreateDepartment
     */
    public function testDeleteUnsavedDepartment(D2LWS_OrgUnit_Department_Model $obj)
    {
        $this->assertFalse($this->service->delete(new D2LWS_OrgUnit_Department_Model()));
    }    
}
