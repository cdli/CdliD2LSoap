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
 * Section OU API
 */
class D2LWS_OrgUnit_Section_API extends D2LWS_Common
{
        
    public function findByID($id)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetSection(array(
                'OrgUnitId'=>array(
                    'Id'=>intval($id),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        if ( $result instanceof stdClass && isset($result->Section) && $result->Section instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Section_Model($result->Section);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Section_Exception_NotFound('Id=' . $id);
        }
    }
    
    public function findByCode($code)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetSectionByCode(array(
                'Code'=>$code
            ));        
        if ( $result instanceof stdClass && isset($result->Section) && $result->Section instanceof stdClass )
        {
            $User = new D2LWS_OrgUnit_Section_Model($result->Section);
            return $User;
        }
        else
        {
            throw new D2LWS_OrgUnit_Section_Exception_NotFound('Code=' . $code);
        }
    }
    
    
    /**
     * Persist Section object to Desire2Learn
     * @param D2LWS_OrgUnit_Section_Model $o Course Offering
     * @return bool
     * @throws D2LWS_Soap_Client_Exception on server error
     */
    public function save(D2LWS_OrgUnit_Section_Model &$o)
    {
        $data = $o->getRawData();        
        $i = $this->getInstance();     
        
        if ( is_null($o->getID()) )
        {
            unset($data->OrgUnitId);
            
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->CreateSection($data);
            
            if ( $result instanceof stdClass && isset($result->Section) )
            {
                $o = new D2LWS_OrgUnit_Section_Model($result->Section);
                return true;
            }
        }
        else
        {
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->UpdateSection(array(
                      'Section'=>(array)$data
                  ));
            return ( $result instanceof stdClass );
        }
        
        return false;
    }
        
    /**
     * Delete Section from D2L
     * @param D2LWS_OrgUnit_Section_Model $g Section to delete
     * @return bool success?
     */
    public function delete(D2LWS_OrgUnit_Section_Model $g)
    {
        if ( !is_null($g->getID()) )
        {
            $i = $this->getInstance();
            $result = $i->getSoapClient()
                ->setWsdl($i->getConfig('webservice.org.wsdl'))
                ->setLocation($i->getConfig('webservice.org.endpoint'))
                ->DeleteSection(array(
                    'OrgUnitId'=>array(
                        'Id'=>$g->getID(),
                        'Source'=>'Desire2Learn'
                    )
                ));
            
            return ( $result instanceof stdClass );
        }
        return false;
    }
}