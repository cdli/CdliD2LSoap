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
        $groupttype_ouid = $this->testOptions['live']['group_type']['ouid'];
        $offering_ouid = $this->testOptions['live']['course_offering']['ouid'];
        
        $objGroupType = $this->service->findByID($groupttype_ouid, $offering_ouid);
        $this->assertInstanceOf('D2LWS_OrgUnit_Group_Type_Model', $objGroupType);        
        $this->assertEquals($groupttype_ouid, $objGroupType->getID());
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
            $this->testOptions['live']['course_offering']['ouid']
        );
    }
    
}
