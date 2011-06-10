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
        $ouid = $this->testOptions['live']['group']['ouid'];
        
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
    
    /**
     * Test Creating New Group
     */
    public function testCreateGroup()
    {
        $objGType = $this->getTestGroupType();
        if ( ! $objGType instanceof D2LWS_OrgUnit_Group_Type_Model ) {
            $this->markTestSkipped('Could not retrieve test group type!');
        }
        $OwnerOU = $objGType->getOwnerOrgUnitID();
        
        $objGroup = new D2LWS_OrgUnit_Group_Model();
        $objGroup->setCode(uniqid("G"))
                 ->setName('API Test Group')
                 ->setDescription('API Test Group Description!')
                 ->setIsDescriptionHTML(false)
                 ->setGroupTypeID($objGType->getID())
                 ->setOwnerOrgUnitID($OwnerOU);
        
        $saveGroup = clone $objGroup;
        $result = $this->service->save($saveGroup);
        $this->assertTrue($result);
        $this->_assertModelsSameExcept($objGroup, $saveGroup, 'ID');
        $this->assertNotNull($saveGroup->getID());
        return $saveGroup;
    }
    
    /**
     * Test Updating Existing Group
     * @param D2LWS_OrgUnit_Group_Model $existingGroup
     * @depends testCreateGroup
     */
    public function testUpdateGroup(D2LWS_OrgUnit_Group_Model $existingGroup)
    {
        $saveGroup = clone $existingGroup;
        
        $newDescription = '<h1>'.uniqid('').'</h1>';
        $saveGroup->setDescription($newDescription)
                  ->setIsDescriptionHTML(true);
        $result = $this->service->save($saveGroup);
        $this->assertTrue($result);
        $this->_assertModelsSameExcept($existingGroup, $saveGroup, array(
            'Description',
            'IsDescriptionHTML'
        ));
    }
    
    /**
     * Test Deleting Group
     * @param D2LWS_OrgUnit_Group_Model $existingGroup 
     * @depends testCreateGroup
     * @todo Find out why the created group doesn't actually get deleted
     */
    public function testDeleteGroup(D2LWS_OrgUnit_Group_Model $existingGroup)
    {
        $this->assertTrue($this->service->delete($existingGroup));
        
        try {
            $this->service->findByID($existingGroup->getID());
            $this->fail('DeleteGroup call did not delete group!');
        } catch ( D2LWS_OrgUnit_Group_Exception_NotFound $ex ) {}
    }
    
}
