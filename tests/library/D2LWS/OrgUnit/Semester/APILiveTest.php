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
 * PHPUnit live-server test for D2LWS_OrgUnit_Semester_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Semester
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_Semester_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_Semester_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_Semester_API($api);
    }
    
    /**
     * Fetch our test semester by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->config['phpunit']['live']['semester']['ouid'];
        
        $objSemester = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_Semester_Model', $objSemester);        
        $this->assertEquals($ouid, $objSemester->getID());
        
        return $objSemester;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_Semester_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $objSemester = $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test semester by it's Code
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByCodeWhichExists(D2LWS_OrgUnit_Semester_Model $o)
    {
        $objSemester = $this->service->findByCode($o->getCode());
        $this->assertInstanceOf('D2LWS_OrgUnit_Semester_Model', $objSemester);        
        $this->assertEquals($o, $objSemester);
        
        return $objSemester;
    }
    
    /**
     * Attempt to fetch a non-existent OUCode
     * @expectedException D2LWS_OrgUnit_Semester_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        $objSemester = $this->service->findByCode(md5(uniqid("")));
    }
    
    public function testCreateSemester()
    {
        $obj = new D2LWS_OrgUnit_Semester_Model();
        $obj->setName('zfD2L Test Semester')
            ->setCode('zfd2ltestsem')
            ->setPath($this->config['phpunit']['live']['storage']['basedir'] . '/zfd2ltestsem')
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
     * @depends testCreateSemester
     */
    public function testUpdateSemester(D2LWS_OrgUnit_Semester_Model $obj)
    {
        $obj->setCode('zfd2ltestsem_update');
        $this->assertTrue($this->service->save($obj));
        
        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals('zfd2ltestsem_update', $savedObj->getCode());
    }
    
    /**
     * @depends testCreateSemester
     * @expectedException D2LWS_OrgUnit_Semester_Exception_NotFound
     */
    public function testDeleteSemester(D2LWS_OrgUnit_Semester_Model $obj)
    {
        $this->assertTrue($this->service->delete($obj));
        $savedObj = $this->service->findByID($obj->getID());
    }
    
    /**
     * @depends testCreateSemester
     */
    public function testDeleteUnsavedSemester(D2LWS_OrgUnit_Semester_Model $obj)
    {
        $this->assertFalse($this->service->delete(new D2LWS_OrgUnit_Semester_Model()));
    }
}
