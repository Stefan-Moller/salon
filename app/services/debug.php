<?php

include $app->vendorsDir . '/f1/debug/debug.php';

/**
 * app/services/debug.php
 *
 * @author C. Moller <xavier.tnc@gmail.com> - 23 June 2022
 *  
 * @version 1.7.0 - 02 July 2022
 * 
 */

use F1\Debug;

if ( __ENV_PROD__ )
{
  $app->debugLevel = __DEBUG_ON__ ? 2 : 1;
}
else
{
  $app->debugLevel = __DEBUG_ON__ ? 3 : 2;
}

$app->debugLogFile = $app->storageDir . DIRECTORY_SEPARATOR . 'logs' .
  DIRECTORY_SEPARATOR . date( Debug::$shortDateFormat ) . '.log';

$debug = new Debug( $app->debugLevel, $app->debugLogFile );


// `onError` handles critical erros.
set_error_handler( [ $debug, 'onError' ] );


// `onShutdown` handles non-critical exceptions.
register_shutdown_function( [ $debug, 'onShutdown' ] );


//------------------------------------------------------------
// Utility functions to allow quick and easy debugging inside
// 3rd party classes or any other isolated scope code blocks.
//------------------------------------------------------------

function debug_log( $str ) { global $debug; $debug->log( $str ); }
function debug_dump( $var, $title = '' ) { global $debug; $debug->dump( $var, $title ); }


$app->debug = $debug;