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
 * PHPUnit live-server test for D2LWS_OrgUnit_Group_Type_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Group
 * @group D2LWS_OrgUnit_Group_Type
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_Group_Type_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_Group_Type_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_Group_Type_API($api);
    }
    
    /**
     * Fetch our test group by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $grouptype_ouid = $this->config->phpunit->live->group_type->ouid;
        $offering_ouid = $this->config->phpunit->live->course_offering->ouid;
        
        $objGroupType = $this->service->findByID($grouptype_ouid, $offering_ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Type_Model', $objGroupType);        
        $this->assertEquals($grouptype_ouid, $objGroupType->getID());
        $this->assertEquals($offering_ouid, $objGroupType->getOwnerOrgUnitID());
        
        return $objGroupType;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_OrgUnit_Group_Type_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $objGroupType = $this->service->findByID(
            '999999999',
            $this->config->phpunit->live->course_offering->ouid
        );
    }
        
    /**
     * Fetch our test course offering's group types
     */
    public function testGetTypesByOrgUnit()
    {
        $grouptype_ouid = $this->config->phpunit->live->group_type->ouid;
        $offering_ouid = $this->config->phpunit->live->course_offering->ouid;
        
        $objGroupTypes = $this->service->getTypesByOrgUnitID($offering_ouid);
        $this->assertInternalType('array', $objGroupTypes);
        $this->assertContainsOnly('D2LWS_OrgUnit_Group_Type_Model', $objGroupTypes);
        $this->assertArrayHasKey($grouptype_ouid, $objGroupTypes);
        
        return $objGroupTypes;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_Soap_Client_Exception
     */
    public function testGetTypesByOrgUnitWhichDoesNotExist()
    {
        $objGroupType = $this->service->getTypesByOrgUnitID('9999999');
    }    

    /**
     * Test Creating New Group Type
     */
    public function testCreateGroupType()
    {
        $co = $this->getTestCourseOffering();
        if ( ! $co instanceof D2LWS_OrgUnit_CourseOffering_Model ) {
            $this->markTestSkipped('Could not retrieve test course offering!');
        }
        
        $objGType = new D2LWS_OrgUnit_Group_Type_Model();
        $objGType->setName('API Test Category')
                 ->setDescription('API Test Category Description!')
                 ->setIsDescriptionHTML(false)
                 ->setOwner($co);
        
        $savedGType = clone $objGType;
        $result = $this->service->save($savedGType);
        $this->assertTrue($result);
        $this->_assertModelsSameExcept($objGType, $savedGType, 'ID');
        $this->assertNotNull($savedGType->getID());
        return $savedGType;
    }
    
    /**
     * Test Updating Existing Group Type
     * @param D2LWS_OrgUnit_Group_Type_Model $existingGType
     * @depends testCreateGroupType
     */
    public function testUpdateGroupType(D2LWS_OrgUnit_Group_Type_Model $existingGType)
    {
        $saveGType = clone $existingGType;
        
        $newDescription = '<h1>'.uniqid('').'</h1>';
        $saveGType->setDescription($newDescription)
                  ->setIsDescriptionHTML(true);
        $result = $this->service->save($saveGType);
        $this->assertTrue($result);
        $this->_assertModelsSameExcept($existingGType, $saveGType, array(
            'Description',
            'IsDescriptionHTML'
        ));
    }
    
    /**
     * Test Deleting Group Type
     * @param D2LWS_OrgUnit_Group_Type_Model $existingGType 
     * @depends testCreateGroupType
     */
    public function testDeleteGroup(D2LWS_OrgUnit_Group_Type_Model $existingGType)
    {
        $this->assertTrue($this->service->delete($existingGType));
        
        try {
            $this->service->findByID(
                $existingGType->getID(),
                $existingGType->getOrgUnitTypeID()
            );
            $this->fail('DeleteGroupType call did not delete group!');
        } catch ( D2LWS_OrgUnit_Group_Type_Exception_NotFound $ex ) {
            // Exception thrown == pass
        }
    }
}
