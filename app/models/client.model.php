<?php namespace Models;


class ClientModel {

  private $db;
  private $http;
  private $auth;


  public function __construct( $db, $http, $auth ) {

    $this->db = $db;
    $this->http = $http;
    $this->auth = $auth;

  }


  public function getPostVal( $key, $default = null ) {

    return $this->http->request->getPostVal( $key, $default );

  }


  public function getClientData() {

    debug_log( 'Client Model::getClientData()' );

    $client = new \stdClass();
    
    $id = $this->getPostVal( 'id' );
    if ( $id ) $client->id = $id;

    $client->name  = $this->getPostVal( 'name'  );
    $client->cell  = $this->getPostVal( 'cell'  );
    $client->email = $this->getPostVal( 'email' );
    $client->notes = $this->getPostVal( 'notes' );

    return $client;
  }


  public function getById( $id ) {

    debug_log( 'Client Model::getById(), id = ' . $id );

    return $this->db->query( 'clients' )
      ->where( 'id=?', $id )
      ->getFirst(); 

  }


  public function verifyUserPermissions( ) {

    if ($this->auth->user->roles != 'super' ) {
      throw new \Exception( 'Only supervisors are allowed to perform this action.' );
    }

  }


  public function delete( $id ) {

    debug_log( 'Client Model::delete(), id = ' . $id );

    $this->verifyUserPermissions();

    $this->db->query( 'clients' )
      ->where( 'id=?', $id )
      ->delete();

  }


  public function save() {

    debug_log( 'Client Model::save()' );

    $clientData = $this->getClientData();

    // UPDATE...
    if ( isset( $clientData->id ) )
    {
      debug_log( 'Update Client...');
      debug_log( 'New client data: ' . print_r( $clientData, true ) );

      $clientData->updated_by = $this->auth->user->id;
      $clientData->updated_at = date( 'Y-m-d H:i:s' );

      $this->db->query( 'clients' )
        ->where( 'id=?', $clientData->id )
        ->update( $clientData );

      return $clientData->id;
    }

    // INSERT...
    $clientData->created_by = $this->auth->user->id;

    debug_log( 'Insert Client: ' . print_r( $clientData, true ) );
    $affectedRows = $this->db->insertInto( 'clients', $clientData );

    debug_log( 'Insert Client affectedRows = ' . print_r( $affectedRows, true ) );

    return $affectedRows[ 'ids' ][ 0 ];

  }
  
}
