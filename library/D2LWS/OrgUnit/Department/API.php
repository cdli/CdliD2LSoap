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
    
    /**
     * Find department by code
     * @param string $code
     * @return D2LWS_OrgUnit_Department_Model
     * @throws D2LWS_OrgUnit_Department_Exception_NotFound
     */
    public function findByCode($code)
    {
        $i = $this->getInstance();

        //TODO: handle exceptions from SOAP client
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetDepartmentByCode(array(
                'Code'=>$code
            ));

        if ( $result instanceof stdClass && isset($result->Department) && $result->Department instanceof stdClass )
        {
            $Department = new D2LWS_OrgUnit_Department_Model($result->Department);
            return $Department;
        }
        else
        {
            //TODO: more descriptive exception message?
            throw new D2LWS_OrgUnit_Department_Exception_NotFound('Code=' . $code);
        }
    }
    
}