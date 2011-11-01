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
 * PHPUnit live-server test for D2LWS_OrgUnit_CourseTemplate_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_CourseTemplate
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_CourseTemplate_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_CourseTemplate_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_CourseTemplate_API($api);
    }
    
    /**
     * Fetch our test course template by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->config->phpunit->live->course_template->ouid;
        
        $objCourseTemplate = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_CourseTemplate_Model', $objCourseTemplate);        
        $this->assertEquals($ouid, $objCourseTemplate->getID());
        
        return $objCourseTemplate;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_CourseTemplate_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $objCourseTemplate = $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test course template by it's code
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByCodeWhichExists(D2LWS_OrgUnit_CourseTemplate_Model $o)
    {
        $objCourseTemplate = $this->service->findByCode($o->getCode());
        $this->assertInstanceOf('D2LWS_OrgUnit_CourseTemplate_Model', $objCourseTemplate);        
        $this->assertEquals($o,$objCourseTemplate);
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_CourseTemplate_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        $objCourseTemplate = $this->service->findByCode(md5(uniqid("")));
    }
    
    
    public function testCreateCourseTemplate()
    {
        $obj = new D2LWS_OrgUnit_CourseTemplate_Model();
        $obj->setName('zfD2L Test Course Template')
            ->setCode('zfd2ltestct')
            ->setPath($this->config->phpunit->live->storage->basedir . '/zfd2ltestct')
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
     * @depends testCreateCourseTemplate
     */
    public function testUpdateCourseTemplate(D2LWS_OrgUnit_CourseTemplate_Model $obj)
    {
        $obj->setCode('zfd2ltestct_update');
        $this->assertTrue($this->service->save($obj));
        
        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals('zfd2ltestct_update', $savedObj->getCode());
    }
    
    /**
     * @depends testCreateCourseTemplate
     * @expectedException D2LWS_OrgUnit_CourseTemplate_Exception_NotFound
     */
    public function testDeleteCourseTemplate(D2LWS_OrgUnit_CourseTemplate_Model $obj)
    {
        $this->assertTrue($this->service->delete($obj));
        $savedObj = $this->service->findByID($obj->getID());
    }
    
    /**
     * @depends testCreateCourseTemplate
     */
    public function testDeleteUnsavedCourseTemplate(D2LWS_OrgUnit_CourseTemplate_Model $obj)
    {
        $this->assertFalse($this->service->delete(new D2LWS_OrgUnit_CourseTemplate_Model()));
    }
}
