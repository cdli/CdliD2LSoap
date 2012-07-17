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
 * PHPUnit live-server test for D2LWS_User_API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * 
 * @group D2LWS
 * @group D2LWS_API
 * @group D2LWS_User
 * @group D2LWS_Live
 */
class D2LWS_User_APILiveTest extends LiveTestCase
{

    /**
     * Service API
     * @var D2LWS_User_API
     */
    protected $service = NULL;
    
    /**
     * Set up the Service API instance
     */
    public function setUp()
    {
        parent::setUp();
        
        $api = $this->_getInstanceManager();
        $this->service = new D2LWS_User_API($api);
    }
    
    /**
     * Fetch our test user by it's ID
     */
    public function testFindByIdentifierWhichExists()
    {
        $ouid = $this->config['phpunit']['live']['student']['ouid'];
        
        $objUser = $this->service->findByID($ouid);
        $this->assertInstanceOf('D2LWS_User_Model', $objUser);        
        $this->assertEquals($ouid, $objUser->getUserID());
        
        return $objUser;
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testFindByIdentifierWhichDoesNotExist()
    {
        $ouid = '999999999';
        $this->service->findByID($ouid);
    }
    
    /**
     * Fetch our test user by their OrgDefinedId
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByOrgDefinedIdWhichExists(D2LWS_User_Model $u)
    {
        $objUser = $this->service->findByOrgDefinedId($u->getOrgDefinedID());
        $this->assertInstanceOf('D2LWS_User_Model', $objUser);
        $this->assertEquals($u, $objUser);
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testFindByOrgDefinedIdWhichDoesNotExist()
    {
        $this->service->findByOrgDefinedId(md5(uniqid("")));
    }
    
    /**
     * Fetch our test user by their user name
     * @depends testFindByIdentifierWhichExists
     */
    public function testFindByUserNameWhichExists(D2LWS_User_Model $u)
    {
        $objUser = $this->service->findByUserName($u->getUserName());
        $this->assertInstanceOf('D2LWS_User_Model', $objUser);
        $this->assertEquals($u, $objUser);
    }
    
    /**
     * Attempt to fetch a non-existent OUID
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testFindByUserNameWhichDoesNotExist()
    {
        $this->service->findByUserName(md5(uniqid("")));
    }
    
    /**
     * Test SSO
     * @depends testFindByIdentifierWhichExists
     * @todo More robust test needed!
     */
    public function testPerformSingleSignon(D2LWS_User_Model $u)
    {
        // Generate a SSO token
        $token = $this->service->performSSO($u);
        $this->assertTrue($token !== false);
        $this->assertInternalType('string', $token);

        // Perform a HTTP request to check the token

        // ...make sure we have cURL
        if ( !function_exists('curl_init') )
            $this->markTestSkipped('cURL extension not found!');
        
        // ...run the request
        $api = $this->_getInstanceManager();
        $serverUrl = $api->getConfig('webservice.guid.ssoLogin');
        $ch = curl_init("{$serverUrl}?guid={$token}&username={$u->getUserName()}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        // ...check for success
		$this->assertGreaterThan(0, preg_match('{Location: ([^\s]+)[\r\n]+}is', $response, $locationHeaders));
        $this->assertNotContains('/d2l/tools/error/401error.asp', $locationHeaders, 'Single Sign-on Failed (Redirect to 401error.asp)');
        $this->assertContains('/d2l/lp/ouHome/loginHome.d2l', $locationHeaders, 'Single Sign-on Failed (No redirect to loginHome.d2l)');
    }
    
    /**
     * @depends testFindByIdentifierWhichExists
     */
    public function testGetActiveCourseOfferings(D2LWS_User_Model $u)
    {
        $course = $this->config['phpunit']['live']['course_offering']['ouid'];
        $offerings = $this->service->getActiveCourseOfferings($u->getUserID());
        $this->assertArrayHasKey($course, $offerings);
        $this->assertArrayHasKey('CourseOffering', $offerings[$course]);
        $this->assertInstanceOf('D2LWS_OrgUnit_CourseOffering_Model', $offerings[$course]['CourseOffering']);
        $this->assertArrayHasKey('Role', $offerings[$course]);
        $this->assertInstanceOf('D2LWS_Role_Model', $offerings[$course]['Role']);
    }
    
    /**
     * @depends testFindByIdentifierWhichExists
     */
    public function testUnenrollUserFromOrgUnit(D2LWS_User_Model $u)
    {
        $OUID = $this->config['phpunit']['live']['course_offering']['ouid'];
        $this->assertTrue($this->service->unenrollUserFromOU($u->getUserID(), $OUID));
        return $u;
    }
    
    /**
     * @depends testUnenrollUserFromOrgUnit
     */
    public function testEnrollUserInOUASRole(D2LWS_User_Model $u)
    {
        $OUID = $this->config['phpunit']['live']['course_offering']['ouid'];
        $RoleID = $this->config['phpunit']['live']['roles']['student']['ouid'];        
        $this->assertTrue($this->service->enrollUserInOUASRole($u->getUserID(), $OUID, $RoleID));
    }
    
    public function testCreateUser()
    {
        $RoleID = $this->config['phpunit']['live']['roles']['student']['ouid'];
        
        $obj = new D2LWS_User_Model();
        $obj->setUserName('zfd2luser')
            ->setOrgDefinedID('ZFD2LUSER')
            ->setRoleID($RoleID)
            ->setPassword('zfD2L')
            ->setFirstName('ZFD2L')
            ->setLastName('TEST')
            ->setEmailAddress('foo@bar.com')
            ->setGender('Male')
            ->setBirthDate(date("Y-m-d\TH:i:s", time()-3600*24*10000));

        $this->assertTrue($this->service->save($obj));
        $this->assertNotNull($obj->getUserID());
        
        $savedObj = $this->service->findByID($obj->getUserID());
        //@todo For some reason, our D2L dev server adds 5h to timestamps.  Ignore for now
        //$this->assertEquals($obj, $savedObj);
        $this->_assertModelsSameExcept($obj, $savedObj, array('BirthDate'));
        
        return $obj;
    }
 
    /**
     * @depends testCreateUser
     */
    public function testUpdateUser(D2LWS_User_Model $obj)
    {
        $obj->setLastName('APITEST');
        $this->assertTrue($this->service->save($obj));
        
        $savedObj = $this->service->findByID($obj->getUserID());
        $this->assertEquals('APITEST', $savedObj->getLastName());
    }
 
    /**
     * @depends testCreateUser
     */
    public function testUpdateUserWithNewRole(D2LWS_User_Model $obj)
    {
        $RoleID = $this->config['phpunit']['live']['roles']['observer']['ouid'];
        
        $obj->setRoleID($RoleID);
        $this->assertTrue($this->service->save($obj));
    }
    
    /**
     * @depends testCreateUser
     * @expectedException D2LWS_User_Exception_NotFound
     */
    public function testDeleteUser(D2LWS_User_Model $obj)
    {
        $this->assertTrue($this->service->delete($obj));
        $savedObj = $this->service->findByID($obj->getUserID());
    }
    
    /**
     * @depends testCreateUser
     */
    public function testDeleteUnsavedUser(D2LWS_User_Model $obj)
    {
        $this->assertFalse($this->service->delete(new D2LWS_User_Model()));
    }
}
