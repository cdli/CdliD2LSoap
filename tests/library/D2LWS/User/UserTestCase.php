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
 * PHPUnit test case for User API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
class UserTestCase extends GenericTestCase
{
    /**
     * Defines the methods we should test
     * @var array
     */
    protected $_methodsToTest = array(
        'UserID'=>array(
            'get'=>'getUserID',
            'set'=>'setUserID'
        ),
        'UserName'=>array(
            'get'=>'getUserName',
            'set'=>'setUserName'
        ),
        'OrgDefinedID'=>array(
            'get'=>'getOrgDefinedID',
            'set'=>'setOrgDefinedID'
        ),
        'RoleID'=>array(
            'get'=>'getRoleID',
            'set'=>'setRoleID'
        ),
        'Password'=>array(
            'get'=>'getPassword',
            'set'=>'setPassword'
        ),
        'FirstName'=>array(
            'get'=>'getFirstName',
            'set'=>'setFirstName'
        ),
        'LastName'=>array(
            'get'=>'getLastName',
            'set'=>'setLastName'
        ),
        'EmailAddress'=>array(
            'get'=>'getEmailAddress',
            'set'=>'setEmailAddress'
        ),
        'Gender'=>array(
            'get'=>'getGender',
            'set'=>'setGender'
        ),
        'BirthDate'=>array(
            'get'=>'getBirthDate',
            'set'=>'setBirthDate'
        )
    );

    /**
     * Create an empty mock object
     */
    protected function _createMockDataObject()
    {
        $obj = new stdClass();
        $obj->UserId = new stdClass();

        $obj->UserId->Id = 0;
        $obj->UserId->Source = "Desire2Learn";

        $obj->UserName = new stdClass();
        $obj->UserName->_ = "";

        $obj->OrgDefinedId = new stdClass();
        $obj->OrgDefinedId->_ = 0;

        $obj->RoleId = new stdClass();
        $obj->RoleId->_ = 0;

        $obj->Password = new stdClass();
        $obj->Password->_ = "";

        $obj->FirstName = new stdClass();
        $obj->FirstName->_ = "";

        $obj->LastName = new stdClass();
        $obj->LastName->_ = "";

        $obj->FormsOfContact = new stdClass();
        $obj->FormsOfContact->FormOfContactInfo = new stdClass();
        $obj->FormsOfContact->FormOfContactInfo->Type = '';
        $obj->FormsOfContact->FormOfContactInfo->Name = '';
        $obj->FormsOfContact->FormOfContactInfo->Value = '';

        $obj->Demographics = new stdClass();
        $obj->Demographics->Gender = new stdClass();
        $obj->Demographics->Gender->_ = '';
        $obj->Demographics->BirthDate = new stdClass();
        $obj->Demographics->BirthDate->_ = '';

        return $obj;
    }

    /**
     * Create mock model object
     */
    protected function _createMockModel()
    {
         return new D2LWS_User_Model($this->_createMockDataObject());
    }
}