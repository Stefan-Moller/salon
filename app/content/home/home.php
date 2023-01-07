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

$view->theme = 'salon';
$view->title = 'Welcome';

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'contact' ] = 'Contact Us';



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

$files = array_diff( scandir( $app->photosDir . '' ), array( '.', '..' ) );

$app->f1css = 'css/vendors/f1css/';
$view->addStyle( $app->f1css . 'reset.css'            );
$view->addStyle( $app->f1css . 'layout.css'           );
$view->addStyle( $app->f1css . 'menu.css'             );
$view->addStyle( $app->f1css . 'menu__mobile.css'     );
$view->addStyle( $app->f1css . 'menu__control.css'    );
$view->addStyle( $app->f1css . 'menu__activeitem.css' );
$view->addStyle( $app->f1css . 'submenu.css'          );
$view->addStyle( $app->f1css . 'submenu__control.css' );
$view->addStyle( $app->f1css . 'slides.css'           );

$view->addScript( 'js/vendors/jquery/jquery.min.js' );

$view->addStyle( 'app/themes/salon/styles.css'  );

include $view->getFile();