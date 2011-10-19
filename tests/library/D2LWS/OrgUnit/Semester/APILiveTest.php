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
        $ouid = $this->config->phpunit->live->semester->ouid;
        
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
}
