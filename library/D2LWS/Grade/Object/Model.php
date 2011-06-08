<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/adamlundrigan/zfD2L/blob/master/LICENSE
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
 * Grade Object Model
 */
class D2LWS_Grade_Object_Model extends D2LWS_Abstract_Model
{

    /**
     * Initialize Default Data Structure
     */
    public function init()
    {
        $this->_data = new stdClass();
        
        $this->_data->GradeObjectId = new stdClass();
        $this->_data->GradeObjectId->Id = NULL;
        $this->_data->GradeObjectId->Source = 'Desire2Learn';
        
        $this->_data->OrgUnitId = new stdClass();
        $this->_data->OrgUnitId->Id = NULL;
        $this->_data->OrgUnitId->Source = 'Desire2Learn';
        
        $this->_data->Name = '';
        $this->_data->GradeObjectType = '';
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
     * Is Numeric?
     * @return boolean
     */
    public function isNumeric()
    {
        return ( $this->getType() == 'Numeric' );
    }
    
    /**
     * Is Pass/Fail?
     * @return boolean
     */
    public function isPassFail()
    {
        return ( $this->getType() == 'PassFail' );
    }
    
    /**
     * Is Select Box?
     * @return boolean
     */
    public function isSelectBox()
    {
        return ( $this->getType() == 'SelectBox' );
    }
    
    /**
     * Is Text?
     * @return boolean
     */
    public function isText()
    {
        return ( $this->getType() == 'Text' );
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
     * Is Formula?
     * @return boolean
     */
    public function isFormula()
    {
        return ( $this->getType() == 'Formula' );
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
     * Is Adjusted Final Grade item?
     * @return boolean
     */
    public function isAdjustedFinalGrade()
    {
        return ( $this->getType() == 'AdjustedFinalGrade' );
    }

    /**
     * Is Category?
     * @return boolean
     */
    public function isCategory()
    {
        return ( $this->getType() == 'Category' );
    }
    
    /**
     * Return raw data object
     * @return stdClass - Raw data object
     */
    public function getRawData() { return $this->_data; }

}