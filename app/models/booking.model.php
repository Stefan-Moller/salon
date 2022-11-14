<?php //Booking.model.php

class BookingModel {

  private $db;


  public function __construct( $db ) {

    $this->db = $db;

  }


  public function getById( $id ) {
    return $this->db->query('bookings')
      ->where( 'id=?', $id )
      ->getFirst(); 
  }


  public function getAll( $date ) {
    return $this->db->query('view_bookings')
      ->where( 'date=?', $date )
      ->getAll(); 
  }


  public function save( $request_data ) {

    // Strip away hidden data values starting with "_"
    $data = array_filter( (array) $request_data, 
      function( $v, $k ) { return strpos($k , '_') !== 0 and $k != 'today'; }, 
      ARRAY_FILTER_USE_BOTH );

    if ( ! empty( $data[ 'id' ] ) )
    {

      debug_log( 'Update Booking: ' . print_r( $data, true ) );
      $this->db->query( 'bookings' )
        ->where( 'id=?', data[ 'id' ] )
        ->update( $data );

    } else {

      unset( $data[ 'id' ] );

      $data[ 'status_id' ] = 1;
      $data[ 'created_by' ] = 1;

      debug_log( 'Insert Booking: ' . print_r( $data, true ) );
      $this->db->insertInto( 'bookings', $data );

    }

  }  
  
}
