<?php namespace Models;


class StationModel {

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
    debug_log( 'Station Model::mapPostData()' );
    $station = new \stdClass();
    $id = $this->getPostVal( 'id' );
    if ( $id ) $station->id = $id;
    $station->no = $this->getPostVal( 'no' );
    $station->name = $this->getPostVal( 'name' );
    $therapist_id = $this->getPostVal( 'def_therapist_id' );
    if ( $therapist_id ) $station->def_therapist_id = $therapist_id;
    $station->colour = $this->getPostVal( 'colour' );
    $station->notes = $this->getPostVal( 'notes' );
    return $station;
  }


  public function getById( $id )
  {
    debug_log( 'Station Model::getById(), id = ' . $id );
    return $this->db->query( 'stations' )
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
    debug_log( 'Station Model::delete(), id = ' . $id );
    $this->verifyUserPermissions();
    $this->db->query( 'stations' )
      ->where( 'id=?', $id )
      ->delete();
  }


  public function save()
  {
    debug_log( 'Station Model::save()' );
    $stationData = $this->mapPostData();

    // UPDATE...
    if ( isset( $stationData->id ) )
    {
      debug_log( 'Update Station...');
      debug_log( 'New station data: ' . print_r( $stationData, true ) );
      $stationData->updated_by = $this->auth->user->id;
      $stationData->updated_at = date( 'Y-m-d H:i:s' );
      $this->db->query( 'stations' )
        ->where( 'id=?', $stationData->id )
        ->update( $stationData );
      return $stationData->id;
    }

    // INSERT...
    $stationData->created_by = $this->auth->user->id;
    debug_log( 'Insert Station: ' . print_r( $stationData, true ) );
    $affectedRows = $this->db->insertInto( 'stations', $stationData );
    debug_log( 'Insert Station affectedRows = ' . print_r( $affectedRows, true ) );
    return $affectedRows[ 'ids' ][ 0 ];
  }
  
}
