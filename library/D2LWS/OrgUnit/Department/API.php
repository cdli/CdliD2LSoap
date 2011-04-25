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
 * Department OU API
 */
class D2LWS_OrgUnit_Department_API extends D2LWS_Common
{
        
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetDepartment(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->Department) && $result->Department instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Department_Model($result->Department);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Department_Exception_NotFound('Id=' . $id);
        }
    }
    
}