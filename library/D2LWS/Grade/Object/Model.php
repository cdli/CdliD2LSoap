<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

 
/**
 * Grade Object Model
 */
class D2LWS_Grade_Object_Model
{

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
     * Get Grade Object ID
     * @return int Grade Object ID
     */
    public function getID() { return $this->_data->GradeObjectId->Id; }
    
    /**
     * Set Grade Object ID
     * @param int $uid ID
     * @return D2LWS_Grade_Object_Model fluent interface
     */
    public function setID($uid) { $this->_data->GradeObjectId->Id = $uid; return $this; }
    
    /**
     * Get Object Name
     * @return string Name
     */
    public function getName() { return $this->_data->Name; }
    
    /**
     * Set Object Name
     * @param string $name Name
     * @return D2LWS_Grade_Object_Model fluent interface
     */
    public function setName($name) { $this->_data->Name = $name; return $this; }
        
    /**
     * Get Object Type
     * @return string Object type
     */
    public function getType() { return $this->_data->GradeObjectType; }
    
    /**
     * Set Object Type
     * @param string $type Object type
     * @return D2LWS_Grade_Object_Model fluent interface
     */
    public function setType($type) { $this->_data->GradeObjectType = $type; return $this; }

    /**
     * Get Org Unit ID
     * @return int OrgUnitID
     */
    public function getOrgUnitID() { return $this->_data->OrgUnitId->Id; }

    /**
     * Set Object Org Unit ID
     * @param int $ouid OrgUnitID
     * @return D2LWS_Grade_Object_Model fluent interface
     */
    public function setOrgUnitID($ouid) { $this->_data->OrgUnitId->Id = $ouid; return $this; }


    /**
     * Is Category?
     * @return boolean
     */
    public function isCategory()
    {
        return ( $this->getType() == 'Category' );
    }

    /**
     * Is Adjusted Final Grade item?
     * @return boolean
     */
    public function isAdjustedFinalGrade()
    {
        return ( $this->getType() == 'AdjustedFinalGrade' );
    }

    /**
     * Is Calculated Final Grade item?
     * @return boolean
     */
    public function isCalculatedFinalGrade()
    {
        return ( $this->getType() == 'CalculatedFinalGrade' );
    }

    /**
     * Is Calculated grade item?
     * @return boolean
     */
    public function isCalculated()
    {
        return ( $this->getType() == 'Calculated' );
    }

    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return $this->_data; }

}