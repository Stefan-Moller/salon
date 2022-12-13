<?php

/**
 * ./app/content/home/home.php
 * 
 * Home page controller - 23 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 3.0.0 - DEV - 13 Dec 2022
 * 
 */

$view->theme = 'salon';
$view->title = 'Welcome to ' . $app->title;

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'setup' ] = 'Setup';
$view->menu[ 'contact' ] = 'Contact Us';



// -------------
// --- POST  ---
// -------------

if ( $http->request->isPost ) {

  $goto = $http->request->referer;
  $do = $http->request->getPostVal( '__action__' );

  header( 'Location:' . $goto );

}


// -----------
// --- GET ---
// -----------

$files = array_diff( scandir( $app->photosDir . '' ), array( '.', '..' ) );

$view->includeStyle( 'css/vendors/f1css/slides/slides.css' );

$view->includeScript( 'js/vendors/jquery/jquery.min.js' );

include $view->getFile();