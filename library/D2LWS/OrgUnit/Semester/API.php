<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Semester OU API
 */
class D2LWS_OrgUnit_Semester_API extends D2LWS_Common
{
        
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetSemester(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->Semester) && $result->Semester instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Semester_Model($result->Semester);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Semester_Exception_NotFound('Id=' . $id);
        }
    }
    
}