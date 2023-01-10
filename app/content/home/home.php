<?php

/**
 * ./app/content/home/home.php
 * 
 * Home page controller - 23 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 3.1.0 - DEV - 29 Dec 2022
 * 
 */


// --------------
// --- SETUP  ---
// --------------

$view->title = 'Welcome';

$menu = $view->menus[ 'main' ];
$menu->addItem( 'Bookings'   , 'bookings' );
$menu->addItem( 'Contact Us' , 'contact'  );



// -------------
// --- POST  ---
// -------------

if ( $http->request->isPost ) {

  $response = new stdClass;

  $response->goto = $http->request->referer;
  
  $do = $http->request->getPostVal( '__action__' );

  do {

    if ( $do == 'something' ) {

      try {

        debug_log( 'I did something :).' );

      }

      catch ( Exception $e ) {

        $response->error = $e->getMessage();

      }

      break;     

    }

    $response->error = 'I do not understand :/';

  } while (0);


  if ( isset( $response->error ) ) $session->flash( 'error', $response->error );

  header( 'Location:' . $response->goto );

}



// -----------
// --- GET ---
// -----------

addCoreStyles( $view );

$view->addStyle( 'css/vendors/f1css/slides.css' );

addThemeStyles( $view );


$view->addScript( 'js/vendors/jquery/jquery.min.js' );


$view->data->files = array_diff( scandir( $app->photosDir . '' ), array( '.', '..' ) );


include $view->getFile();