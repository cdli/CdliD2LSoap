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
 * Include the test case definition
 */
require_once "UserTestCase.php";

/**
 * PHPUnit test for D2LWS_User_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @group APITests
 */
class D2LWS_User_APITest extends UserTestCase
{
    /**
     * Load an existing user by ID
     */
    public function testFindByUserIdWhichExists()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();
        $test = $this;

        // SOAP client should return a single User object when
        // the specified User ID exists in D2L
        $mock->getSoapClient()->addCallback("UserManagement", "GetUser",
            function($args) use (&$mockObj, &$test) {
                $test->assertArrayHasKey('UserId', $args);
                $test->assertArrayHasKey('Id', $args['UserId']);
                $test->assertArrayHasKey('Source', $args['UserId']);
                $test->assertEquals('Desire2Learn', $args['UserId']['Source']);
                
                $mockObj->UserId->Id = $args['UserId']['Id'];
                $mockObj->UserId->Source = $args['UserId']['Source'];

                $result = new stdClass();
                $result->User = $mockObj;
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->findByID(9999);

        $this->assertEquals(9999, $userObj->getUserID());
    }
    
    /**
     * Load a non-existent user by ID
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testFindByUserIdWhichDoesNotExist()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return empty response when D2L
        // could not find a user to match the ID specified
        $mock->getSoapClient()->addCallback("UserManagement", "GetUser",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->findByID(9999);
    }

    /**
     * Load an existing user by ID
     */
    public function testFindByOrgDefinedIdWhichExists()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return a single User object when
        // the specified User ID exists in D2L
        $mock->getSoapClient()->addCallback("UserManagement", "GetUserByOrgDefinedId",
            function($args) use (&$mockObj) {
                $mockObj->OrgDefinedId->_ = $args['OrgDefinedId'];

                $result = new stdClass();
                $result->User = $mockObj;
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->findByOrgDefinedID(9999);

        $this->assertEquals(9999, $userObj->getOrgDefinedID());
    }

    /**
     * Load a non-existent user by ID
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testFindByOrgDefinedIdWhichDoesNotExist()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return empty response when D2L
        // could not find a user to match the ID specified
        $mock->getSoapClient()->addCallback("UserManagement", "GetUserByOrgDefinedId",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->findByOrgDefinedID(9999);
    }

}