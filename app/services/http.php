<?php

include $app->vendorsDir . '/f1/http/http.php';

/**
 * app/services/http.php
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * Date: 24 June 2022
 * 
 * Last update: 01 July 2022
 * 
 */

use F1\HTTP;

$http = new HTTP( $app->baseUri );

$app->http = $http;
