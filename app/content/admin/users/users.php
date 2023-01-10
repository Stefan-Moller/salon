<?php

/**
 * ./app/content/admin/users/users.php
 * 
 * Users page controller - 09 Jan 2023
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

$view->theme = 'salon';
$view->title = 'Users';

$view->submenu1 = new MenuItem( 'Admin', 'submenu', 'submenu__wrapper admin-submenu', [
  'admin/staff'    => 'Therapists',
  'admin/services' => 'Treatments',
  'admin/stations' => 'Stations',
  'admin/clients'  => 'Clients'
] );

$view->submenu2 = new MenuItem( 'User', 'submenu', 'submenu__wrapper user-submenu', [
  'profile' => 'Profile',
  'logout'  => 'Logout',
] );

$view->menu[ 'bookings' ] = 'Bookings';
$view->menu[ 'admin'    ] = $view->submenu1;
$view->menu[ 'user'     ] = $view->submenu2;



// -----------
// --- GET ---
// -----------

$app->f1css = 'css/vendors/f1css/';
$view->addStyle( $app->f1css . 'reset.css'            );
$view->addStyle( $app->f1css . 'layout.css'           );
$view->addStyle( $app->f1css . 'menu.css'             );
$view->addStyle( $app->f1css . 'menu__mobile.css'     );
$view->addStyle( $app->f1css . 'menu__control.css'    );
$view->addStyle( $app->f1css . 'menu__activeitem.css' );
$view->addStyle( $app->f1css . 'submenu.css'          );
$view->addStyle( $app->f1css . 'submenu__control.css' );
$view->addStyle( $app->f1css . 'form.css'             );
$view->addStyle( $app->f1css . 'modal.css'            );
$view->addStyle( $app->f1css . 'select.css'           );

$view->addStyle( 'css/vendors/vanilla/calendar.min.css' );
$view->addScript( 'js/vendors/vanilla/calendar.min.js'  );

$view->addStyle( 'app/themes/salon/styles.css' );

include $view->getFile();