<?php defined( '__APP_START__' ) or die( 'Invalid Entry Point' );

/**
 * config.php
 * 
 * Application hosting environment, services and instance specific settings.
 * 
 */

// ------------------------  EXAMPLE CONFIG NOTE: ------------------------------
// Copy and rename this file to "config.php". Place it in the application's root 
// folder, one level above the public_html folder. Don't include config.php in
// any version control commits for obvious reasons! Delete this note :).
// -----------------------------------------------------------------------------


define( '__DEBUG_ON__'   , true  );
define( '__ENV_PROD__'   , false );

ini_set( 'log_errors'    , __ENV_PROD__ ? 1 : 0 );
ini_set( 'display_errors', __ENV_PROD__ ? 0 : 1 );

date_default_timezone_set( 'Africa/Johannesburg' );

error_reporting( __ENV_PROD__ ? E_ALL : 0 );

define( '__DS__', DIRECTORY_SEPARATOR );


$app = new stdClass();

$app->rootDir     = __DIR__;
$app->sourceDir   = $app->rootDir   . __DS__ . 'app';
$app->servicesDir = $app->sourceDir . __DS__ . 'services';
$app->vendorsDir  = $app->sourceDir . __DS__ . 'vendors';
$app->storageDir  = $app->sourceDir . __DS__ . 'storage';
$app->contentDir  = $app->sourceDir . __DS__ . 'content';
$app->themesDir   = $app->sourceDir . __DS__ . 'themes';

$app->host    = 'F1Site.localhost';
$app->baseUri = 'public_html';
$app->cssUri  = 'css';
$app->jsUri   = 'js';

$app->theme = 'default';
$app->homePage = 'home'; 

$app->dbConnection = [
  'DBHOST' => 'localhost',
  'DBNAME' => 'f1s',
  'DBUSER' => 'f1s_user',
  'DBPASS' => 'root'
];