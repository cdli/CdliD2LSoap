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
 * Course Offering OU API
 */
class D2LWS_OrgUnit_CourseOffering_API extends D2LWS_Common
{
    /**
     * Find course offering by org unit identifier
     * @param int $id
     * @return D2LWS_OrgUnit_CourseOffering_Model
     * @throws D2LWS_OrgUnit_CourseOffering_Exception_NotFound
     */
    public function findByID($id)
    {
        $i = $this->getInstance();        

        //TODO: handle exceptions from SOAP client
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetCourseOffering(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->CourseOffering) && $result->CourseOffering instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_CourseOffering_Model($result->CourseOffering);
            return $User;
        }
        else
        {
            //TODO: more descriptive exception message?
            throw new D2LWS_OrgUnit_CourseOffering_Exception_NotFound('Id=' . $id);
        }
    }

    /**
     * Find course offering by code
     * @param string $code
     * @return D2LWS_OrgUnit_CourseOffering_Model
     * @throws D2LWS_OrgUnit_CourseOffering_Exception_NotFound
     */
    public function findByCode($code)
    {
        $i = $this->getInstance();

        //TODO: handle exceptions from SOAP client
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetCourseOfferingByCode(array(
                'Code'=>$code
            ));

        if ( $result instanceof stdClass && isset($result->CourseOffering) && $result->CourseOffering instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_CourseOffering_Model($result->CourseOffering);
            return $User;
        }
        else
        {
            //TODO: more descriptive exception message?
            throw new D2LWS_OrgUnit_CourseOffering_Exception_NotFound('Code=' . $code);
        }
    }
    
}