<?php

/**
 * ./app/pages/bookings/bookings.php
 * 
 * Salon bookings page controller - 08 Jul 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 9.0.0 - FT - 18 Jan 2023
 *
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


// --------------
// --- STATE  ---
// --------------

$view->data->date = $http->request->getUrlParam( 'date', date( 'Y-m-d' ) );



// --------------
// --- SETUP  ---
// --------------

$view->title = 'Bookings';

$view->menus[ 'main' ]->addBackendItems();


$db->connect( $app->dbConnection[ 'salon' ] );



// -------------
// --- AJAX  ---
// -------------

if ( $http->request->isAjax ) {

  $response = new stdClass;

  $do = $http->request->isPost
    ? $http->request->getPostVal( '__action__' )
    : $http->request->getUrlParam( 'do' );

  debug_log( "\n\n\n*** New AJAX Request ***" );
  debug_log( "Method = {$http->request->method}, Do = {$do}" );
  debug_log( '$_REQUEST = ' . print_r( $_REQUEST, true ) );

  do {

    try {

      // AJAX POST
      if ( $http->request->isPost ) { 

        if ( $do == 'saveBooking' ) {
          include $app->modelsDir . '/booking.model.php';
          $bookingModel = new Models\BookingModel( $db, $http, $auth );
          $bookingID = $bookingModel->save();
          $response = $bookingModel->getById( $bookingID );
          debug_log( 'After save. BookingID = ' . $bookingID );
          break;
        }

        if ( $do == 'deleteBooking' ) {
          include $app->modelsDir . '/booking.model.php';
          $bookingID = $http->request->getPostVal( 'id' );
          $bookingModel = new Models\BookingModel( $db, $http, $auth );
          $bookingModel->delete( $bookingID );
          $response = "Booking {$bookingID} DELETED.";
          break;
        }

        if ( $do == 'saveClient' ) {
          include $app->modelsDir . '/client.model.php';
          $clientModel = new Models\ClientModel( $db, $http, $auth );
          $clientID = $clientModel->save();
          $response = $clientModel->getById( $clientID );
          debug_log( 'After save. ClientID = ' . $clientID );
          break;
        }        

        if ( $do == 'deleteClient' ) {
          include $app->modelsDir . '/client.model.php';
          $clientID = $http->request->getPostVal( 'id' );
          $clientModel = new Models\ClientModel( $db, $http, $auth );
          $clientModel->delete( $clientID );
          $response = "Client {$clientID} DELETED.";
          break;
        }
      }

      // AJAX GET
      else {

        if ( $do == 'getBooking'  ) {
          include $app->modelsDir . '/booking.model.php';
          $bookingModel = new Models\BookingModel( $db, $http, $auth );
          $bookingID = $http->request->getUrlParam( 'id' );
          $response = $bookingModel->getById( $bookingID );
          break;
        }

        if ( $do == 'getBookings' ) {
          include $app->modelsDir . '/booking.model.php';
          $bookingModel = new Models\BookingModel( $db, $http, $auth );
          $response = $bookingModel->getAll( $view->data->date );
          break;

        }

        if ( $do == 'getClient'  ) {
          include $app->modelsDir . '/client.model.php';
          $clientModel = new Models\ClientModel( $db, $http, $auth );
          $clientID = $http->request->getUrlParam( 'id' );
          $response = $clientModel->getById( $clientID );
          break;
        }
      }

    }

    // AJAX ERROR
    catch ( Exception $e ) { $response->error = $e->getMessage(); }

  } while ( 0 );


  if ( isset( $response->error ) ) {
    debug_log( "Ajax Request Exception! do = {$do}, message = {$response->error}", 'EXCPT' );
  }

  exit( $http->response->json( $response ) );

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

addCoreStyles( $view );

$view->addStyle( 'css/vendors/f1css/form.css'   );
$view->addStyle( 'css/vendors/f1css/modal.css'  );
$view->addStyle( 'css/vendors/f1css/select.css' );

$view->addStyle( 'css/vendors/vanilla/calendar.min.css' );
$view->addScript( 'js/vendors/vanilla/calendar.min.js' );

addThemeStyles( $view );


include 'bookings.vm.php';
$view->model = new Models\DayViewModel( $db, $view );


include $view->getFile();