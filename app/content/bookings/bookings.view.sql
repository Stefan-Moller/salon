select 
  `b`.`id` AS `id`, 
  `b`.`date` AS `date`, 
  `b`.`start_hour` AS `start_hour`, 
  `b`.`start_min` AS `start_min`, 
  `b`.`duration` AS `duration`, 
  `c`.`id` AS `client_id`, 
  `c`.`name` AS `client`, 
  `c`.`cell` AS `client_cell`, 
  `t`.`id` AS `therapist_id`, 
  `t`.`name` AS `therapist`, 
  `t`.`cell` AS `therapist_cell`, 
  `t`.`colour` AS `colour`, 
  `p`.`id` AS `treatment_id`, 
  `b`.`station_id` AS `station_id`, 
  `s`.`name` AS `station_name`, 
  `s`.`no` AS `station_no`, 
  `b`.`notes` AS `notes`, 
  `b`.`created_at` AS `created_at`, 
  `b`.`created_by` AS `created_by` 
from 
  `bookings` `b` 
  left join `clients` `c` on `c`.`id` = `b`.`client_id`
  left join `therapists` `t` on `t`.`id` = `b`.`therapist_id`
  left join `treatments` `p` on `p`.`id` = `b`.`treatment_id`
  left join `stations` `s` on `s`.`id` = `b`.`station_id`

order by 
  `b`.`date`, 
  `b`.`start_hour`, 
  `b`.`start_min`
