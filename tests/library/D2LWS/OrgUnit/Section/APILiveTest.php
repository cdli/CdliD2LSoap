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
 * PHPUnit live-server test for D2LWS_OrgUnit_Section_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Section
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_Section_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_Section_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->markTestSkipped('Skipped due to bug: CreateSection creates OU of type Group');
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_Section_API($api);
    }
    
    /**
     * Fetch our test group by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->config->phpunit->live->section->ouid;
        
        $objSection = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_Section_Model', $objSection);        
        $this->assertEquals($ouid, $objSection->getID());
        
        return $objSection;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_Section_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $objSection = $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test group by code and ensure correct one is returned
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByCodeWhichExists(D2LWS_OrgUnit_Section_Model $co)
    {
        $objSection = $this->service->findByCode($co->getCode());
        $this->assertInstanceOf('D2LWS_OrgUnit_Section_Model', $objSection);        
        $this->assertEquals($co, $objSection);
        
        return $objSection;
    }
    
    /**
     * Attempt to fetch a non-existent course code
     * @expectedException D2LWS_OrgUnit_Section_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        // Generate a code which (likely) won't exist in the system
        $code = sha1(uniqid(""));
        $objSection = $this->service->findByCode($code);
    }
    
    public function testCreateSection()
    {
        $co = $this->getTestCourseOffering();
        if ( ! $co instanceof D2LWS_OrgUnit_CourseOffering_Model ) {
            $this->markTestSkipped('Could not retrieve test course offering!');
        }
        
        $obj = new D2LWS_OrgUnit_Section_Model();
        $obj->setName('zfD2L Test Section')
            ->setCode('zfd2ltestsection')
            ->setDescription('zfD2L Test Section Description!')
            ->setIsDescriptionHTML(false)
            ->setCourseOffering($co);
        $this->assertTrue($this->service->save($obj));
        $this->assertNotNull($obj->getID());
        
        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals($obj, $savedObj);
        
        return $obj;
    }
 
    /**
     * @depends testCreateSection
     */
    public function testUpdateSection(D2LWS_OrgUnit_Section_Model $obj)
    {
        $newDescription = '<h1>'.uniqid('').'</h1>';
        $obj->setDescription($newDescription)
            ->setIsDescriptionHTML(true);
        $this->assertTrue($this->service->save($obj));
        
        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals($obj, $savedObj);
        $this->assertEquals($newDescription, $savedObj->getDescription());
        $this->assertTrue($savedObj->isDescriptionHTML());
    }
    
    /**
     * @depends testCreateSection
     * @expectedException D2LWS_OrgUnit_Section_Exception_NotFound
     */
    public function testDeleteSection(D2LWS_OrgUnit_Section_Model $obj)
    {
        $this->assertTrue($this->service->delete($obj));
        $savedObj = $this->service->findByID($obj->getID());
    }
    
    /**
     * @depends testCreateSection
     */
    public function testDeleteUnsavedSection(D2LWS_OrgUnit_Section_Model $obj)
    {
        $this->assertFalse($this->service->delete(new D2LWS_OrgUnit_Section_Model()));
    }
}
