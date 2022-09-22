<?php

// class Station {

//   public function __construct( $no, $name, $therapist_id, $colour )
//   {
//     $this->id = $no;
//     $this->name = $name;
//     $this->therapist_id = $therapist_id;
//     $this->colour = $colour;
//   }
 
// }


// class Client {

//   public function __construct( $name, $cell, $email = 'none' )
//   {
//     $this->id = get_id();
//     $this->name = $name;
//     $this->cell = $cell;
//     $this->email = $email;
//     $this->lastAppointment = null;
//   }

// }


// class Treatment {

//   public function __construct( $name, $station_no, $duration, $price, $units )
//   {
//     $this->id = get_id();
//     $this->name = $name;
//     $this->station_no = $station_no;
//     $this->duration = $duration;
//     $this->price = $price;
//     $this->units = $units;
//   }

// }


// class Therapist {

//   public function __construct( $name, $cell, $station_no )
//   {
//     $this->id = get_id();
//     $this->name = $name;
//     $this->cell = $cell;
//     $this->station_no = $station_no;
//   }

// }


// class Appointment {
//   public function __construct( $client_id, $treatment_id, $station_id,
//     $therapist_id, $est_amount, $date, $start_hour, $start_min, 
//     $duration, $status_id )
//   {
//     $this->id = get_id();
//     $this->client_id = $client_id;
//     $this->treatment_id = $treatment_id;
//     $this->station_id = $station_id;
//     $this->therapist_id = $therapist_id;
//     $this->est_amount = $est_amount;
//     $this->date = $date;
//     $this->start_hour = $start_hour;
//     $this->start_min = $start_min;
//     $this->duration = $duration;
//     $this->status_id = $status_id;
//   }

// }


$data = new stdClass();

// $data->clients = [];
// $data->clients[] = new Client( 'Neels Moller'    , '0826941555', 'neels@tnc-it.co.za' );
// $data->clients[] = new Client( 'Sonja Lindeque'  , '0826952523', 'sonja@tnc-it.co.za' );
// $data->clients[] = new Client( 'Riette Pretorius', '0691234321', 'riette@mrprepaid.co.za' );

// $data->stations = [];
// $data->stations[] = new Station( 1 , 'LAZER'   , null, 'white'     );
// $data->stations[] = new Station( 2 , 'MASSAGE' , null, 'yellow'    );
// $data->stations[] = new Station( 3 , 'PEDICURE', null, 'red'       );
// $data->stations[] = new Station( 4 , 'REFLEX'  , null, 'white'     );
// $data->stations[] = new Station( 5 , 'STATION' , null, 'steelblue' );
// $data->stations[] = new Station( 6 , 'STATION' , null, 'green'     );
// $data->stations[] = new Station( 7 , 'TAN CAN' , null, 'orange'    );
// $data->stations[] = new Station( 8 , 'CAFÉ'    , null, 'orangered' );
// $data->stations[] = new Station( 9 , 'STATION' , null, 'deeppink'  );
// $data->stations[] = new Station( 10, 'STATION' , null, 'whitesmoke');

// $data->treatments = [];
// $data->treatments[] = new Treatment( 'Laser Hair Removal Lip'      , 1, 15, 260, 'ea' );
// $data->treatments[] = new Treatment( 'Massage Full Body Relaxation', 2, 90, 750, 'ea' );
// $data->treatments[] = new Treatment( 'Pedicure Std'                , 3, 30, 350, 'ea' );
// $data->treatments[] = new Treatment( 'Massage Reflex'              , 4, 60, 550, 'ea' );
// $data->treatments[] = new Treatment( 'Tan Can Single Session'      , 7, 30,  50, 'ea' );

// $data->therapists = [];
// $data->therapists[] = new Therapist( 'House' , null        , null );
// $data->therapists[] = new Therapist( 'Rita'  , '0846500246',    2 );
// $data->therapists[] = new Therapist( 'Gugu'  , '0796900047',    3 );
// $data->therapists[] = new Therapist( 'Elmien', '0842341779',    5 );
// $data->therapists[] = new Therapist( 'Cara'  , '0722434025',    6 );

// $data->appointments = [];
// $data->appointments[] = new Appointment( 1, 1, 1, 2, 260, '2022-07-11', 8, 30, 15, 1 );