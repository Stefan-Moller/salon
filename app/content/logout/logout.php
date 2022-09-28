<?php

/**
 * ./app/content/home/logout.php
 * 
 * Home page controller - 28 Sep 2022
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - 28 Sep 2022
 * 
 */


$auth->logout();

header( 'Location:login' );

exit;