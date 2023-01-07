<?php

/**
 * ./app/content/setup/setup.php
 * 
 * Setup page controller - 22 Nov 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - 22 Nov 2022
 * 
 */

$view->theme = 'salon';
$view->title = 'Setup';

$submenu = [
  'clients'    => 'Clients',
  'therapists' => 'Therapists',
  'treatments' => 'Treatments',
  'stations'   => 'Stations',
  'settings'   => 'Settings'
];

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'setup'    ] = [ 'Setup', $submenu ];



// -----------
// --- GET ---
// -----------

$app->f1css = 'css/vendors/f1css/';
$view->addStyle( $app->f1css . 'reset.css'            );
$view->addStyle( $app->f1css . 'layout.css'           );
$view->addStyle( $app->f1css . 'menu.css'             );
$view->addStyle( $app->f1css . 'menu__activeitem.css' );
$view->addStyle( $app->f1css . 'menu__togglectrl.css' );
$view->addStyle( $app->f1css . 'menu__toggleicon.css' );
$view->addStyle( $app->f1css . 'menu__dropdown.css'   );
$view->addStyle( $app->f1css . 'menu__mobile.css'     );

$view->addStyle( 'app/themes/salon/styles.css'  );

include $view->getFile();