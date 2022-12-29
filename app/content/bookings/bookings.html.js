/* globals F1, VanillaCalendar */

/* View Specific JS */

import DateTime from './js/vendors/f1js/datetime.js';
import Select from './js/vendors/f1js/select.js';
import Modal from './js/vendors/f1js/modal.js';
import Form from './js/vendors/f1js/form.js';

import validatorTypes from './js/vendors/f1js/form-validatortypes.js';
import fieldTypes from './js/vendors/f1js/form-fieldtypes.js';


F1.deferred.push( function initPage() {

  console.log( '[Bookings Page Controller] Says Hi!' );


  /* Local Variables */

  let selectedDateYmd;


  /* Global Variable Aliases */

  const baseUrl = F1.page;


  /* Global Service Aliases */

  const log = console.log;
  const logError = console.error;
  const urlParams = new URLSearchParams( window.location.search );
  const DT = new DateTime();

 
  /* Global Helper Function Aliases */

  function padNum( numStr ) { return numStr.toString().length > 1 ? numStr : '0' + numStr; }
  function querySelector( selector ) { return document.querySelector( selector ); }
  function querySelectorAll( selector ) { return document.querySelectorAll( selector ); }
  

  /* Local Functions */
    
  function getSelectedDateYmd() {
    return urlParams.get( 'date' ) || DT.formatYmd( new Date() );
  }

  function renderLongDate( dateYmd ) {
    return DT.ymd2long( dateYmd );
  }

  function renderClientOption( client ) {
    return client.name + '<small> - ' + client.cell + '</small>'; 
  }

  function renderBookingSummary( booking ) {
    const slotCount = booking.duration / 15;
    const styles = `background-color:${booking.colour}; ` +
     `height:calc(${slotCount}px + ${slotCount}*var(--flexgrid-row-height))`;
    const station = booking.station_name === 'STATION'
      ? 'STATION ' + booking.station_no
      : booking.station_name;
    const notes = booking.notes ? `<p class="notes">${booking.notes}</p>` : '';
    return `<div class="booking" style="${styles}">` +
             `<p class="trim">${booking.time} <b>${booking.client}</b></p>` +
             `<p class="station">${station}</p>` +
             `<p class="trim"><i>${booking.therapist}</i></p>` +
             notes +
           '</div>';
  }

  function renderBookingModalView( booking ) {
    log( 'renderBooking', booking );
    const longDate = renderLongDate( booking.date );
    const station = booking.station_name === 'STATION'
      ? 'STATION ' + booking.station_no
      : booking.station_name;
    return `
    <div class="booking-detail" data-booking="${booking.id}">
      <h4><b>${booking.time}</b> - <b>${longDate}</b>
        &nbsp;<small>(${booking.duration}min)</small>
      </h4>
      <hr>
      <p>${booking.client} - ${booking.client_cell}</p>
      <p>${station} - ${booking.therapist} - ${booking.therapist_cell}</p>
      <p>&nbsp;</p>
      <p class="notes">${booking.notes || ''}</p>
    </div>`;
  }

  function mountErrorSummary( formCtrl, elSummary ) {
    formCtrl.elm.parentElement.insertBefore( elSummary, formCtrl.elm );
  }

  function updateDateNavCalendar( dateYmd ) {
    log( 'updateDateNavCalendar, dateYmd:', dateYmd );
    const dateYmdParts = dateYmd.split( '-' );
    const month = parseInt( dateYmdParts[1] ) - 1;
    calCtrl_dateNavCal.settings.selected.dates = [ dateYmd ]; 
    calCtrl_dateNavCal.settings.selected.month = month;     
    calCtrl_dateNavCal.update();
  }

  function updateDayViewBookingSlot( elBookingSlot, booking ) {
    log( 'Update Booking Slot', elBookingSlot, booking );
    booking.time = padNum(booking.start_hour) + ':' + padNum(booking.start_min);
    elBookingSlot.innerHTML = renderBookingSummary( booking );
    const elBooking = elBookingSlot.firstElementChild;
    booking.elSlot = elBookingSlot;
    booking.elm = elBooking;
    elBookingSlot.classList.add( 'booked' );
    elBooking.dataset.booking = booking.id;
    elBooking.ENTITY = booking;
  }

  function updateDateNavContent( dateYmd, bookings ) {
    log( 'updateDateNavContent, dateYmd:', dateYmd );
    elHeader.querySelector( '.date-button span' ).innerText = renderLongDate( dateYmd );
    elHeader.querySelector( '.bookings-count-badge' ).innerText = bookings.length;
    updateDateNavCalendar( dateYmd );
  }

  function updateDayViewContent( bookings ) {
    log( 'updateDayViewContent', bookings );
    bookings.forEach( booking => updateDayViewBookingSlot( 
      findBookingSlotElm( booking ), booking ) );    
  }

  function updateClientEditButton() {
    elEditClientBtn.classList.toggle( 'hidden', ! elClientField.MODEL.getValue() );
  }

  function clearDayViewContent() {
    log( 'clearDayViewContent' );
    querySelectorAll( '.booked' ).forEach( elSlot => clearDayViewTimeSlot( elSlot ) );
    updateDebugInfo( { bookings: [] } );
  }

  function clearDayViewTimeSlot( elTimeSlot ) {
    log( 'clearDayViewTimeSlot', elTimeSlot ); 
    if ( ! elTimeSlot ) return;   
    elTimeSlot.classList.remove( 'booked' );
    elTimeSlot.innerHTML = ''; 
  }

  function showLoadingIndicator() {
    log( 'showLoadingIndicator' );
    document.documentElement.classList.add( 'loading' );
  }

  function hideLoadingIndicator() {
    log( 'hideLoadingIndicator' );
    document.documentElement.classList.remove( 'loading' );
  }

  function findBookingSlotElm( booking ) {
    const slotID = 's' + booking.station_id + '-' + 
      padNum(booking.start_hour) + 'h' + padNum(booking.start_min);
    return document.getElementById( slotID );
  }  

  function ajaxError( method = 'get', error ) {
    hideLoadingIndicator();
    logError( 'Ajax request failed! Method:', method, ', Error:', error );
  }

  function ajaxFetch( fetchUrl, onSuccess, extraOptions ) {
    showLoadingIndicator();
    const options = { method: 'get', credentials: 'same-origin',
      headers: { 'X-Requested-With': 'Fetch' }, ...extraOptions };
    log( 'ajaxFetch', { fetchUrl, options, extraOptions } );
    fetch( fetchUrl, options )
      .then( resp => resp.json() ).then( onSuccess )
      .catch( error => ajaxError( options.method, error ) );
  }

  function ajaxSubmit( postUrl, postData, onSuccess ) {
    log( 'ajaxSubmit', { postUrl, postData } );
    const body = new URLSearchParams( postData );
    ajaxFetch( postUrl, onSuccess, { method: 'post', body } );
  }

  function fetchBookings( dateYmd, init ) {
    log( 'fetchBookings', dateYmd );
    ajaxFetch( baseUrl + '?do=getBookings&date=' + dateYmd, 
      fetchResp => fetchBookingsDone( fetchResp, init ) );
  }

  function fetchBookingsDone( fetchResp, init ) {
    log( 'fetchBookingsDone', fetchResp );
    if ( fetchResp.error ) {
      const errors = [];
      logError( 'fetchBookingsDone', fetchResp.error );
      alert( fetchResp.error );
    } else {
      const bookings = fetchResp;
      updateDateNavContent( selectedDateYmd, bookings );
      updateDayViewContent( bookings );
      if ( init ) stashDebugInfo( { bookings } );
    }
    hideLoadingIndicator(); 
  }

  function fetchBooking( id, onSuccess ) {
    log( 'fetchBooking' );
    ajaxFetch( baseUrl + '?do=getBooking&id=' + id, onSuccess );
  }

  function fetchBookingToViewSuccess( booking ) {
    log( 'fetchBookingToViewSuccess', booking );
    booking.time = padNum(booking.start_hour) + ':' + padNum(booking.start_min);
    booking.elSlot = findBookingSlotElm( booking );
    booking.elm = booking.elSlot.firstElementChild;
    const modalBodyHTML = renderBookingModalView( booking );
    modalCtrl_bookingView.show( { data: booking, body: modalBodyHTML } ); 
    hideLoadingIndicator(); 
  }

  function fetchBookingToEditSuccess( booking ) {
    log( 'fetchBookingToEditSuccess', booking );
    booking.time = padNum(booking.start_hour) + ':' + padNum(booking.start_min);
    booking.elSlot = findBookingSlotElm( booking );
    booking.elm = booking.elSlot.firstElementChild;
    modalCtrl_bookingForm.show( { data: booking } ); 
    hideLoadingIndicator();
  }

  function saveBooking( booking ) {
    log( 'saveBooking', booking );
    const formData = new FormData( formCtrl_bookingForm.elm ).entries();
    const postData = { __action__: 'saveBooking', ...Object.fromEntries( formData ) };
    ajaxSubmit( baseUrl, postData, saveResp => saveBookingDone( saveResp, booking.elSlot ) );
  }

  function saveBookingDone( savedResp, elCurrentlyBookedSlot ) {
    log( 'saveBookingDone', savedResp );
    if ( savedResp.error ) {
      const errors = [];
      logError( 'saveBookingDone', savedResp.error );
      formCtrl_bookingForm.addFormError( savedResp.error );
      formCtrl_bookingForm.showErrors();
    } else {
      modalCtrl_bookingForm.close();
      const savedBooking = savedResp;
      /* If we changed the DAY of the appointment, so we need to go to a new DAY! */
      if ( savedBooking.date !== selectedDateYmd ) return gotoDate( savedBooking.date );
      if ( elCurrentlyBookedSlot ) clearDayViewTimeSlot( elCurrentlyBookedSlot );
      const elNewBookingSlot = findBookingSlotElm( savedBooking );
      updateDayViewBookingSlot( elNewBookingSlot, savedBooking );
    }
    hideLoadingIndicator();
  }

  function deleteBooking( booking ) {
    log( 'deleteBooking', booking );
    const postData = { __action__: 'deleteBooking', date: selectedDateYmd, id: booking.id };
    ajaxSubmit( baseUrl, postData, deleteBookingDone );
  }

  function deleteBookingDone( deleteResp ) {
    log( 'deleteBookingDone', deleteResp );
    if ( deleteResp.error ) {
      const errors = [];
      logError( 'deleteBookingDone', deleteResp.error );
      alert( deleteResp.error );
    } else {    
      clearDayViewTimeSlot( modalCtrl_bookingView.ENTITY.elm.parentElement );
      modalCtrl_bookingView.close();
    }
    hideLoadingIndicator();
  }

  function fetchClient( id, onSuccess ) {
    log( 'fetchClient' );
    ajaxFetch( baseUrl + '?do=getClient&id=' + id, onSuccess );
  }

  function fetchClientToEditSuccess( client ) {
    log( 'fetchClientToEditSuccess', client );
    modalCtrl_clientForm.show( { data: client } ); 
    hideLoadingIndicator();
  }

  function saveClient( client ) {
    log( 'saveClient', client );
    const formData = new FormData( formCtrl_clientForm.elm ).entries();
    const postData = { __action__: 'saveClient', ...Object.fromEntries( formData ) };
    ajaxSubmit( baseUrl, postData, saveResp => saveClientDone( saveResp ) );
  }

  function saveClientDone( savedResp ) {
    log( 'saveClientDone', savedResp );
    if ( savedResp.error ) {
      const errors = [];
      logError( 'saveClientDone', savedResp.error );
      formCtrl_clientForm.addFormError( savedResp.error );
      formCtrl_clientForm.showErrors();
      return hideLoadingIndicator();
    }
    modalCtrl_clientForm.close();
    const savedClient = savedResp;
    const clientSelectCtrl = elClientField.MODEL.controller;
    const existingOpt = clientSelectCtrl.options.filter(opt => opt.value == savedClient.id)[0];
    if ( existingOpt ) {
      /* NB: We assume BookingFormModal is open! */
      const booking = modalCtrl_bookingForm.ENTITY;
      booking.client = savedClient.name;
      booking.client_cell = savedClient.cell;
      updateDayViewBookingSlot( booking.elSlot, booking );
      existingOpt.title = renderClientOption( savedClient );
      clientSelectCtrl.toggleSelect( existingOpt.key );
      return hideLoadingIndicator();
    }
    const lastOptIndex = clientSelectCtrl.options.length - 1;
    const lastOpt = clientSelectCtrl.options[ lastOptIndex ];
    const newOpt = {
      key: lastOpt ? lastOpt.key + 1 : 0,
      title: renderClientOption( savedClient ),
      value: savedClient.id, 
      img: '', desc: '',
      selected: '', 
      disabled: ''
    };
    clientSelectCtrl.options.push( newOpt );
    clientSelectCtrl.toggleSelect( newOpt.key );
    hideLoadingIndicator();
  }

  function deleteClient( client ) {
    log( 'deleteClient', client );
    const postData = { __action__: 'deleteClient', date: selectedDateYmd, id: client.id };
    ajaxSubmit( baseUrl, postData, deleteClientDone );
  }

  function deleteClientDone( deleteResp ) {
    log( 'deleteClientDone', deleteResp );
    if ( deleteResp.error ) {
      const errors = [];
      logError( 'deleteBookingDone', deleteResp.error );
      alert( deleteResp.error );
    } else {
      /* NB: We assume BookingFormModal is open! */
      const clientSelectCtrl = elClientField.MODEL.controller;
      const deletedClient = modalCtrl_clientForm.ENTITY;
      clientSelectCtrl.options = clientSelectCtrl.options.filter(opt => opt.value != deletedClient.id);
      clientSelectCtrl.toggleSelect(0); /* Clears the selected option. */
      modalCtrl_clientForm.close();
    }
    hideLoadingIndicator();
  }  

  function gotoDate( date ) {
    log( 'gotoDate', date );
    if ( selectedDateYmd === date ) return;
    clearDayViewContent();
    selectedDateYmd = date;
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );
    fetchBookings( selectedDateYmd );
  }

  function onClickDay( event ) {
    log( 'onClickDay', event );
    modalCtrl_dateNavCal.close();
    const elClickedDay = event.target;
    const dateYmd = elClickedDay.dataset.calendarDay;
    gotoDate( dateYmd );
  }

  function onPopState( event ) {
    log( 'onPopState', event );
    if ( window.history.state !== null ) location.reload();
  }


  /* Global Event Handlers */

  F1.onGotoToday = function( event ) {
    log( 'onGotoToday', event );
    const date = DT.formatYmd( new Date() );
    if ( selectedDateYmd === date ) return;
    clearDayViewContent();
    selectedDateYmd = date;
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );
    fetchBookings( selectedDateYmd );
  };

  F1.onGotoNextDay = function( event ) {
    log( 'onGotoNextDay', event );
    clearDayViewContent();
    selectedDateYmd = DT.nextDayYmd( selectedDateYmd );
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );    
    fetchBookings( selectedDateYmd );
  };

  F1.onGotoPrevDay = function( event ) {
    log( 'onGotoPrevDay', event );
    clearDayViewContent();
    selectedDateYmd = DT.prevDayYmd( selectedDateYmd );
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );    
    fetchBookings( selectedDateYmd );
  };

  F1.onShowCalendarModal = function( event ) {
    log( 'onShowCalendarModal', event );
    modalCtrl_dateNavCal.show();
  };

  F1.onNewBooking = function( event ) {
    log( 'onNewBooking', event );
    const newBookingBase = { date: selectedDateYmd, duration: '0', elm: undefined };
    modalCtrl_bookingForm.show( { data: newBookingBase } );
  };

  F1.onEditBooking = function( event ) {
    log( 'onEditBooking', modalCtrl_bookingView, event );
    const id = modalCtrl_bookingView.ENTITY.id;
    modalCtrl_bookingView.close();
    fetchBooking( id, fetchBookingToEditSuccess );
  };

  F1.onDeleteBooking = function( event ) {
    log( 'onDeleteBooking', event );
    if ( confirm( 'DELETE this booking... Are you sure?' ) ) {
      modalCtrl_bookingView.close();
      deleteBooking( modalCtrl_bookingView.ENTITY );
    }
  };

  F1.onDeleteClient = function( event ) {
    log( 'onDeleteClient', event );
    if ( confirm( 'DELETE this client... Are you sure?' ) ) {
      deleteClient( modalCtrl_clientForm.ENTITY );
    }
  };

  F1.onNewClient = function( event ) {
    log( 'onNewClient', event );
    const newClientBase = {};
    modalCtrl_clientForm.show( { data: newClientBase } );
  };

  F1.onEditClient = function( event ) {
    log( 'onEditClient', event );
    const id = elClientField.MODEL.getValue();
    fetchClient( id, fetchClientToEditSuccess );
  };

  F1.onClientChanged = function( event ) {
    log( 'onClientChanged', event );
    updateClientEditButton();
  };

  F1.onSubmitClient = function( event ) {
    log( 'onSubmitClient', event );
    event.preventDefault();
    if ( ! formCtrl_clientForm.validate() ) {
      const fieldErrors = formCtrl_clientForm.showErrors();
      log( 'onSubmitClient, fieldErrors:', fieldErrors );
      return fieldErrors[0].focus();
    } 
    saveClient( modalCtrl_clientForm.ENTITY );
  };

  F1.onSubmitBooking = function( event ) {
    log( 'onSubmitBooking', event );
    event.preventDefault();
    if ( ! formCtrl_bookingForm.validate() ) {
      const fieldErrors = formCtrl_bookingForm.showErrors();
      log( 'onSubmitBooking, fieldErrors:', fieldErrors );
      return fieldErrors[0].focus();
    } 
    saveBooking( modalCtrl_bookingForm.ENTITY );
  };

  F1.onDayViewGridClick = function( event ) {
    log( 'onDayViewGridClick', event );
    const elm = event.target;
    const clickedOnBooking = elm.className === 'booking';
    const slotId = clickedOnBooking ? elm.parentElement.id : elm.id;
    const slotIdParts = slotId.split( '-' );
    const stationId = slotIdParts.length ? parseInt( slotIdParts[0].replace( 's', '' ) ) : undefined;
    const timeParts = slotIdParts[1] ? slotIdParts[1].split( 'h' ) : [];
    const startingHour = parseInt( timeParts[0] );
    const startingMin = parseInt( timeParts[1] );
    const debugInfo = { stationId, startingHour, startingMin, elm };
    if ( clickedOnBooking ) {
      log( 'onDayViewGridClick - clickedOnBooking', debugInfo );
       const id = elm.dataset.booking;
      fetchBooking( id, fetchBookingToViewSuccess );
    } else {
      log( 'onDayViewGridClick - clickedOnEmptySlot', debugInfo );
      const newBookingBase = {
        station_id: stationId,
        start_hour: startingHour,
        start_min: startingMin,
        date: selectedDateYmd,
        time: padNum( startingHour ) + ':' + padNum( startingMin ),
        duration: '0',
        elSlot: elm
      };
      modalCtrl_bookingForm.show( { data: newBookingBase } );      
    }
  };


  /* Init */

  function initDateNavCalendar() {
    const ctrl = new F1.VanillaCalendar( elDateNavCalendar );
    const dateYmdParts = selectedDateYmd.split( '-' );
    const month = parseInt( dateYmdParts[1] ) - 1;
    ctrl.settings.selected.dates = [ selectedDateYmd ]; 
    ctrl.settings.selected.month = month;    
    ctrl.actions.clickDay = onClickDay;
    ctrl._type = 'DateNavCalendar_Controller';
    ctrl.name = 'selectedDateYmd';
    ctrl.init();
    return ctrl;
  }

  function initClientEditForm() {
    log( 'initClientEditForm' );
    const showErrorSummary = true;
    return new Form({ elm: elClientEditForm, fieldTypes, validatorTypes,
      showErrorSummary, mountErrorSummary });
  }

  function initBookingEditForm() {
    log( 'initBookingEditForm' );
    const showErrorSummary = true;
    const afterInit = updateClientEditButton;
    return new Form({ elm: elBookingEditForm, fieldTypes, validatorTypes,
      afterInit, showErrorSummary, mountErrorSummary });
  }

  function initDateNavCalendarModal() {
    return new Modal( { elm: elDateSelectModal } );
  }

  function initBookingViewModal() {
    return new Modal( { elm: elViewBookingModal } );
  }

  function initBookingEditModal() {
    return new Modal( { elm: elEditBookingModal,
      formController: formCtrl_bookingForm,
      focusFormOnShow: 1  } );
  }

  function initClientEditModal() {
    return new Modal( { elm: elEditClientModal,
      formController: formCtrl_clientForm,
      focusFormOnShow: 1  } );
  }


  /* Debugging */

  function stashDebugInfo( info ) {
    log( 'stashDebugInfo, Mainly for debugging :::)', info );
    /* Data */
    F1.data.bookings = info.bookings;
    /* Components */
    F1.components.elHeader = elHeader;
    F1.components.elDateSelectModal = elDateSelectModal;
    F1.components.elViewBookingModal = elViewBookingModal;
    F1.components.elEditBookingModal = elEditBookingModal;
    F1.components.elEditClientModal = elEditClientModal;
    F1.components.elEditClientBtn = elEditClientBtn;
    F1.components.elClientField = elClientField;
    /* Controllers */
    F1.controllers.formCtrl_bookingForm = formCtrl_bookingForm;
    F1.controllers.modalCtrl_dateNavCal = modalCtrl_dateNavCal;
    F1.controllers.modalCtrl_bookingView = modalCtrl_bookingView;
    F1.controllers.modalCtrl_bookingForm = modalCtrl_bookingForm;
    F1.controllers.modalCtrl_clientForm = modalCtrl_clientForm;
    F1.controllers.calCtrl_dateNavCal = calCtrl_dateNavCal;
    formCtrl_bookingForm.fields.forEach( field => { if ( field.controller.name ) 
      F1.controllers[ field.controller.name ] = field.controller; } ); 
  }

  function updateDebugInfo( info ) {
    log( 'updateDebugInfo', info );
    /* Data */
    F1.data.bookings = info.bookings;
  }

  Object.assign( F1, { DateTime, Modal, Form, Select, VanillaCalendar, 
    fieldTypes, validatorTypes } );



  /* ------- *
   *  Start  *
   * ------- */

  window.onpopstate = onPopState;

  selectedDateYmd = getSelectedDateYmd();

  const elHeader           = document.getElementById( 'main-header' );
  const elDateNavCalendar  = document.getElementById( 'date-nav-calendar'  );
  const elDateSelectModal  = document.getElementById( 'date-select-modal'  );
  const elEditClientModal  = document.getElementById( 'edit-client-modal'  );
  const elEditBookingModal = document.getElementById( 'edit-booking-modal' );
  const elViewBookingModal = document.getElementById( 'view-booking-modal' );
  const elBookingEditForm  = elEditBookingModal.querySelector( 'form ' );
  const elClientEditForm   = elEditClientModal.querySelector( 'form ' );
  const elClientField      = elBookingEditForm.querySelector( '.client .field' );
  const elEditClientBtn    = elClientField.parentElement.querySelector( '.button-edit' );

  const calCtrl_dateNavCal    = initDateNavCalendar();
  const formCtrl_clientForm   = initClientEditForm(); 
  const formCtrl_bookingForm  = initBookingEditForm(); 
  const modalCtrl_dateNavCal  = initDateNavCalendarModal();
  const modalCtrl_bookingForm = initBookingEditModal();
  const modalCtrl_bookingView = initBookingViewModal();
  const modalCtrl_clientForm  = initClientEditModal();

  fetchBookings( selectedDateYmd, 'init' );

});
