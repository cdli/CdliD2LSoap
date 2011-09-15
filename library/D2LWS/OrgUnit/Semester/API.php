<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
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
    
    public function findByCode($code)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetSemesterByCode(array(
                'Code'=>$code
            ));
        if ( $result instanceof stdClass && isset($result->Semester) && $result->Semester instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Semester_Model($result->Semester);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Semester_Exception_NotFound('Code=' . $code);
        }
    }
    
    /**
     * Persist user object to Desire2Learn
     * @param D2LWS_OrgUnit_Semester_Model $o Semester
     * @return bool
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function save(D2LWS_OrgUnit_Semester_Model &$o)
    {
        $data = $o->getRawData();        
        $i = $this->getInstance();     
        
        if ( is_null($o->getID()) )
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateSemester($data);
            
            if ( $result instanceof stdClass && isset($result->Semester) )
            {
                $o = new D2LWS_OrgUnit_Semester_Model($result->Semester);
                return true;
            }
        }
        else
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->UpdateSemester($data);
            return ( $result instanceof stdClass );
        }
        
        return false;
    }
}