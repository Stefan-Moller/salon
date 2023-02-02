<?php

/**
 * ./app/pages/admin/stations/stations.php
 * 
 * Services page controller - 25 Jan 2023
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - FT - 25 Jan 2023
 * 
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


// --------------
// --- SETUP  ---
// --------------

$view->title = 'Services';

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
          include $app->modelsDir . '/services.model.php';
          $serviceModel = new Models\ServiceModel( $db, $http, $auth );
          $serviceID = $serviceModel->save();
          include 'services.vm.php';
          $servicesViewModel = new Models\ServicesViewModel( $db, $http, $auth );
          $response = $servicesViewModel->getService( $serviceID );
          debug_log( 'After save. ServiceID = ' . $serviceID );
          break;
        }

        if ( $do == 'delete' ) {
          include $app->modelsDir . '/services.model.php';
          $serviceID = $http->request->getPostVal( 'id' );
          $serviceModel = new Models\ServiceModel( $db, $http, $auth );
          $serviceModel->delete( $serviceID );
          $response->ok = "Service {$serviceID} DELETED.";
          $response->id = $serviceID;
          break;
        }

      }

      // AJAX GET
      else {

        if ( $do == 'getService'  ) {
          include 'services.vm.php';
          $servicesViewModel = new Models\ServicesViewModel( $db, $http, $auth, $view );
          $serviceID = $http->request->getUrlParam( 'id' );
          $response = $servicesViewModel->getService( $serviceID );
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

//die("end of world");

include 'services.vm.php';
$view->model = new Models\ServicesViewModel( $db, $http, $auth, $view );

include $view->getFile();
