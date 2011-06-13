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
 * @see Zend_Application
 */
require_once 'Zend/Application.php';

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

    public function setUp()
    {
        $this->config = new Zend_Config_Ini(
            APPLICATION_CFG,
            APPLICATION_ENV
        );
        parent::setUp();
    }

    /**
     * Assert that two models are the same, except for the return value of one method
     * @param mixed $obj1
     * @param mixed $obj2
     * @param string|array $methods
     */
    protected function _assertModelsSameExcept($obj1, $obj2, $methods)
    {
        if ( isset($this->_methodsToTest) )
        {
            if ( is_array($this->_methodsToTest) && count($this->_methodsToTest) > 0 )
            {
                foreach ( (array)$methods as $method )
                {
                    if ( isset($this->_methodsToTest[$method]) )
                    {
                        foreach ( $this->_methodsToTest as $mkey=>$mnames )
                        {
                            if ( $mkey == $method )
                            {
                                $this->assertNotEquals($obj1->{$mnames['get']}(), $obj2->{$mnames['get']}());
                            }
                            elseif ( !in_array($mkey, (array)$methods) )
                            {
                                $this->assertEquals($obj1->{$mnames['get']}(), $obj2->{$mnames['get']}());
                            }
                        }
                    }                
                }
            }
        }
    }

    /**
     * Return an Instance Manager instance
     * @return D2LWS_Instance Instance Manager
     */
    protected function _getInstanceManager()
    {
        return new D2LWS_Instance(APPLICATION_PATH . "/configs/desire2learn.ini");
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