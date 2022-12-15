<?php

/**
 * ./app/content/bookings/bookings.php
 * 
 * Salon bookings page controller - 08 Jul 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 3.2.0 - DEV - 15 Dec 2022
 *
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


$view->theme = 'salon';
$view->title = 'Bookings';

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'setup' ] = 'Setup';
$view->menu[ 'contact' ] = 'Contact Us';

$date = $http->request->getUrlParam( 'date', date( 'Y-m-d' ) );


$datetime = strtotime( $date );
$nextday = date( 'Y-m-d', strtotime( '+1 day', $datetime ) );
$prevday = date( 'Y-m-d', strtotime( '-1 day', $datetime ) );


$db->connect( $app->dbConnection[ 'salon' ] );



// -------------
// --- AJAX  ---
// -------------

if ( $http->request->isAjax ) {

  $error = false;

  $bookingData = new stdClass;

  $do = $http->request->isPost
    ? $http->request->getPostVal( '__action__' )
    : $http->request->getUrlParam( 'do' );

  debug_log( "\n\n\n*** New AJAX Request ***" );
  debug_log( "Method = {$http->request->method}, Do = {$do}" );
  debug_log( '$_REQUEST = ' . print_r( $_REQUEST, true ) );

  do {

    include $app->modelsDir . '/booking.model.php';
    $bookingModel = new Models\BookingModel( $db, $http, $auth );

    try {

      // AJAX POST
      if ( $http->request->isPost ) { 

        $bookingID = $http->request->getPostVal( 'id' );

        if ( $do == 'saveBooking' ) {
          $bookingID = $bookingModel->save();
          $bookingData = $bookingModel->getById( $bookingID );
          debug_log( 'After save. BookingID = ' . $bookingID );
          break;
        }

        if ( $do == 'deleteBooking' ) {
          $bookingModel->delete( $bookingID );
          $bookingData = "Booking {$bookingID} DELETED.";
          break;
        }

      }

      // AJAX GET
      else {

        if ( $do == 'getBooking'  ) {
          $bookingID = $http->request->getUrlParam( 'id' );
          $bookingData = $bookingModel->getById( $bookingID );
          break;
        }

        if ( $do == 'getBookings' ) {
          $bookingData = $bookingModel->getAll( $date );
          break;

        }

      }

    }

    // AJAX ERROR
    catch ( Exception $e ) { $error = $e->getMessage(); }

  } while ( 0 );


  if ( $error ) {
    $bookingData->error = $error;
    debug_log( "Ajax Request Exception! do = {$do}, message = {$error}", 'EXCPT' );
  }

  exit( $http->response->json( $bookingData ) );

}



// -------------
// --- POST  ---
// -------------

if ( $http->request->isPost ) {

  http_response_code( 400 );
  die( 'Bad Request' );

}



// -----------
// --- GET ---
// -----------

$view->includeStyle( 'css/vendors/f1css/form/form.css'     );
$view->includeStyle( 'css/vendors/f1css/modal/modal.css'   );
$view->includeStyle( 'css/vendors/f1css/select/select.css' );
$view->includeStyle( 'css/vendors/vanilla/vanilla-calendar.min.css' );

$view->includeScript( 'js/vendors/vanilla/vanilla-calendar.min.js' );


include 'dayview.model.php';
$view->model = new Models\DayViewModel( $db, $date );


include $view->getFile();