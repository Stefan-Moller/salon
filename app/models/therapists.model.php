<?php namespace Models;


class TherapistModel {

  private $db;
  private $http;
  private $auth;


  public function __construct( $db, $http, $auth )
  {
    $this->db = $db;
    $this->http = $http;
    $this->auth = $auth;
  }


  public function getPostVal( $key, $default = null )
  {
    return $this->http->request->getPostVal( $key, $default );
  }


  public function mapPostData() 
  {
    debug_log( 'Therapist Model::mapPostData()' );
    $therapist = new \stdClass();
    $id = $this->getPostVal( 'id' );
    if ( $id ) $therapist->id = $id;
    $therapist->name = $this->getPostVal( 'name' );
    $therapist->email = $this->getPostVal( 'email' );
    $therapist->cell = $this->getPostVal( 'cell' );
    $therapist->colour = $this->getPostVal( 'colour' );
    $therapist->birthday = $this->getPostVal( 'birthday' );
    $therapist->std_rate = $this->getPostVal( 'std_rate' );
    $therapist->address = $this->getPostVal( 'address' );
    $therapist->station_id = $this->getPostVal( 'station_id' );
    $therapist->notes = $this->getPostVal( 'notes' );
    return $therapist;
  }


  public function getById( $id )
  {
    debug_log( 'Therapist Model::getById(), id = ' . $id );
    return $this->db->query( 'therapists' )
      ->where( 'id=?', $id )
      ->getFirst();
  }


  public function verifyUserPermissions( )
  {
    if ($this->auth->user->roles != 'super' ) {
      throw new \Exception( 'Only supervisors are allowed to perform this action.' );
    }
  }


  public function delete( $id )
  {
    debug_log( 'Therapist Model::delete(), id = ' . $id );
    $this->verifyUserPermissions();
    $this->db->query( 'therapists' )
      ->where( 'id=?', $id )
      ->delete();
  }


  public function save()
  {
    debug_log( 'Therapist Model::save()' );
    $therapistData = $this->mapPostData();

    // UPDATE...
    if ( isset( $therapistData->id ) )
    {
      debug_log( 'Update Therapist...');
      debug_log( 'New therapist data: ' . print_r( $therapistData, true ) );
      $therapistData->updated_by = $this->auth->user->id;
      $therapistData->updated_at = date( 'Y-m-d H:i:s' );
      $this->db->query( 'therapists' )
        ->where( 'id=?', $therapistData->id )
        ->update( $therapistData );
      return $therapistData->id;
    }

    // INSERT...
    $therapistData->created_by = $this->auth->user->id;
    debug_log( 'Insert Therapist: ' . print_r( $therapistData, true ) );
    $affectedRows = $this->db->insertInto( 'therapists', $therapistData );
    debug_log( 'Insert Therapist affectedRows = ' . print_r( $affectedRows, true ) );
    return $affectedRows[ 'ids' ][ 0 ];
  }
  
}
