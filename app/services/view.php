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


class MenuItem {
  public function __construct( $label, $type = 'item', $class = null, $subitems = null ) {
    $this->label = $label;
    $this->class = $class;
    $this->type = $type;
    $this->subitems = $subitems;
  }
}


$view = new View( [
  'name'      => $app->controller->name,
  'viewDir'   => $app->controller->controllerDir, 
  'themesDir' => $app->themesDir
] );


$view->menu = [
  'home' => new MenuItem( 'Home', 'item', 'home' )
];


$app->view = $view;