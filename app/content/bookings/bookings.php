<?php

/**
 * ./app/content/salon/salon.php
 * 
 * Salon page controller - 08 Jul 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 2.0.0 - 17 Nov 2022
 *   - Update JS & CSS include paths to new locations.
 *   - Total re-write of the calendar grid rendering system.
 *   - Fix most of what broke since re-factoring JS scripts.
 * 
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );

$view->theme = 'salon';
$view->title = 'Bookings';

$view->menu[ 'setup' ] = 'Setup';
$view->menu[ 'logout' ] = 'Logout';

$date = $http->get( 'date', date( 'Y-m-d' ) );


$datetime = strtotime( $date );
$nextday = date( 'Y-m-d', strtotime('+1 day', $datetime) );
$prevday = date( 'Y-m-d', strtotime('-1 day', $datetime) );


$db->connect( $app->dbConnection[ 'salon' ] );



// -------------
// --- AJAX  ---
// -------------

if ( $http->req->isAjax ) {

  $aptData = null;
  $do = $http->get( 'do' );

  do {

    if ( $do == 'getBookings' ) {

      include $app->modelsDir . '/booking.model.php';

      $bookingModel = new BookingModel( $db );
      $aptData = $bookingModel->getAll( $date );

      break;
    }

    if ( $do == 'getBooking' ) {

      include $app->modelsDir . '/booking.model.php';

      $bookingModel = new BookingModel( $db );
      $aptData = $bookingModel->getById( $http->get( 'id' ) );

      break;
    }

  } while ( 0 );

  exit( $view->makeJsonResponse( $aptData ) );

}



// -------------
// --- POST  ---
// -------------

if ( $http->req->isPost ) {

  $error = false;
  $goto = $http->req->referer;
  $do = $http->get( '__action__' );

  do {
  
    include $app->modelsDir . '/booking.model.php';
    $bookingModel = new BookingModel( $db );

    try {

      if ( $do == 'save' ) $bookingModel->save( $http->req->data );

    } 

    catch ( Exception $e ) {

      $error = $e->getMessage();

    }

  } while ( 0 );


  if ( $error ) {
    $session->flash( 'error', $error );
    debug_log( 'POST Booking Error: ' . $error );
  }

  header( 'Location:' . $goto );

}



// -----------
// --- GET ---
// -----------


$view->useStyleFile( 'vendors/f1css/form/form.css'     );
$view->useStyleFile( 'vendors/f1css/modal/modal.css'   );
$view->useStyleFile( 'vendors/f1css/select/select.css' );
$view->useStyleFile( 'vendors/vanilla/vanilla-calendar.min.css' );

$view->useScriptFile( 'vendors/f1js/date/date.js'     );
$view->useScriptFile( 'vendors/f1js/form/form.js'     );
$view->useScriptFile( 'vendors/f1js/fetch/fetch.js'   );
$view->useScriptFile( 'vendors/f1js/modal/modal.js'   );
$view->useScriptFile( 'vendors/f1js/select/select.js' );
$view->useScriptFile( 'vendors/f1js/form/form-validators.js'    );
$view->useScriptFile( 'vendors/vanilla/vanilla-calendar.min.js' );
$view->useScriptFile( 'vendors/f1js/form/form-fieldtypes.js'    );


include $app->modelsDir . '/calendar.model.php';
$cal = new CalendarModel( $db, $date );


include $view->getFile();