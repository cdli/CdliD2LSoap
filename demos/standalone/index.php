<?php
/**
 * CdliD2LSoap - PHP5 Wrapper for Desire2Learn Web Services
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
 * Demo showing how to use zfD2L without Zend_Application
 *
 * How to run demo:  
 *    (1) Ensure Zend Framework is on include path
 *    (2) Create zfD2L configuration file (desire2learn.ini)
 *    (3)
 */

define('D2LWS_DEMO_CONFIG_FILE', 'desire2learn.ini');
define('D2LWS_DEMO_CONFIG_SECTION', 'development');


// Load the D2LWS instance manager
define('D2LWS_MANUAL_AUTOLOADER', true);
require_once __DIR__ . "/../../library/D2LWS/Instance.php";

// Initialize an API instance
try {
    $api = new D2LWS_Instance(D2LWS_DEMO_CONFIG_FILE,D2LWS_DEMO_CONFIG_SECTION);
} catch ( Exception $ex ) {
    die("ERROR: " . $ex->getMessage());
}


if ( isset($_POST['username']) )
{
    
    $username = $_POST['username'];
    
    try 
    {
        $svcUser = new D2LWS_User_API($api);
        $user = $svcUser->findByUserName($username);
        
        if ( $user instanceof D2LWS_User_Model )
        {
            $enrollments = $svcUser->getActiveCourseOfferings($user->getUserID());            
            require_once __DIR__ . "/views/enrollments.php";            
        }
    }
    catch ( Exception $ex )
    {
        die("ERROR: " . $ex->getMessage());
    }    
    
}
else
{
    require_once __DIR__ . "/views/form.php";
}
