<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Organization Model
 */
class D2LWS_OrgUnit_Organization_Model
{
    const OUTYPE = "Organization";
    
    protected $_data = NULL;
    
    /**
     * Default Constructor
     * @param $soapResponse stdClass - Response from SOAP call
     */
    public function __construct(stdClass $soapResponse = NULL)
    {
        $this->_data = $soapResponse;
    }

    /**
     * Retrieve the organization identifier (OrgUnitID)
     * @return integer - Org Unit ID
     */
    public function getID() { return $this->_data->OrgUnitId->Id; }
    
    /**
     * Set the organization identifier (OrgUnitID)
     * @param $id integer - Identifier
     * @return $this
     */
    public function setID($id) { $this->_data->OrgUnitId->Id = intval($id); return $this; }

    /**
     * Retrieve the organization name
     * @return string - Name
     */
    public function getName() { return $this->_data->Name; }
    
    /**
     * Set the organization name
     * @param $name string - Name
     * @return $this
     */
    public function setName($name) { $this->_data->Name = $name; return $this; }

    /**
     * Retrieve the organization code
     * @return string - Code
     */
    public function getCode() { return $this->_data->Code; }
    
    /**
     * Set the organization code
     * @param $code string - Code
     * @return $this
     */
    public function setCode($code) { $this->_data->Code = $code; return $this; }
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return $this->_data; }
    
    public function getOrgUnitTypeID() { return self::OUTYPE; }
    public function getOrgUnitTypeDesc() { return "Organization"; }
}