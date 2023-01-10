<?php

/**
 * app/services/menu.php
 * 
 * Menu services implementation - 10 Jan 2023
 * 
 * NOTE: Needs to be included BEFORE the VIEW service.
 *
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - INIT - 10 Jan 2023
 * 
 */

class MenuItem {

  public $label;
  public $href;
  public $class;
  public $icon;
  public $submenu;

  public function __construct( $label, $href, $class = '', $icon = '', $submenu = null )
  {
    $this->label = $label;
    $this->href = $href;
    $this->class = $class;
    $this->icon = $icon;
    $this->submenu = $submenu;
  }

}



class Menu {

  public $items;


  public function __construct( $items = [] )
  {
    $this->items = $items;
  }


  public function addItem( $label, $href, $class = '', $icon = '', $submenu = null )
  {
    $this->items[] = new MenuItem( $label, $href, $class, $icon, $submenu );
  }


  public function addBackendItems()
  {
    $this->items[] = new MenuItem( 'Bookings', 'bookings' );

    $this->items[] = new MenuItem( 'Admin', 'javascript:void(0)', 'admin-submenu', '', new static( [
      new MenuItem( 'Therapists' , 'admin/staff'    ),
      new MenuItem( 'Treatments' , 'admin/services' ),
      new MenuItem( 'Stations'   , 'admin/stations' ),
      new MenuItem( 'Clients'    , 'admin/clients'  )
    ] ) );

    $this->items[] = new MenuItem( 'User', 'javascript:void(0)', 'user-submenu', '', new static( [
      new MenuItem( 'Profile' , 'user/profile' ),
      new MenuItem( 'Logout'  , 'logout'       )
    ] ) );
  }

}