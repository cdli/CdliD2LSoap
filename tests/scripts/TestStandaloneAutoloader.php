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

!defined("D2LWS_MANUAL_AUTOLOADER") && define("D2LWS_MANUAL_AUTOLOADER", true);
require_once __DIR__ . "/../../library/D2LWS/Instance.php";

try
{
    new D2LWS_Grade_Object_Model();
    echo '<h1>Autoloader Configured Properly</h1>';
}
catch ( Exception $ex )
{
    echo '<h1>Autoloader Not Configured Properly</h1>';
    echo '<pre>';
    var_dump($ex);
    echo '</pre>';
}