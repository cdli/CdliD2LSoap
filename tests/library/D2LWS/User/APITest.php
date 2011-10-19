<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/adamlundrigan/zfD2L/blob/0.1a0/LICENSE
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
 * PHPUnit test for D2LWS_User_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_User
 */
class D2LWS_User_APITest extends GenericTestCase
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

    /**
     * Load an existing user by username
     */
    public function testFindByUserNameWhichExists()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return a single User object when
        // the specified User ID exists in D2L
        $mock->getSoapClient()->addCallback("UserManagement", "GetUserByUserName",
            function($args) use (&$mockObj) {
                $mockObj->UserName->_ = $args['UserName'];

                $result = new stdClass();
                $result->User = $mockObj;
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->findByUserName('TestUser');

        $this->assertEquals('TestUser', $userObj->getUserName());
    }

    /**
     * Load a non-existent user by username
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testFindByUserNameWhichDoesNotExist()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return empty response when D2L
        // could not find a user to match the ID specified
        $mock->getSoapClient()->addCallback("UserManagement", "GetUserByUserName",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->findByUserName('TestUser');
    }
    
    public function testGetActiveCourseOfferingsWhenSingleResultIsReturned()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return empty response when D2L
        // could not find active course enrollments for user
        $mock->getSoapClient()->addCallback("UserManagement", "GetActiveCourseOfferingsEx",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                
                $result->CourseOfferings = new stdClass();
                $result->CourseOfferings->CourseOfferingInfo = new stdClass();
                $result->CourseOfferings->CourseOfferingInfo->OrgUnitId = new stdClass();
                $result->CourseOfferings->CourseOfferingInfo->OrgUnitId->Id = 42;
                
                $result->Roles = new stdClass();
                $result->Roles->RoleInfo = new stdClass();
                $result->Roles->RoleInfo->RoleId = new stdClass();
                $result->Roles->RoleInfo->RoleId->Id = 24;
                
                return $result;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $results = $apiUser->getActiveCourseOfferings(9999);
        
        $this->assertInternalType('array', $results);
        $this->assertArrayHasKey(42, $results);
        $this->assertArrayHasKey('CourseOffering', $results[42]);
        $this->assertInstanceOf('D2LWS_OrgUnit_CourseOffering_Model', $results[42]['CourseOffering']);
        $this->assertEquals(42, $results[42]['CourseOffering']->getID());
        $this->assertArrayHasKey('Role', $results[42]);
        $this->assertInstanceOf('D2LWS_Role_Model', $results[42]['Role']);
        $this->assertEquals(24, $results[42]['Role']->getRoleID());
    }

    /**
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testGetActiveCourseOfferingsWhenReturnedDataIsInvalid()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return empty response when D2L
        // could not find active course enrollments for user
        $mock->getSoapClient()->addCallback("UserManagement", "GetActiveCourseOfferingsEx",
            function($args) use (&$mockObj) {
                return NULL;
            }
        );

        $apiUser = new D2LWS_User_API($mock);
        $userObj = $apiUser->getActiveCourseOfferings(9999);
    }
    
    /**
     * Test Single Sign-on
     */
    public function testPerformSingleSignon()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return a single User object when
        // the specified User ID exists in D2L
        $mock->getSoapClient()->addCallback("D2L.Guid", "GenerateExpiringGuid",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                $result->GenerateExpiringGuidResult = 'GUID';
                return $result;
            }
        );

        $o = $this->_createMockModel();
        
        $apiUser = new D2LWS_User_API($mock);
        $guid = $apiUser->performSSO($o);

        $this->assertEquals('GUID', $guid);
    }
  
    /**
     * Test Single Sign-on w/ Failure
     */
    public function testPerformSingleSignonFailure()
    {
        $mockObj = $this->_createMockDataObject();
        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return a single User object when
        // the specified User ID exists in D2L
        $mock->getSoapClient()->addCallback("D2L.Guid", "GenerateExpiringGuid",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                return $result;
            }
        );

        $o = $this->_createMockModel();
        
        $apiUser = new D2LWS_User_API($mock);
        $guid = $apiUser->performSSO($o);

        $this->assertEquals(false, $guid);
    }
    
    /**
     * Create mock model object
     * @return D2LWS_User_Model
     */
    public function _createMockModel()
    {
        return new D2LWS_User_Model();
    }
    
}