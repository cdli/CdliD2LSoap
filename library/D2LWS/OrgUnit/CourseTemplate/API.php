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
 * Course Template OU API
 */
class D2LWS_OrgUnit_CourseTemplate_API extends D2LWS_Common
{
        
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetCourseTemplate(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->CourseTemplate) && $result->CourseTemplate instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_CourseTemplate_Model($result->CourseTemplate);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_CourseTemplate_Exception_NotFound('Id=' . $id);
        }
    }

    /**
     * Find course template by code
     * @param string $code
     * @return D2LWS_OrgUnit_CourseTemplate_Model
     * @throws D2LWS_OrgUnit_CourseTemplate_Exception_NotFound
     */
    public function findByCode($code)
    {
        $i = $this->getInstance();

        //TODO: handle exceptions from SOAP client
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetCourseTemplateByCode(array(
                'Code'=>$code
            ));

        if ( $result instanceof stdClass && isset($result->CourseTemplate) && $result->CourseTemplate instanceof stdClass )
        {
            $Template = new D2LWS_OrgUnit_CourseTemplate_Model($result->CourseTemplate);
            return $Template;
        }
        else
        {
            //TODO: more descriptive exception message?
            throw new D2LWS_OrgUnit_CourseTemplate_Exception_NotFound('Code=' . $code);
        }
    }
    
    /**
     * Persist Course Template object to Desire2Learn
     * @param D2LWS_OrgUnit_CourseTemplate_Model $o Course Template
     * @return bool
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function save(D2LWS_OrgUnit_CourseTemplate_Model &$o)
    {
        $data = $o->getRawData();        
        $i = $this->getInstance();     
        
        if ( is_null($o->getID()) )
        {
            unset($data->OrgUnitId);
            
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateCourseTemplate($data);
            
            if ( $result instanceof stdClass && isset($result->CourseTemplate) )
            {
                $o = new D2LWS_OrgUnit_CourseTemplate_Model($result->CourseTemplate);
                return true;
            }
        }
        else
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->UpdateCourseTemplate(array(
                      'CourseTemplate'=>(array)$data
                  ));
            return ( $result instanceof stdClass );
        }
        
        return false;
    }
    
    /**
     * Delete Course Template object from Desire2Learn
     * @param D2LWS_OrgUnit_CourseTemplate_Model $o Course Template
     * @return bool
     */
    public function delete(D2LWS_OrgUnit_CourseTemplate_Model &$o)
    {
        if ( is_null($o->getID()) ) {
            return false;
        }
        
        $i = $this->getInstance();
        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->DeleteCourseTemplate(array(
                  'OrgUnitId'=>array(
                      'Id'=>$o->getID(),
                      'Source'=>'Desire2Learn'
                  )
              ));
        return ( $result instanceof stdClass );
    }
    
}