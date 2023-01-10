<?php

/**
 * ./app/content/user/profile/profile.php
 * 
 * Users page controller - 10 Jan 2023
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - INIT - 10 Jan 2023
 * 
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


// --------------
// --- SETUP  ---
// --------------

$view->title = 'User Profile';

$view->menus[ 'main' ]->addBackendItems();



// -----------
// --- GET ---
// -----------

addCoreStyles( $view );
addThemeStyles( $view );


include $view->getFile();