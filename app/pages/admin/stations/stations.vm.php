<?php namespace Models;

class StationsViewModel {

  private $db;
  private $view;

  public function __construct( $db, $view )
  {
    $this->db = $db;
    $this->view = $view;
    $this->therapists = $this->getTherapists();
    $this->stations = $this->getStations();
    $this->itemType = 'Station';
  }


  public function getTherapists()
  {
    return $this->db->query( 'therapists' )->indexBy( 'id' )->getAll();
  }


  public function getTherapist( $id )
  {
    return isset( $this->therapists[$id] ) ? $this->therapists[$id]->name : '-';
  }


  public function getStations()
  {
    $stations = $this->db->query( 'stations' )->getAll();
    foreach ( $stations as $station ) $station->therapist = $this->getTherapist( $station->def_therapist_id );
    return $stations;
  }  

}