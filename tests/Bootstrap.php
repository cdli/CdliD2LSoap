<?php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('APPLICATION_PATH', BASE_PATH . '/application');

// Define application environment
define('APPLICATION_ENV', 'testing');

require_once 'GenericTestCase.php';