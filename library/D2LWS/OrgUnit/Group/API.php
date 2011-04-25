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
 * Group OU API
 */
class D2LWS_OrgUnit_Group_API extends D2LWS_Common
{
        
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetGroup(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->Group) && $result->Group instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Group_Model($result->Group);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Group_Exception_NotFound('Id=' . $id);
        }
    }
    
}