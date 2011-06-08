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
 * PHPUnit test for D2LWS_Authenticate
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_Core
 * @group D2LWS_Live
 */
class D2LWS_AuthenticateLiveTest extends GenericTestCase
{
    
    /**
     * Pre-Test Setup
     */
    public function setUp()
    {
        parent::setUp();
        if ( @$this->testOptions['live']['run_live_tests'] != true )
        {
            $this->markTestSkipped('Live-Server Tests are Disabled');
        }
    }

    /**
     * Test our ability to receive an authentication token from the server
     */
    public function testCanAuthenticateAgainstLiveServer()
    {
        $o = $this->_getInstanceManager();
        $authMgr = $o->getAuthManager();
        $token = $authMgr->getToken();
        
        $this->assertInternalType('string', $token);
        $this->assertEquals(600, strlen($token));
    }

}