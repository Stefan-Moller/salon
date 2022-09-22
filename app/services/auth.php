<?php

include $app->vendorsDir . '/f1/auth/auth.php';

/**
 * app/services/auth.php
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * Date: 24 June 2022
 * 
 * Last update: 01 July 2022
 * 
 */

use F1\Auth;

$auth = new Auth();

$app->auth = $auth;