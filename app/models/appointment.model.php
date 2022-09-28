<?php //appointment.model.php

class AppointmentModel {

  private $db;


  public function __construct( $db ) {

    $this->db = $db;

  }


  public function save( $request_data ) {

    // Strip away hidden data values starting with "_"
    $data = array_filter( (array) $request_data, 
      function( $v, $k ) { return strpos($k , '_') !== 0 and $k != 'today'; }, 
      ARRAY_FILTER_USE_BOTH );

    if ( ! empty( $data[ 'id' ] ) )
    {

      debug_log( 'Update Appointment: ' . print_r( $data, true ) );
      $this->db->query( 'appointments' )
        ->where( 'id=?', data[ 'id' ] )
        ->update( $data );

    } else {

      unset( $data[ 'id' ] );

      $data[ 'status_id' ] = 1;
      $data[ 'created_by' ] = 1;

      debug_log( 'Insert Appointment: ' . print_r( $data, true ) );
      $this->db->insertInto( 'appointments', $data );

    }

  }
  
}
