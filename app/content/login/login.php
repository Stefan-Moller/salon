<?php

/**
 * ./app/content/home/login.php
 * 
 * Home page controller - 23 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - 24 Sep 2022
 * 
 */

$view->theme = 'salon';
$view->title = 'User Authentication';



// -------------
// --- POST  ---
// -------------

if ( $http->req->isPost ) {

  $error = null;
  $goto = $http->req->referer;
  
  do {

    if ( $http->getPostVal( 'submit' ) == 'Login' )
    {

      $username = $http->getPostVal( 'username' );
      $password = $http->getPostVal( 'password' );

      $db->connect( $app->dbConnection[ 'salon' ] );

      try {

        if ( $auth->login( $username, $password ) ) $goto = 'bookings';
        else $error = 'User or password invalid.';

      }

      catch (Exception $e) {

        $error = $e->getMessage();

      }

      break;

    }

    $error = 'You said what? I no understand :/';

  } while(0);


  if ( $error ) $session->flash( 'error', $error );

  header( 'Location:' . $goto );

}



// -----------
// --- GET ---
// -----------

$view->useStyleFile( 'vendors/f1css/form/form.css' );

$view->useScriptFile( 'vendors/f1js/form/form.js' );
// $view->useScriptFile( 'vendors/f1js/form/form-validatortypes.js' );
// $view->useScriptFile( 'vendors/f1js/form/form-fieldtypes.js' );

include $view->getFile();