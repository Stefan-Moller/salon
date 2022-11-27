<?php

/**
 * ./app/content/bookings/bookings.php
 * 
 * Salon bookings page controller - 08 Jul 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 2.5.0 - DEV - 27 Nov 2022
 *
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );

$view->theme = 'salon';
$view->title = 'Bookings';

$view->menu[ 'setup' ] = 'Setup';
$view->menu[ 'logout' ] = 'Logout';

$date = $http->getUrlParam( 'date', date( 'Y-m-d' ) );


$datetime = strtotime( $date );
$nextday = date( 'Y-m-d', strtotime('+1 day', $datetime) );
$prevday = date( 'Y-m-d', strtotime('-1 day', $datetime) );


$db->connect( $app->dbConnection[ 'salon' ] );



// -------------
// --- AJAX  ---
// -------------

if ( $http->req->isAjax ) {

  $error = false;
  $bookingData = new stdClass;
  $do = $http->req->isPost ? $http->getPostVal( '__action__' ) : $http->getUrlParam( 'do' );

  debug_log( "\n\n\n*** New AJAX Request ***" );
  debug_log( "Method = {$http->req->method}, Do = {$do}" );
  debug_log( '$_REQUEST = ' . print_r( $_REQUEST, true ) );

  do {

    include $app->modelsDir . '/booking.model.php';
    $bookingModel = new BookingModel( $db, $http, $auth );

    try {

      if ( $http->req->isPost ) {

        $bookingID = $http->getPostVal( 'id' );

        if ( $do == 'deleteBooking' ) {
          $bookingModel->delete( $bookingID );
          $bookingData = "Booking {$bookingID} DELETED.";
          break;
        }

        if ( $do == 'saveBooking' ) {
          $bookingID = $bookingModel->save();
          debug_log( 'After save. BookingID = ' . $bookingID );
          $bookingData = $bookingModel->getById( $bookingID );
          break;
        }

      }

      if ( $do == 'getBookings' ) { $bookingData = $bookingModel->getAll( $date ); break; }
      if ( $do == 'getBooking'  ) { $bookingData = $bookingModel->getById( $http->getUrlParam( 'id' ) ); break; }

    }

    catch ( Exception $e ) { $error = $e->getMessage(); }

  } while ( 0 );


  if ( $error ) {
    $bookingData->error = $error;
    debug_log( "Ajax Request Exception! do = {$do}, message = {$error}" );
  }

  exit( $view->makeJsonResponse( $bookingData ) );

}



// -------------
// --- POST  ---
// -------------

if ( $http->req->isPost ) {

  http_response_code( 400 );
  die( 'Bad Request' );

}



// -----------
// --- GET ---
// -----------

$view->useStyleFile( 'vendors/f1css/form/form.css'     );
$view->useStyleFile( 'vendors/f1css/modal/modal.css'   );
$view->useStyleFile( 'vendors/f1css/select/select.css' );
$view->useStyleFile( 'vendors/vanilla/vanilla-calendar.min.css' );


$view->useScriptFile( 'vendors/vanilla/vanilla-calendar.min.js' );


include $app->modelsDir . '/calendar.model.php';
$cal = new CalendarModel( $db, $date );


include $view->getFile();