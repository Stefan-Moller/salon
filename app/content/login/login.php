<?php

/**
 * ./app/content/home/login.php
 * 
 * Home page controller - 23 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.1 - 24 Sep 2022
 * 
 */

$view->theme = 'salon';
$view->title = 'User Authentication';



// -------------
// --- POST  ---
// -------------

if ( $http->request->isPost ) {

  $error = null;
  $goto = $http->request->referer;
  
  do {

    if ( $http->request->getPostVal( 'submit' ) == 'Login' )
    {

      $username = $http->request->getPostVal( 'username' );
      $password = $http->request->getPostVal( 'password' );

      $db->connect( $app->dbConnection[ 'salon' ] );

      try {

        if ( $auth->login( $username, $password ) ) $goto = 'bookings';
        else $error = 'User or password invalid.';

      }

      catch ( Exception $e ) {

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

$view->includeStyle( 'css/vendors/f1css/form/form.css' );

$view->includeScript( 'js/vendors/f1js/form/form.js' );

include $view->getFile();