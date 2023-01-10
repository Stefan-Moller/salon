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


function addCoreStyles( $view )
{
  $baseUri = 'css/vendors/f1css/';
  $view->addStyle( 'reset.css'            , $baseUri );
  $view->addStyle( 'layout.css'           , $baseUri );
  $view->addStyle( 'menu.css'             , $baseUri );
  $view->addStyle( 'menu__mobile.css'     , $baseUri );
  $view->addStyle( 'menu__control.css'    , $baseUri );
  $view->addStyle( 'menu__activeitem.css' , $baseUri );
  $view->addStyle( 'submenu.css'          , $baseUri );
  $view->addStyle( 'submenu__control.css' , $baseUri );
}


function addThemeStyles( $view )
{
  $view->addStyle( 'app/themes/' . $view->theme . '/styles.css' );
}


$view = new View( [
  'name'      => $app->controller->name,
  'menus'     => [ 'main' => new Menu( [ new MenuItem( 'Home', 'home', 'home' ) ] ) ],
  'viewDir'   => $app->controller->controllerDir, 
  'themesDir' => $app->themesDir,
  'theme'     => $app->theme
] );


$app->view = $view;