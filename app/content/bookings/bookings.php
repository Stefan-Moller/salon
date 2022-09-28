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

if ( ! $auth->logged_in() ) header( 'Location:login' );

$view->theme = 'salon';
$view->title = 'Bookings';

$view->menu[ 'setup' ] = 'Setup';
$view->menu[ 'logout' ] = 'Logout';

$today = $http->get( 'today', date( 'Y-m-d' ) );


$datetime = strtotime( $today );
$nextday = date( 'Y-m-d', strtotime('+1 day', $datetime) );
$prevday = date( 'Y-m-d', strtotime('-1 day', $datetime) );


$db->connect( $app->dbConnection[ 'salon' ] );



// -------------
// --- POST  ---
// -------------

if ($http->req->isPost) {

  $error = false;
  $goto = $http->req->referer;
  $do = $http->get( '__action__' );

  do {
  
    include $app->modelsDir . '/appointment.model.php';
    $appointment = new AppointmentModel( $db );

    try {

      if ( $do == 'save' ) $appointment->save( $http->req->data );

    } 

    catch ( Exception $e ) {

      $error = $e->getMessage();

    }

  } while(0);


  if ( $error ) {
    $session->flash( 'error', $error );
    debug_log( 'POST Booking Error: ' . $error );
  }

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


include $app->modelsDir . '/calendar.model.php';
$cal = new CalendarModel( $db, $today );


include $view->getFile();