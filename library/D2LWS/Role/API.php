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
 * Role Account API
 */
class D2LWS_Role_API extends D2LWS_Common
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
            ->GetRole(array(
                'RoleId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->Role) && $result->Role instanceof stdClass )
        {
            $Role = new D2LWS_Role_Model($result->Role);
            return $Role;
        }
        else
        {
            throw new D2LWS_Role_Exception_NotFound('RoleID=' . $id);
        }
    }
    
}