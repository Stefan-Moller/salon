<?php

/**
 * ./app/content/admin/services/services.php
 * 
 * Services page controller - 09 Jan 2023
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - INIT - 09 Jan 2023
 * 
 */

if ( ! $auth->logged_in() ) header( 'Location:login' );


// --------------
// --- SETUP  ---
// --------------

$view->title = 'Treatments';

$view->menus[ 'main' ]->addBackendItems();



// -----------
// --- GET ---
// -----------

addCoreStyles( $view );
addThemeStyles( $view );


include $view->getFile();