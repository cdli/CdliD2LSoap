<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: API.php 18 2011-02-07 15:53:03Z adamlundrigan $
 *
 */

 
/**
 * User Account API
 */
class D2LWS_User_API extends D2LWS_Common
{

    /**
     * Default Constructor
     * @param $i D2LWS_Instance - Instance to assign
     */
    public function __construct(D2LWS_Instance $i = NULL)
    {
        parent::__construct($i);

    }
    
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
     * @todo Move to new "Authentication" module?
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
    }
    
    
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
    }
    
    
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
    
    
    protected function _makeRequestArray($u)
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