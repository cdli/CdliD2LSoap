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
 * PHPUnit test for D2LWS_Instance against live D2L server
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Core
 * @group D2LWS_Live
 */
class D2LWS_InstanceLiveTest extends GenericTestCase
{
    
    /**
     * Test our ability to load up the instance manager
     */
    public function testCanGetInstanceManagerWithSoapClient()
    {
        $o = $this->_getInstanceManager();
        $this->assertInstanceOf("D2LWS_Instance", $o);
        $this->assertInstanceOf("D2LWS_Soap_Client", $o->getSoapClient());
        $this->assertInstanceOf("D2LWS_Soap_Client_Interface", $o->getSoapClient());
    }

    /**
     * Test our ability to receive an authentication token from the server
     */
    public function testCanGetAuthenticationTokenFromLiveServer()
    {
        $o = $this->_getInstanceManager();
        $token = $o->getAuthToken();
        $this->assertInternalType('string', $token);
        $this->assertEquals(600, strlen($token));
    }

}