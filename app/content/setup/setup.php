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

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'logout' ] = 'Logout';

// -----------
// --- GET ---
// -----------


include $view->getFile();