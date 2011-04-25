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
 * PHPUnit test for D2LWS_Role_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @group APITests
 */
class D2LWS_Role_APITest extends GenericTestCase
{
    /**
     * Load an existing role by ID
     */
    public function testFindByRoleIdWhichExists()
    {
        $mockObj = $this->_createMockDataObject();

        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return a single Role object when
        // the specified Role ID exists in D2L
        $mock->getSoapClient()->addCallback("UserManagement", "GetRole",
            function($args) use (&$mockObj) {
                $mockObj->RoleId->Id = $args['RoleId']['Id'];
                $mockObj->RoleId->Source = $args['RoleId']['Source'];

                $result = new stdClass();
                $result->Role = $mockObj;
                return $result;
            }
        );

        $apiRole = new D2LWS_Role_API($mock);
        $roleObj = $apiRole->findByID(9999);

        $this->assertEquals(9999, $roleObj->getRoleID());
    }
    
    /**
     * Load a non-existent role by ID
     * @expectedException D2LWS_Role_Exception_NotFound
     */
    public function testFindByRoleIdWhichDoesNotExist()
    {
        $mockObj = $this->_createMockDataObject();

        $mock = $this->_getInstanceManagerWithMockSoapClient();

        // SOAP client should return empty response when D2L
        // could not find a role to match the ID specified
        $mock->getSoapClient()->addCallback("UserManagement", "GetRole",
            function($args) use (&$mockObj) {
                $result = new stdClass();
                return $result;
            }
        );

        $apiRole = new D2LWS_Role_API($mock);
        $roleObj = $apiRole->findByID(9999);
    }


    /**
     * Create an empty mock object
     */
    protected function _createMockDataObject()
    {
        $obj = new stdClass();

        $obj->RoleId = new stdClass();
        $obj->RoleId->Id = 0;
        $obj->RoleId->Source = "Desire2Learn";

        $obj->RoleName = new stdClass();
        $obj->RoleName->_ = '';

        $obj->Code = '';

        return $obj;
    }
}