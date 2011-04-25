<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id$
 *
 */

/**
 * PHPUnit test for D2LWS_Authenticate
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @group CoreTests
 */
class D2LWS_AuthenticateTest extends GenericTestCase
{
    
    /**
     * Test our ability to load up a mock instance manager
     */
    public function testCanGetInstanceManagerWithAuthenticateInstance()
    {
        $o = $this->_getInstanceManagerWithMockSoapClient();
        $this->assertType("D2LWS_Instance", $o);
        $this->assertType("D2LWS_Authenticate", $o->getAuthManager());
    }

    /**
     * Test that getToken() will work on valid SOAP result, but fail if we
     * access the token too many time
     */
    public function testGetTokenEnforcesTokenUsageLimitProperly()
    {
        $o = $this->_getInstanceManagerWithMockSoapClient();
        $o->getSoapClient()->addCallback("AuthenticationToken", "Authenticate2",
           function ($args) {
               static $call = 1;
               
               $result = new stdClass();
               $result->status = "Success";
               $result->token = 'MYTESTTOKEN' . $call;
               $result->tokenSettings = new stdClass();
               $result->tokenSettings->maxUsageCount = 2;
               $result->tokenSettings->lifetimeInSeconds = time() + 30;

               $call++;
               
               return $result;
           }
        );

        // First call will create a new token
        $token1 = $o->getAuthManager()->getToken();
        $this->assertEquals('MYTESTTOKEN1', $token1);

        // Second call will reuse the existing token
        $this->assertEquals($token1, $o->getAuthManager()->getToken());

        // Third call should generate a new token since we've set maxUsageCount to 2
        $token2 = $o->getAuthManager()->getToken();
        $this->assertEquals('MYTESTTOKEN2', $token2);
        $this->assertNotEquals($token1, $token2);
    }

    /**
     * Test that getToken() will work on valid SOAP result
     */
    public function testGetTokenWillWorkWithValidResult()
    {
        $o = $this->_getInstanceManagerWithMockSoapClient();
        $o->getSoapClient()->addCallback("AuthenticationToken", "Authenticate2",
           function ($args) {
               $result = new stdClass();
               $result->status = "Success";
               $result->token = 'MYTESTTOKEN12345';
               $result->tokenSettings = new stdClass();
               $result->tokenSettings->maxUsageCount = 2;
               $result->tokenSettings->lifetimeInSeconds = time() + 30;
               return $result;
           }
        );
        $this->assertEquals('MYTESTTOKEN12345', $o->getAuthManager()->getToken());
    }

    /**
     * Test that authenticate() will return false on exception
     * We know this because getToken() will throw an exception only if authenticate() returns false
     * @expectedException D2LWS_Soap_Client_Exception_AuthenticationFailed
     */
    public function testAuthenticateWillReturnFalseOnException()
    {
        $o = $this->_getInstanceManagerWithMockSoapClient();
        $o->getSoapClient()->addCallback("AuthenticationToken", "Authenticate2",
           function ($args) {
               throw new Exception("bogus");
           }
        );
        
        $o->getAuthManager()->getToken();
    }

    /**
     * Test that getToken() will trigger exception on failure
     * @expectedException D2LWS_Soap_Client_Exception_AuthenticationFailed
     */
    public function testGetTokenWillTriggerExceptionOnFailure()
    {
        $o = $this->_getInstanceManagerWithMockSoapClient();
        $o->getSoapClient()->addCallback("AuthenticationToken", "Authenticate2",
           function ($args) {
               return false;
           }
        );
        $this->assertFalse($o->getAuthToken());
    }


    /**
     * Test that calling Authenticate() and Authenticate2() on SOAP client
     * does not trigger
     * @
     */
    public function testAuthenticateCallsOnSoapObjectExcludeAuthenticationToken()
    {
        $o = $this->_getInstanceManager();
        var_dump($o);
    }

}