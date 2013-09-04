<?php
/**
 * CdliD2LSoap - PHP5 Wrapper for Desire2Learn Web Services
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
 * User Account API
 */
class D2LWS_User_API extends D2LWS_Common
{
    
    /**
     * Find User by OUID
     * @param int $id
     * @return D2LWS_User_Model 
     * @throws D2LWS_User_Exception_NotFound on local error
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->GetUser(array(
                'UserId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->User) && $result->User instanceof stdClass )
        {
            $User = new D2LWS_User_Model($result->User);
            return $User;
        }
        else
        {
            throw new D2LWS_User_Exception_NotFound('OrgDefinedId=' . $id);
        }
    }
    
    /**
     * Find User by OrgDefinedId value
     * @param int $id
     * @return D2LWS_User_Model 
     * @throws D2LWS_User_Exception_NotFound on local error
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function findByOrgDefinedID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->GetUserByOrgDefinedId(array('OrgDefinedId'=>$id));
        
        if ( $result instanceof stdClass && isset($result->User) && $result->User instanceof stdClass )
        {
            $User = new D2LWS_User_Model($result->User);
            return $User;
        }
        else
        {
            throw new D2LWS_User_Exception_NotFound('OrgDefinedId=' . $id);
        }
    }
    
    /**
     * Find User by Login (User) Name
     * @param string $uname
     * @return D2LWS_User_Model 
     * @throws D2LWS_User_Exception_NotFound on local error
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function findByUserName($uname)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->GetUserByUserName(array('UserName'=>$uname));

        if ( $result instanceof stdClass && isset($result->User) && $result->User instanceof stdClass )
        {
            $User = new D2LWS_User_Model($result->User);
            return $User;
        }
        else
        {
            throw new D2LWS_User_Exception_NotFound('UserName=' . $uname);
        }
    }
    
    /**
     * Perform Single-SignOn for specified user
     * @param D2LWS_User_Model $u User Account
     * @return string|bool GUID if successful, false otherwise
     * @throws D2LWS_User_Exception_NotFound on local error
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function performSSO(D2LWS_User_Model $u)
    {
        $i = $this->getInstance();
        
        $result = $i->getSoapClient()
            ->setLocation($i->getConfig('webservice.guid.endpoint'))
            ->setWsdl($i->getConfig('webservice.guid.wsdl'))
            ->GenerateExpiringGuid(array(
                'guidType'=>'SSO',
                'orgId'=>$i->getConfig('server.orgUnit'),
                'installCode'=>$i->getConfig('server.installCode'),
                'TTL'=>$i->getConfig('server.ssoTTL'),
                'key'=>$i->getConfig('server.ssoToken') . $u->getUserName()
            ));
        
        if ( $result instanceof stdClass && isset($result->GenerateExpiringGuidResult) )
        {
            return $result->GenerateExpiringGuidResult;
        }
        
        return false;
    }
    
    /**
     * Retrieve User Course Enrollments 
     * @param type $UserID
     * @return D2LWS_OrgUnit_CourseOffering_Model 
     * @throws D2LWS_User_Exception_NotFound on local error
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function getActiveCourseOfferings($UserID)
    {
        $Result = array();
        
        $i = $this->getInstance(); 
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->GetActiveCourseOfferingsEx(array('UserId'=>array('Id'=>intval($UserID), 'Source'=>'Desire2Learn')));
        
        if ( $result instanceof stdClass && isset($result->CourseOfferings) && isset($result->CourseOfferings->CourseOfferingInfo) )
        {
            if ( !is_array($result->CourseOfferings->CourseOfferingInfo) && $result->CourseOfferings->CourseOfferingInfo instanceof stdClass )
            {
                $result->CourseOfferings->CourseOfferingInfo = array($result->CourseOfferings->CourseOfferingInfo);
                $result->Roles->RoleInfo = array($result->Roles->RoleInfo);
            }
            
            if ( is_array($result->CourseOfferings->CourseOfferingInfo) )
            {
                foreach ( $result->CourseOfferings->CourseOfferingInfo as $coKey=>$coObject )
                {
                    $ouData = new D2LWS_OrgUnit_CourseOffering_Model($coObject);
                    $roleData = new D2LWS_Role_Model($result->Roles->RoleInfo[$coKey]);
                    
                    $Result[$ouData->getID()] = array('CourseOffering'=>$ouData, 'Role'=>$roleData);
                }
                
                return $Result;
            }
            else
            {
                throw new D2LWS_User_Exception_NotFound('No Course Offering Enrollments for UserID=' . $UserID);
            }            
        }
        else
        {
            throw new D2LWS_User_Exception_NotFound('No Course Offering Enrollments for UserID=' . $UserID);
        }
    }

    /**
     * Determine if user is enrolled in the given org unit
     * @param int|D2LWS_User_Model $uid User
     * @param int|D2LWS_OrgUnit_Model $ouid Org Unit
     */
    public function isUserEnrolledInOU($uid, $ouid) 
    {
        return $this->isUserEnrolledInOUAsRole($uid, $ouid, NULL);
    }

