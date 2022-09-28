<?php

include $app->vendorsDir . '/f1/session/session.php';

/**
 * app/services/session.php
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * Date: 27 September 2022
 * 
 * Last update: 27 Sep 2022
 * 
 */

use F1\Session;

$session = new Session( '__SALON__' );

$app->session = $session;