<?php namespace Models;


class ServicesViewModel {

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
  //$this->therapists = $this->getTherapists();
    $this->services = $this->getServices();
    $this->itemType = 'Service';
  }


  // public function getTherapists()
  // {
  //   return $this->db->query( 'therapists' )->indexBy( 'id' )->getAll();
  // }


  // Add related entities referenced via foreign keys. e.g. def_therapist_id
  public function addRelated( $service )
  {
    // $therapist = $this->therapists[ $service->def_therapist_id ] ?? new \stdClass();
    // $service->related__def_therapist = $therapist;
    // Since this a VIEW MODEL, we can customize our data for display!
    // $service->therapist = $therapist->name ?? '-';
    return $service;
  }


  public function getService( $id )
  {
    $service = $this->db->query( 'treatments' )->where( 'id=?', $id )->getFirst();
    return $this->addRelated( $service );
  }


  public function getServices()
  {
    $services = $this->db->query( 'treatments' )->getAll();
    foreach ( $services as $service ) $this->addRelated( $service );
    return $services;
  }  

}