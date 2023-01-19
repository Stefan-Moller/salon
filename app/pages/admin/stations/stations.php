<?php

/**
 * ./app/pages/admin/stations/stations.php
 * 
 * Stations page controller - 09 Jan 2023
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.2.0 - FT - 19 Jan 2023
 * 
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


// --------------
// --- SETUP  ---
// --------------

$view->title = 'Stations';

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

        if ( $do == 'save' ) {
          include $app->modelsDir . '/station.model.php';
          $stationModel = new Models\StationModel( $db, $http, $auth );
          $stationID = $stationModel->save();
          include 'stations.vm.php';
          $stationsViewModel = new Models\StationsViewModel( $db, $http, $auth );
          $response = $stationsViewModel->getStation( $stationID );
          debug_log( 'After save. BookingID = ' . $stationID );
          break;
        }

        if ( $do == 'delete' ) {
          include $app->modelsDir . '/station.model.php';
          $stationID = $http->request->getPostVal( 'id' );
          $stationModel = new Models\StationModel( $db, $http, $auth );
          $stationModel->delete( $stationID );
          $response->ok = "Booking {$stationID} DELETED.";
          $response->id = $stationID;
          break;
        }

      }

      // AJAX GET
      else {

        if ( $do == 'getStation'  ) {
          include 'stations.vm.php';
          $stationsViewModel = new Models\StationsViewModel( $db, $http, $auth, $view );
          $stationID = $http->request->getUrlParam( 'id' );
          $response = $stationsViewModel->getStation( $stationID );
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
$view->addStyle( 'css/vendors/f1css/form.css'          );
$view->addStyle( 'css/vendors/f1css/modal.css'         );
$view->addStyle( 'css/vendors/f1css/select.css'        );
$view->addStyle( 'css/vendors/f1css/switch__slide.css' );
$view->addStyle( 'css/vendors/f1css/list.css'          );
addThemeStyles( $view );


include 'stations.vm.php';
$view->model = new Models\StationsViewModel( $db, $http, $auth, $view );

include $view->getFile();


/*
stdClass Object
(
    [id] => 1
    [no] => 1
    [name] => LAZER
    [def_therapist_id] => 
    [colour] => yellow
    [notes] => 
    [created_at] => 2022-07-21 21:13:12
    [created_by] => 1
    [updated_at] => 
    [updated_by] => 
)
*/