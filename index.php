<?php define( '__APP_START__', microtime( true ) );

/***********************************
 * ==    F1 Micro Framework       ==
 * ==     Front Controller        ==
 * ==   C. Moller - 19 Mar 2022   ==
 * ==  Last Update - 28 Sep 2022  ==
 ***********************************/

// -----------------------------------------------------------------------
// Fetch application environment, services and instance specific settings.
// -----------------------------------------------------------------------

require 'config.php';


// -----------------------------------------------------------------------
// Load and configure application core services.
// Each service gets it's own file to keep things tidy and easy to follow.
// PS: Vendor libs are loaded (if required) in the respective service files.
// NB: The order of includes is VERY important!
// -----------------------------------------------------------------------

include $app->servicesDir . '/debug.php';
include $app->servicesDir . '/http.php';
include $app->servicesDir . '/session.php';
include $app->servicesDir . '/database.php';
include $app->servicesDir . '/controller.php';
include $app->servicesDir . '/auth.php';
include $app->servicesDir . '/view.php';


// $debug->dump( $app );

include $app->controller->getFile();