<?php

/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 *
 * $Id: Model.php 5 2011-01-25 16:49:24Z adamlundrigan $
 *
 */

 
/**
 * Grade Value Model
 */
class D2LWS_Grade_Value_Model
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
     * Get Org Unit ID
     * @return int OrgUnitID
     */
    public function getOrgUnitID() { return $this->_data->OrgUnitId->Id; }

    /**
     * Set Value Org Unit ID
     * @param int $ouid OrgUnitID
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setOrgUnitID($ouid) { $this->_data->OrgUnitId->Id = $ouid; return $this; }

    /**
     * Get Student ID
     * @return int Student ID
     */
    public function getStudentID() { return $this->_data->UserId->Id; }

    /**
     * Set Student ID
     * @param int $sid Student ID
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setStudentID($sid) { $this->_data->UserId->Id = $sid; return $this; }

    /**
     * Get Grade Object ID
     * @return int Grade Object ID
     */
    public function getGradeObjectID() { return $this->_data->GradeObjectId->Id; }

    /**
     * Set Grade Object ID
     * @param int $oid Grade Object ID
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setGradeObjectID($oid) { $this->_data->GradeObjectId->Id = $oid; return $this; }

    /**
     * Get Points Numerator
     * @return float Numerator
     */
    public function getPointsNumerator() { return $this->_data->PointsNumerator; }

    /**
     * Set Points Numerator
     * @param float $num Numerator
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setPointsNumerator($num) { $this->_data->PointsNumerator = $num; return $this; }

    /**
     * Get Points Denominator
     * @return float Denominator
     */
    public function getPointsDenominator() { return $this->_data->PointsDenominator; }

    /**
     * Set Points Denominator
     * @param float $num Denominator
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setPointsDenominator($num) { $this->_data->PointsDenominator = $num; return $this; }

    /**
     * Get Weighted Numerator
     * @return float Numerator
     */
    public function getWeightedNumerator() { return $this->_data->WeightedNumerator; }

    /**
     * Set Weighted Numerator
     * @param float $num Numerator
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setWeightedNumerator($num) { $this->_data->WeightedNumerator = $num; return $this; }

    /**
     * Get Weighted Denominator
     * @return float Denominator
     */
    public function getWeightedDenominator() { return $this->_data->WeightedDenominator; }

    /**
     * Set Weighted Denominator
     * @param float $num Denominator
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setWeightedDenominator($num) { $this->_data->WeightedDenominator = $num; return $this; }

    /**
     * Get Grade Text
     * @return string Grade Text
     */
    public function getGradeText() { return $this->_data->GradeText; }

    /**
     * Set Grade Text
     * @param string $gt Grade Text
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setGradeText($gt) { $this->_data->GradeText = $gt; return $this; }

    /**
     * Get Status Value
     * @return string Status
     */
    public function getStatus() { return $this->_data->Status; }

    /**
     * Set Status Value
     * @param string $status Status
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setStatus($status) { $this->_data->GradeStatus = $status; return $this; }

    /**
     * Is grade entry valid?
     * @return boolean
     */
    public function isOK() { return $this->getStatus() == 'OK'; }

    /**
     * Get Dropped Flag
     * @return boolean
     */
    public function isDropped() { return $this->_data->IsDropped; }

    /**
     * Set Dropped Flag
     * @param boolean $flag Dropped Flag
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setIsDropped($flag) { $this->_data->IsDropped = $flag; return $this; }

    /**
     * Get Released Flag
     * @return boolean
     */
    public function isReleased() { return $this->_data->IsReleased; }

    /**
     * Set Released Flag
     * @param boolean $flag Released Flag
     * @return D2LWS_Grade_Value_Model fluent interface
     */
    public function setIsReleased($flag) { $this->_data->IsReleased = $flag; return $this; }
}