<?php

/**
 * app/services/auth.php
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * Date: 28 Sep 2022
 * 
 * Last update: 28 September 2022
 * 
 */

class Auth {

  public $app;
  public $user;

  const USER_ID = '__USER__';


  public function __construct( $app ) {

    $this->app = $app;
    $this->user = isset( $app->session ) ? $app->session->get( self::USER_ID ) : null;

  }


  public function login( $username, $password ) {

    try {

      if ( empty( $username ) ) return false;

      $user = $this->app->db->query( 'users' )
        ->where( 'username=?', $username )
        ->getFirst();

      $loginSuccess = $user ? $user->password == $password : false;

      if ( $loginSuccess ) $this->app->session->put( self::USER_ID, $user );
      else $this->logout();

      return $loginSuccess;

    }

    catch ( Exception $e ) { debug_log( $e->getMessage(), 'EXCPT' ); }

  }


  public function logged_in() {

    return $this->user;

  }


  public function logout() {

    $this->user = null;
    $this->app->session->forget( self::USER_ID );

  }

}


$auth = new Auth( $app );

$app->auth = $auth;