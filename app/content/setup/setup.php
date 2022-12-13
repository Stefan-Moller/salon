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
$view->menu[ 'Setup'  ]  = $submenu;
$view->menu[ 'logout' ] = 'Logout';

// -----------
// --- GET ---
// -----------


include $view->getFile();