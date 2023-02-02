<?php namespace Models;


class StaffViewModel {

  private $db;
  private $http;
  private $auth;
  private $view;


  public function __construct( $db, $http = null, $auth = null, $view = null )
  {
    $this->db = $db;
    $this->http = $http;
    $this->auth = $auth;    
    $this->view = $view;
    $this->therapists = $this->getTherapists();
    $this->stations = $this->getStations();
    $this->itemType = 'Station';
  }


  public function getTherapists()
  {
    return $this->db->query( 'therapists' )->indexBy( 'id' )->getAll();
  }


  // Add related entities referenced via foreign keys. e.g. def_therapist_id
  public function addRelated( $station )
  {
    $therapist = $this->therapists[ $station->def_therapist_id ] ?? new \stdClass();
    $station->related__def_therapist = $therapist;
    // Since this a VIEW MODEL, we can customize our data for display!
    $station->therapist = $therapist->name ?? '-';
    return $station;
  }


  public function getStation( $id )
  {
    $station = $this->db->query( 'stations' )->where( 'id=?', $id )->getFirst();
    return $this->addRelated( $station );
  }


  public function getStations()
  {
    $stations = $this->db->query( 'stations' )->orderBy( 'no' )->getAll();
    foreach ( $stations as $station ) $this->addRelated( $station );
    return $stations;
  }  

}