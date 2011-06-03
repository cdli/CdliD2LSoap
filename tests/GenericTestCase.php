<?php
/**
 * Desire2Learn Web Serivces for Zend Framework
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 * @author Thomas Hawkins <thawkins@mun.ca>
 */

require_once 'Zend/Application.php';

/**
 * PHPUnit generic test case
 * @author Adam Lundrigan <adamlundrigan@cdli.ca>
 */
abstract class GenericTestCase extends PHPUnit_Framework_TestCase
{
    public $application;

    public function setUp()
    {

        $this->application = new Zend_Application(
            APPLICATION_ENV,
            realpath(APPLICATION_PATH . '/configs/application.ini')
        );

        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap()
    {
        $this->application->bootstrap();
    }

    /**
     * Assert that two models are the same, except for the return value of one method
     * @param mixed $obj1
     * @param mixed $obj2
     * @param string $method
     */
    protected function _assertModelsSameExcept($obj1, $obj2, $method)
    {
        if ( isset($this->_methodsToTest) )
        {
            if ( is_array($this->_methodsToTest) && count($this->_methodsToTest) > 0 )
            {
                if ( isset($this->_methodsToTest[$method]) )
                {
                    foreach ( $this->_methodsToTest as $mkey=>$mnames )
                    {
                        if ( $mkey == $method )
                        {
                            $this->assertNotEquals($obj1->{$mnames['get']}(), $obj2->{$mnames['get']}());
                        }
                        else
                        {
                            $this->assertEquals($obj1->{$mnames['get']}(), $obj2->{$mnames['get']}());
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