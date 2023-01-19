<?php define( '__APP_START__', microtime( true ) );

$mem_usage = memory_get_usage();
$mem_kb = round( $mem_usage / 1024 ) . 'KB';


/***********************************
 * ==    F1 Micro Framework       ==
 * ==     Front Controller        ==
 * ==   C. Moller - 19 Mar 2022   ==
 * ==  Last Update - 19 Jan 2023  ==
 ***********************************/

// -----------------------------------------------------------------------
// Fetch application environment, services and instance specific settings.
// -----------------------------------------------------------------------

require 'config.php';


// -----------------------------------------------------------------------
// Load and configure application core services.
// Each service gets it's own file to keep things tidy and easy to follow.
// PS: Vendor libs are loaded (if required) in the respective service files.
// **NB**: The order of includes is VERY important!
// -----------------------------------------------------------------------

include $app->servicesDir . '/debug.php';
include $app->servicesDir . '/http.php';
include $app->servicesDir . '/session.php';
include $app->servicesDir . '/database.php';
include $app->servicesDir . '/controller.php';
include $app->servicesDir . '/auth.php';
include $app->servicesDir . '/menu.php';
include $app->servicesDir . '/view.php';


$app->version = '9.1';

// $debug->dump( $app );
$debug->log( "Mem: {$mem_kb}, Time: 0ms", 'START' );

include $app->controller->getFile();
