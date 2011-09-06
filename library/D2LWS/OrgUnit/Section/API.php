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
    
}