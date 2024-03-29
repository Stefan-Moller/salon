<?php

/**
 * ./app/pages/admin/staff/staff.php
 * 
 * Staff page controller - 25 Jan 2023
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - INIT -  25 Jan 2023
 * 
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


// --------------
// --- SETUP  ---
// --------------

$view->title = 'Therapists';

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
          include $app->modelsDir . '/staff.model.php';
          $staffModel = new Models\StaffModel( $db, $http, $auth );
          $staffID = $staffModel->save();
          include 'staff.vm.php';
          $staffViewModel = new Models\StaffViewModel( $db, $http, $auth );
          $response = $stationsViewModel->getStaff( $staffID );
          debug_log( 'After save. StaffID = ' . $staffID );
          break;
        }

        if ( $do == 'delete' ) {
          include $app->modelsDir . '/staff.model.php';
          $staffID = $http->request->getPostVal( 'id' );
          $staffModel = new Models\StaffModel( $db, $http, $auth );
          $staffModel->delete( $staffID );
          $response->ok = "Staff {$staffID} DELETED.";
          $response->id = $staffID;
          break;
        }

      }

      // AJAX GET
      else {

        if ( $do == 'getStaff'  ) {
          include 'staff.vm.php';
          $stationsViewModel = new Models\StaffViewModel( $db, $http, $auth, $view );
          $stationID = $http->request->getUrlParam( 'id' );
          $response = $stationsViewModel->getStaff( $staffID );
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


include 'staff.vm.php';
$view->model = new Models\StaffViewModel( $db, $http, $auth, $view );

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