    /**
     * Determine if user is enrolled in the given org unit
     * @param int|D2LWS_User_Model $user User
     * @param int|D2LWS_OrgUnit_Model $ou Org Unit
     */
    public function isUserEnrolledInOUAsRole($user, $ou, $role) 
    {
        $ouid = $ou instanceof D2LWS_OrgUnit_Model ? $ou->getID() : $ou;
        $uid  = $user instanceof D2LWS_User_Model ? $user->getUserID() : $user;

        $i = $this->getInstance(); 
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->GetOrgUnitEnrollment(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($ouid),
                    'Source'=>'Desire2Learn'
                ),
                'UserId'=>array(
                    'Id'=>intval($uid),
                    'Source'=>'Desire2Learn'
                )
            ));
        return ( is_null($role) && is_null($result) ) || ( !is_null($role) && $result instanceof stdClass && $result->OrgUnitEnrollment->RoleId->Id == $role );
    }
        
    /**
     * Enroll user in an OU as the specified role
     * @param int $UserID User ID
     * @param int $OUID OrgUnit ID
     * @param int $RoleID Role ID
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function enrollUserInOUAsRole($UserID, $OUID, $RoleID)
    {
        $i = $this->getInstance(); 
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->EnrollUser(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($OUID),
                    'Source'=>'Desire2Learn'
                ),
                'UserId'=>array(
                    'Id'=>intval($UserID),
                    'Source'=>'Desire2Learn'
                ),
                'RoleId'=>array(
                    'Id'=>intval($RoleID),
                    'Source'=>'Desire2Learn'
                )
            ));
        return ( $result instanceof stdClass );
    }
    
    /**
     * Unenroll user from specified OU
     * @param int $UserID User ID
     * @param int $OUID  OrgUnit ID
     * @throws D2LWS_User_Exception_NotFound on local error
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function unenrollUserFromOU($UserID, $OUID)
    {
        $i = $this->getInstance(); 
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.user.wsdl'))
            ->setLocation($i->getConfig('webservice.user.endpoint'))
            ->UnenrollUser(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($OUID),
                    'Source'=>'Desire2Learn'
                ),
                'UserId'=>array(
                    'Id'=>intval($UserID),
                    'Source'=>'Desire2Learn'
                )
            ));
        return ( $result instanceof stdClass );
    }
    
    /**
     * Update User Password
     * @param int $userId
     * @param string $newPassword
     * @return bool
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function savePassword($userId, $newPassword)
    {
        $i = $this->getInstance();   
        
        try
        {
        
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.user.wsdl'))
                ->setLocation($i->getConfig('webservice.user.endpoint'))
                ->ChangePassword(array(
                    'UserId'=>array(
                        'Id'=>$userId,
                        'Source'=>'Desire2Learn'
                    ),
                    'Password'=>$newPassword
                ));
                
            return ( $result instanceof stdClass );
        }
        catch ( Exception $ex )
        {
            return false;
        }
    }
    
    /**
     * Persist user object to Desire2Learn
     * @param D2LWS_User_Model $u User
     * @return bool
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function save(D2LWS_User_Model &$u)
    {
        $data = $u->getRawData();        
        $i = $this->getInstance();     
        
        if ( is_null($u->getUserID()) )
        {
            $arr = $this->_makeRequestArray($u);
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.user.wsdl'))
                ->setLocation($i->getConfig('webservice.user.endpoint'))
                ->CreateUser($arr);
                
            if ( $result instanceof stdClass && isset($result->User) )
            {
                $u = new D2LWS_User_Model($result->User);
                return true;
            }
        }
        else
        {
            $arr = $this->_makeRequestArray($u);
            unset($arr['Password']);
            
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.user.wsdl'))
                ->setLocation($i->getConfig('webservice.user.endpoint'))
                ->UpdateUser($arr);
            
            if ( $u->getRoleID() != NULL && $u->getRoleID() > 0 )
            {
                $enrollResult = $i->getSoapClient()
                    ->setWsdl($i->getConfig('webservice.user.wsdl'))
                    ->setLocation($i->getConfig('webservice.user.endpoint'))
                    ->EnrollUser(array(
                          'OrgUnitId'=>array(
                              'Id'=>$i->getConfig('server.orgUnit'),
                              'Source'=>'Desire2Learn'
                           ),
                          'UserId'=>array(
                              'Id'=>$u->getUserID(),
                              'Source'=>'Desire2Learn'
                           ),
                          'RoleId'=>array(
                              'Id'=>$u->getRoleID(),
                              'Source'=>'Desire2Learn'
                           )
                      ));
            }
            
            return ( $result instanceof stdClass );
        }
        
        return false;
    }
        
    /**
     * Delete User from D2L
     * @param D2LWS_User_Model $u User to delete
     * @return bool success?
     */
    public function delete(D2LWS_User_Model $u)
    {
        if ( !is_null($u->getUserID()) )
        {
            $i = $this->getInstance();
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.user.wsdl'))
                ->setLocation($i->getConfig('webservice.user.endpoint'))
                ->DeleteUser(array(
                    'UserId'=>array(
                        'Id'=>$u->getUserID(),
                        'Source'=>'Desire2Learn'
                    )
                ));
            
            return ( $result instanceof stdClass );
        }
        return false;
    }
    
    /**
     * Construct Request Structure for transmission via SOAP
     * @param D2LWS_User_Model $u User Object
     * @return array
     */
    protected function _makeRequestArray(D2LWS_User_Model $u)
    {
        $data = array(
            'UserName'=>$u->getUserName(),
            'Password'=>$u->getPassword(),
            'FirstName'=>$u->getFirstName(),
            'LastName'=>$u->getLastName(),
            'RoleId'=>array(
                'Id'=>$u->getRoleID(),
                'Source'=>'Desire2Learn'
            ),
            'OrgDefinedId'=>$u->getOrgDefinedID(),
            'FormsOfContact'=>array(
                'FormOfContactInfo'=>array(
                    'Type'=>'Email',
                    'Name'=>'ExternalEmail',
                    'Value'=>$u->getEmailAddress()
                )
            ),
            'Demographics'=>array(
                'BirthDate'=>$u->getBirthDate(),
                'Gender'=>$u->getGender()
            )
        );
        
        if ( !is_null($u->getUserID()) )
        {
            $data = array('User'=>$data);
            $data['User']['UserId'] = array(
                'Id'=>$u->getUserID(),
                'Source'=>'Desire2Learn'
            );
        }
        
        return $data;
    }

}
