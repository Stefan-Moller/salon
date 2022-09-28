<?php

/**
 * ./app/content/home/home.php
 * 
 * Home page controller - 23 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - 23 Sep 2022
 * 
 */

$view->theme = 'salon';
$view->title = 'Welcome to Cafe &amp; Salon Allure';

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'contact' ] = 'Contact Us';



// -------------
// --- POST  ---
// -------------

if ($http->req->isPost) {

  $goto = $http->req->referer;
  $do = $http->get('__action__');

  header( 'Location:' . $goto );

}


// -----------
// --- GET ---
// -----------

$files = array_diff(scandir($app->photosDir . ''), array('.', '..'));

$view->useStyleFile ( 'vendors/f1/slides.css'   );
$view->useScriptFile( 'vendors/jquery.min.js'   );
$view->useScriptFile( 'vendors/f1/slideshow.js' );

include $view->getFile();