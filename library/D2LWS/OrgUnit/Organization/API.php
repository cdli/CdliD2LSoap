<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Organization API
 */
class D2LWS_OrgUnit_Organization_API extends D2LWS_Common
{

    /**
     * Default Constructor
     * @param $i D2LWS_Instance - Instance to assign
     */
    public function __construct(D2LWS_Instance $i = NULL)
    {
        parent::__construct($i);

    }
    
    public function load()
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->GetOrganization();
        
        if ( $result instanceof stdClass && isset($result->Org) && $result->Org instanceof stdClass )
        {
            $Organization = new D2LWS_OrgUnit_Organization_Model($result->Org);
            return $Organization;
        }
        else
        {
            throw new D2LWS_OrgUnit_Organization_Exception_NotFound();
        }
    }
    
    
    public function getChildrenOf(D2LWS_OrgUnit_Organization_Model $org)
    {
        $i = $this->getInstance();        

        $result = $i->getSoapClient()
            ->setLocation($i->getConfig('webservice.org.endpoint'))
            ->setWsdl($i->getConfig('webservice.org.wsdl'))
            ->GetChildOrgUnitIds(array(
                'OrgUnitId'=>array(
                    'Id'=>$org->getID(),
                    'Source'=>'Desire2Learn'
                )
            ));
        
        return $result;
    }
    
    
    public function save(D2LWS_OrgUnit_Organization_Model $o)
    {
        $data = $o->getRawData();        
        $i = $this->getInstance();     

        return;
    }
    
}