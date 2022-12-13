<?php namespace Models;


class BookingModel {

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


  public function getBookingData() {

    debug_log( 'Booking Model::getBookingData()' );

    $booking = new stdClass();
    
    $id = $this->getPostVal( 'id' );
    if ( $id ) $booking->id = $id;

    $booking->status_id    = $this->getPostVal( 'status_id', 1 );
    $booking->client_id    = $this->getPostVal( 'client_id' );
    $booking->treatment_id = $this->getPostVal( 'treatment_id' );
    $booking->therapist_id = $this->getPostVal( 'therapist_id' );
    $booking->station_id   = $this->getPostVal( 'station_id' );
    $booking->notes        = $this->getPostVal( 'notes' );
    $booking->date         = $this->getPostVal( 'date' );
    $booking->start_hour   = $this->getPostVal( 'start_hour' );
    $booking->start_min    = $this->getPostVal( 'start_min' );
    $booking->duration     = $this->getPostVal( 'duration' );

    return $booking;
  }


  public function verifyUserPermissions( $booking_id ) {

    $existingBooking =  $this->db->query( 'bookings' )
      ->where( 'id=?', $booking_id)
      ->getFirst(); 

    if ( ! $existingBooking ) {
      throw new \Exception( 'It looks like booking no. ' . $booking_id  .
      ' does not exist anymore! Request aborted.' );
    }

    if ( $existingBooking->created_by != $this->auth->user->id ) {
      throw new \Exception( 'Only the owner of this booking is' .
        ' allowed to change it.' );
    }

  }


  public function validateAvailability( $booking ) {

    debug_log( 'validateAvailability, start' );

    $start_hour = $booking->start_hour;
    $start = $booking->start_min + $start_hour * 60;
    $end = $start + $booking->duration;

    $q = $this->db->query( 'bookings' );
    
    if ( isset( $booking->id ) ) $q->where( 'id<>?', $booking->id );
    
    $bookedBookings = $q
      ->where( 'date=?', $booking->date )
      ->where( 'station_id=?', $booking->station_id )
      ->getAll();

    if ( count( $bookedBookings ) == 0 ) return true;

    foreach ( $bookedBookings as $index => $bookedBooking )
    {
      $booked_id = $bookedBooking->id;
      $booked_start = $bookedBooking->start_min + $bookedBooking->start_hour * 60;
      $booked_end = $booked_start + $bookedBooking->duration;

      $vars = compact('index', 'booked_id', 'booked_start', 'booked_end', 'start', 'end');
      debug_log( 'validateAvailability: ' . print_r( $vars , true ) );

      if ( $start >= $booked_start and $start < $booked_end ) return false;
      if ( $end > $booked_start and $end <= $booked_end ) return false;
    }

    return true;
  }



  public function getAll( $date ) {

    debug_log( 'Booking Model::getAll(), date = ' . $date );

    return $this->db->query( 'view_bookings' )
      ->where( 'date=?', $date )
      ->getAll(); 

  }
  

  public function getById( $id ) {

    debug_log( 'Booking Model::getById(), id = ' . $id );

    return $this->db->query( 'view_bookings' )
      ->where( 'id=?', $id )
      ->getFirst(); 

  }


  public function delete( $id ) {

    debug_log( 'Booking Model::delete(), id = ' . $id );

    $this->verifyUserPermissions( $id );

    $this->db->query( 'bookings' )
      ->where( 'id=?', $id )
      ->delete();

  }


  public function save() {

    debug_log( 'Booking Model::save()' );

    $bookingData = $this->getBookingData();

    // UPDATE...
    if ( isset( $bookingData->id ) )
    {
      debug_log( 'Update Booking...');
      debug_log( 'New booking data: ' . print_r( $bookingData, true ) );

      $this->verifyUserPermissions( $bookingData->id );

      if ( $this->validateAvailability( $bookingData ) )
      {
        $bookingData->updated_by = $this->auth->user->id;
        $bookingData->updated_at = date( 'Y-m-d H:i:s' );

        $this->db->query( 'bookings' )
          ->where( 'id=?', $bookingData->id )
          ->update( $bookingData );

        return $bookingData->id;
      }
      else {
        throw new \Exception( 'This booking clashes with another booking! Request aborted.' );
      }
    }

    // INSERT...
    $bookingData->created_by = $this->auth->user->id;

    debug_log( 'Insert Booking: ' . print_r( $bookingData, true ) );
    $affectedRows = $this->db->insertInto( 'bookings', $bookingData );

    debug_log( 'Insert Booking affectedRows = ' . print_r( $affectedRows, true ) );

    return $affectedRows[ 'ids' ][ 0 ];

  }
  
}
