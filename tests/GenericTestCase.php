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
 * PHPUnit generic test case
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
abstract class GenericTestCase extends PHPUnit_Framework_TestCase
{

    /**
     * Application configurations from the 'phpunit' group
     * @var array
     */
    public $config;
    
    /**
     * Methods to ignore when comparing two models
     * @var array
     */
    private $_methodsToIgnore = array('getRawData');
    
    
    public function setUp()
    {
        $this->config = require __DIR__ . '/configs/testing.config.php';
        parent::setUp();
    }
    
    /**
     * Create an empty mock object
     */
    protected function _createMockDataObject()
    {
        $mock = $this->_createMockModel();
        return $mock->getRawData();
    }

    /**
     * Assert that two models are the same, except for the return value of one method
     * @param mixed $m1
     * @param mixed $m2
     * @param string|array $diff
     */
    public function _assertModelsSameExcept($m1, $m2, $diff)
    {
        $errorLoc = array();
        $result = true;

        if ( get_class($m1) == get_class($m2) )
        {
            $methods = get_class_methods($m1);
            foreach ( $methods as $method )
            {
                if ( preg_match("/^(get|is)/", $method) && !in_array($method, $this->_methodsToIgnore) )
                {
                    try
                    {
                        $methodPart = preg_replace("/^(get|is)/i", "", $method);
                        $partTest = ( in_array($method, $diff) || in_array($methodPart, $diff) )
                            ? ( $m1->{$method}() != $m2->{$method}() )
                            : ( $m1->{$method}() == $m2->{$method}() );
                        $result &= $partTest;
                        if ( ! $partTest )
                        {
                            $errorLoc[] = $method;
                        }

                    }
                    catch ( Exception $ex )
                    {
                    }
                }
            }
        } 
        else 
        {    
            $this->fail("Supplied model instances are not of the same type");
        }

        $this->assertTrue(($result==true), 'Supplied models differ in following methods: ' . implode(", ", $errorLoc));
    }
    

    /**
     * Return an Instance Manager instance
     * @return D2LWS_Instance Instance Manager
     */
    protected function _getInstanceManager()
    {
        $i = new D2LWS_Instance(array(
            'dirs' => array(
                __DIR__ . '/../configs',
                __DIR__ . '/configs',
            ),
        ));

        if (getenv('SOAP_CLIENT')) {
            $i->getSoapClient()->setClientClassName(
                'D2LWS_Soap_Client_Adapter_' . getenv('SOAP_CLIENT')
            );
        }

        return $i;
    }

    /**
     * Return an instance of the instance manager seeded with a mock SOAP client
     * @return D2LWS_Instance instance
     */
    protected function _getInstanceManagerWithMockSoapClient()
    {
        $i = $this->_getInstanceManager();

        require_once __DIR__ . '/mock/MockSoapClient.php';
        $soapClient = new MockSoapClient();
        $soapClient->setInstance($i);
        $i->setSoapClient($soapClient);
        
        return $i;
    }
}
