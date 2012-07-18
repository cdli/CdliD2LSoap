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
 * Course Offering OU API
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
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
    
    /**
     * Persist Course Offering object to Desire2Learn
     * @param D2LWS_OrgUnit_CourseOffering_Model $o Course Offering
     * @return bool
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function save(D2LWS_OrgUnit_CourseOffering_Model &$o)
    {
        $data = $o->getRawData();        
        $i = $this->getInstance();     
        
        if ( is_null($o->getID()) )
        {
            unset($data->OrgUnitId);
            
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateCourseOffering($data);
            
            if ( $result instanceof stdClass && isset($result->CourseOffering) )
            {
                $o = new D2LWS_OrgUnit_CourseOffering_Model($result->CourseOffering);
                return true;
            }
        }
        else
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->UpdateCourseOffering(array(
                      'CourseOffering'=>(array)$data
                  ));
            return ( $result instanceof stdClass );
        }
        
        return false;
    }
    
    /**
     * Delete Course Offering object from Desire2Learn
     * @param D2LWS_OrgUnit_CourseOffering_Model $o Course Offering
     * @return bool
     */
    public function delete(D2LWS_OrgUnit_CourseOffering_Model &$o)
    {
        if ( is_null($o->getID()) ) {
            return false;
        }
        
        $i = $this->getInstance();
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->DeleteCourseOffering(array(
                  'OrgUnitId'=>array(
                      'Id'=>$o->getID(),
                      'Source'=>'Desire2Learn'
                  )
              ));
        return ( $result instanceof stdClass );
    }
    
}
