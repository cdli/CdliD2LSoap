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
 * PHPUnit base test class for live-server tests
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
abstract class LiveTestCase extends GenericTestCase
{

    /**
     * Retrieve Instance of Test Course Offering
     * @return D2LWS_OrgUnit_CourseOffering_Model 
     */
    protected function getTestCourseOffering()
    {
        $svc = new D2LWS_OrgUnit_CourseOffering_API($this->_getInstanceManager());
        return $svc->findByID($this->config->phpunit->live->course_offering->ouid);
    }
 
    /**
     * Retrieve Instance of Empty Test Course Offering
     * @return D2LWS_OrgUnit_CourseOffering_Model 
     */
    protected function getTestEmptyCourseOffering()
    {
        $svc = new D2LWS_OrgUnit_CourseOffering_API($this->_getInstanceManager());
        return $svc->findByID($this->config->phpunit->live->empty_course_offering->ouid);        
    }
    
    /**
     * Retrieve Instance of Test Student Account
     * @return D2LWS_User
     */
    protected function getTestStudentAccount()
    {
        $svc = new D2LWS_User_API($this->_getInstanceManager());
        return $svc->findByID($this->config->phpunit->live->student->ouid);        
    }
    
    /**
     * Retrieve Instance of Test Group Type
     * @return D2LWS_OrgUnit_Group_Type_Model 
     */
    protected function getTestGroupType()
    {
        $svc = new D2LWS_OrgUnit_Group_Type_API($this->_getInstanceManager());
        return $svc->findByID(
            $this->config->phpunit->live->group_type->ouid,
            $this->config->phpunit->live->course_offering->ouid
        );
    }
    
}