<?php

include $app->vendorsDir . '/f1/controller/controller.php';

/**
 * app/services/controller.php
 * 
 * F1 Controller service implementation - 24 Jun 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 2.0.0 - 15 Jan 2023
 *   - Change baseDir from app->contentDir to app->pagesDir
 * 
 */

use F1\Controller;

$app->themeDir = $app->themesDir . DIRECTORY_SEPARATOR . $app->theme; 

$app->controller = new Controller( [
  'controllersBaseDir' => $app->pagesDir,
  'controllerFilePath' => $http->request->path ?: $app->homePage,
  'name' => $http->request->path ? end( $http->request->segments ) : $app->homePage,
  'notFound' => $app->themesDir . '/default/404.html'
] );