<?php

/**
 * ./app/content/salon/salon.php
 * 
 * Salon page controller - 08 Jul 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 2.0.0 - 14 Jul 2022
 * 
 */

$app->menu = [
  'salon' => 'Home',
];


$view->theme = 'salon';
$view->title = 'Salon Allure Demo';


$today = $http->get( 'today', date( 'Y-m-d' ) );


$datetime = strtotime( $today );
$nextday = date( 'Y-m-d', strtotime('+1 day', $datetime) );
$prevday = date( 'Y-m-d', strtotime('-1 day', $datetime) );


$db->connect( $app->dbConnection[ 'salon' ] );


include __DIR__ . '/salon.model.php';
$cal = new Model( $db );


// -------------
// --- POST  ---
// -------------

if ($http->req->isPost) {

  $goto = $http->req->referer;
  $do = $http->get('__action__');

  header( 'Location:' . $goto );

}


// -----------
// --- GET ---
// -----------

$view->useScriptFile( 'vendors/vanilla-calendar.min.js' );
$view->useStyleFile( 'vendors/vanilla-calendar.min.css' );

$view->useStyleFile( 'form.css' );
$view->useStyleFile( 'modal.css' );
$view->useStyleFile( 'select.css' );

$view->useScriptFile( 'form.js' );
$view->useScriptFile( 'date.js' );
$view->useScriptFile( 'modal.js' );
$view->useScriptFile( 'select.js' );
$view->useScriptFile( 'form-fieldtypes.js' );
$view->useScriptFile( 'form-validators.js' );


include $view->getFile();