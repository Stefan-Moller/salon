<?php

include $app->vendorsDir . '/f1/view/view.php';

/**
 * app/services/view.php
 * 
 * F1 View service implementation - 01 Jul 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.7.0 - 28 Sep 2022
 * 
 */

use F1\View;


$view = new View( [
  'name'      => $app->controller->name,
  'viewDir'   => $app->controller->controllerDir, 
  'themesDir' => $app->themesDir
] );


$view->menu = $auth->logged_in()

  ? [
      'setup'  => 'Setup',
      'logout' => 'Logout'
    ]

  : [
      'home'     => 'Home',
      'bookings' => 'Bookings',
      'contact'  => 'Contact Us',
    ];


$app->view = $view;