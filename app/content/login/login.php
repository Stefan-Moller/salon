<?php

/**
 * ./app/content/login/login.php
 * 
 * Home page controller - 23 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 4.1.1 - FIX - 03 Jan 2023
 * 
 */

$view->theme = 'salon';
$view->title = 'User Authentication';



// -------------
// --- POST  ---
// -------------

if ( $http->request->isPost ) {

  $response = new stdClass;

  $response->goto = $http->request->referer;
  
  do {

    if ( $http->request->getPostVal( 'submit' ) == 'Login' )
    {

      $username = $http->request->getPostVal( 'username' );
      $password = $http->request->getPostVal( 'password' );

      $db->connect( $app->dbConnection[ 'salon' ] );

      try {

        if ( $auth->login( $username, $password ) ) $response->goto = 'bookings';
        else $response->error = 'User or password invalid.';

      }

      catch ( Exception $e ) {

        $response->error = $e->getMessage();

      }

      break;

    }

    $response->error = 'You said what? I no understand :/';

  } while(0);


  if ( isset( $response->error ) ) $session->flash( 'error', $response->error );

  header( 'Location:' . $response->goto );

}



// -----------
// --- GET ---
// -----------

$view->addStyle( 'css/vendors/f1css/reset.css'  );
$view->addStyle( 'css/vendors/f1css/layout.css' );
$view->addStyle( 'css/vendors/f1css/menu.css'   );
$view->addStyle( 'css/vendors/f1css/form.css' );
$view->addStyle( 'app/themes/salon/styles.css'  );

include $view->getFile();