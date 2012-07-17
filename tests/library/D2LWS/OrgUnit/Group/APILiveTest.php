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
 * PHPUnit live-server test for D2LWS_OrgUnit_Group_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Group
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_Group_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_Group_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_Group_API($api);
    }
    
    /**
     * Fetch our test group by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->config['phpunit']['live']['group']['ouid'];
        
        $objGroup = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Model', $objGroup);        
        $this->assertEquals($ouid, $objGroup->getID());
        
        return $objGroup;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_Group_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $objGroup = $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test group by code and ensure correct one is returned
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByCodeWhichExists(D2LWS_OrgUnit_Group_Model $co)
    {
        $objGroup = $this->service->findByCode($co->getCode());
        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Model', $objGroup);        
        $this->assertEquals($co, $objGroup);
        
        return $objGroup;
    }
    
    /**
     * Attempt to fetch a non-existent course code
     * @expectedException D2LWS_OrgUnit_Group_Exception_NotFound
     */
    public function testFindByCodeWhichDoesNotExist()
    {
        // Generate a code which (likely) won't exist in the system
        $code = sha1(uniqid(""));
        $objGroup = $this->service->findByCode($code);
    }
    
    public function testCreateGroup()
    {
        $objGType = $this->getTestGroupType();
        if ( ! $objGType instanceof D2LWS_OrgUnit_Group_Type_Model ) {
            $this->markTestSkipped('Could not retrieve test group type!');
        }
        $OwnerOU = $objGType->getOwnerOrgUnitID();
        
        $obj = new D2LWS_OrgUnit_Group_Model();
        $obj->setName('zfD2L Test Group')
            ->setCode('zfd2ltestgroup')
            ->setDescription('zfD2L Test Group Description!')
            ->setIsDescriptionHTML(false)
            ->setGroupTypeID($objGType->getID())
            ->setOwnerOrgUnitID($OwnerOU);
        $this->assertTrue($this->service->save($obj));
        $this->assertNotNull($obj->getID());
        
        $savedObj = $this->service->findByID($obj->getID());
        $this->assertEquals($obj, $savedObj);
        
        return $obj;
    }
 
    /**
     * @depends testCreateGroup
     */
    public function testUpdateGroup(D2LWS_OrgUnit_Group_Model $obj)
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
     * @depends testCreateGroup
     * @expectedException D2LWS_OrgUnit_Group_Exception_NotFound
     */
    public function testDeleteGroup(D2LWS_OrgUnit_Group_Model $obj)
    {
        $this->assertTrue($this->service->delete($obj));
        $savedObj = $this->service->findByID($obj->getID());
    }
    
    /**
     * @depends testCreateGroup
     */
    public function testDeleteUnsavedGroup(D2LWS_OrgUnit_Group_Model $obj)
    {
        $this->assertFalse($this->service->delete(new D2LWS_OrgUnit_Group_Model()));
    }
}
