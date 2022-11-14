<?php //calendar.model.php


class CalendarTimeSlot {

  public function __construct( $station, $hour, $min )
  {
    $this->station = $station;
    $this->hour = $hour;
    $this->min = $min;
  }

}


class CalendarModel {

  private $db;

  public function __construct( $db ) {
    $this->db = $db;
    $this->settings = $this->getSettings();
    $this->stations = $this->getStations();
    $this->clients = $this->getClients();
    $this->treatments = $this->getTreatments();
    $this->therapists = $this->getTherapists();
    $this->open_hours = explode( ',', $this->settings->open_hours );
    $this->slots_per_hour = explode( ',', $this->settings->slots_per_hour );
    $this->timeslots = $this->getTimeSlots();
  }

  public function getSettings() {
    return $this->db->query('settings')->getFirst();
  }

  public function getStations() {
    return $this->db->query('stations')->getAll();
  }

  public function getClients() {
    return $this->db->query('clients')->getAll();
  }

  public function getTreatments() {
    return $this->db->query('treatments')->getAll();
  }

  public function getTherapists() {
    return $this->db->query('therapists')->getAll();
  }

  public function getTimeSlots() {
    $timeslots = [];
    foreach ( $this->stations as $station )
      for ( $j = 0; $j < count( $this->open_hours ); $j++ )
        for ( $k = 0; $k < count ( $this->slots_per_hour ); $k++ )
        {
          $slot_id = "{$station->id}:$j:$k";
          $slot = new CalendarTimeSlot( $station->no, $j, $k );
          $timeslots[ $slot_id ] = $slot;
        }
    return $timeslots;
  }
  
}
