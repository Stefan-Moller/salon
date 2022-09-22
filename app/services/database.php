<?php

include $app->vendorsDir . '/f1/database/database.php';

/**
 * app/services/database.php
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * Date: 23 June 2022
 * 
 * Last update: 01 July 2022
 * 
 */

use F1\DB;

$db = new DB();

$app->db = $db;