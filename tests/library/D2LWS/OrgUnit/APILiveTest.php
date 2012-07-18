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
 * PHPUnit live-server test for D2LWS_OrgUnit_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_OrgUnit
 * @group D2LWS_Live
 */
class D2LWS_OrgUnit_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_OrgUnit_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_OrgUnit_API($api);
    }
    
    /**
     * Fetch children of an organizational unit
     */
    public function testGetChildrenOfOrgUnit()
    {
        $ouid = $this->config['phpunit']['live']['semester']['ouid'];
        $child_ouid = $this->config['phpunit']['live']['course_template']['ouid'];
        
        $objChildren = $this->service->getChildrenOf($ouid);
        $this->assertInternalType('array', $objChildren);        
        $this->assertArrayHasKey($child_ouid, $objChildren);
        $this->assertInstanceOf(
            'D2LWS_OrgUnit_CourseTemplate_Model', 
            $objChildren[$child_ouid]
        );
    }

    /**
     * @expectedException D2LWS_Soap_Client_Exception
     */
    public function testGetChildrenOfOrgUnitWithNonExistentOu()
    {
        $objChildren = $this->service->getChildrenOf(9999999);
    }

}
