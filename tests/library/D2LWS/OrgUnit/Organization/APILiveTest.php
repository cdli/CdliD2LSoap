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
 * PHPUnit live-server test for D2LWS_OrgUnit_Organization_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_OrgUnit_Organization
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_Organization_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_Organization_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_Organization_API($api);
    }
    
    /**
     * Fetch our Organization
     */
    public function testLoadOrganization()
    {
        $objOrganization = $this->service->load();
        $this->assertInstanceOf('D2LWS_OrgUnit_Organization_Model', $objOrganization);
        $this->assertEquals(
            $this->service->getInstance()->getConfig('server.orgUnit'),
            $objOrganization->getID()
        );        
        return $objOrganization;
    }
    
    /**
     * Fetch list of child OUs for Organization
     * @depends testLoadOrganization
     */
    public function testGetChildrenOfOrganization(D2LWS_OrgUnit_Organization_Model $org)
    {
        $children = $this->service->getChildrenOf($org);
        $this->assertInstanceOf('stdClass', $children);
        $this->assertObjectHasAttribute('OrgUnitIds', $children);
        $this->assertObjectHasAttribute('OrgUnitIdentifier', $children->OrgUnitIds);
        $this->assertInternalType('array', $children->OrgUnitIds->OrgUnitIdentifier);
        $this->assertContainsOnly('stdClass', $children->OrgUnitIds->OrgUnitIdentifier);
    }
    
}
