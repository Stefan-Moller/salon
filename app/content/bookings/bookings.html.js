 /* View Specific JS */

F1.deferred.push( function initPage() {

  console.log( '[Salon Bookings Page] Says Hi!' );


  /* Local Variables */

  let selectedDateYmd;


  /* Global Variable Aliases */

  const fetchUrl = F1.page;


  /* Global Service Aliases */

  const Modal = F1.Modal; 
  const fetch = F1.fetch;
  const err = console.err;
  const log = console.log;
  const urlParams = new URLSearchParams( window.location.search );

 
  /* Global Helper Function Aliases */

  function padNum( numStr ) { return numStr.toString().length > 1 ? numStr : '0' + numStr; }
  function ymd2dmy( ymdStr ) { return F1.Date.ymd2dmy( ymdStr ); }
  function ymd2long ( ymdStr ) { return F1.Date.ymd2long( ymdStr ); }
  function formatYmd( dateObj ) { return F1.Date.formatYmd( dateObj ); }
  function prevDayYmd( todayYmd ) { return F1.Date.prevDayYmd( todayYmd ); }
  function nextDayYmd( todayYmd ) { return F1.Date.nextDayYmd( todayYmd ); }
  function makeDraggable( elModal ) { return F1.Modal.makeDraggable( elModal ); }
  function querySelector( selector ) { return document.querySelector( selector ); }
  function querySelectorAll( selector ) { return document.querySelectorAll( selector ); }
  

  /* Local Functions */

  function getSelectedDateYmd() {
    return urlParams.get( 'date' ) || formatYmd( new Date() );
  }

  function stashDebugInfo( bookings ) {
    log( 'stashDebugInfo, Mostly for debugging :::)' );
    /* Data */
    F1.data = F1.data || {};
    F1.data.bookings = bookings;
    /* Components */
    F1.components = F1.components || [];
    F1.components.push( elDateNav );
    F1.components.push( elBookingViewModal );
    F1.components.push( elBookingEditModal );
    /* Controllers */
    F1.controllers = F1.controllers || [];
    F1.controllers.push( bookingForm );
  }
    
  function mapBooking( bookingJsonStr ) {
    const booking = JSON.parse( bookingJsonStr );
    booking.time = padNum(booking.start_hour) + ':' + padNum(booking.start_min);
    return booking;
  }

  function showLoadingIndicator() {
    log( 'showLoadingIndicator' );
    document.documentElement.classList.add( 'loading' );
  }

  function hideLoadingIndicator() {
    log( 'hideLoadingIndicator' );
    document.documentElement.classList.remove( 'loading' );
  }

  function updateCalendarDateNav( dateYmd, bookings ) {
    log( 'updateCalendarDateNav, dateYmd:', dateYmd );
    elDateNav.querySelector( '.date-view' ).innerText = ymd2long( dateYmd );
    elDateNav.querySelector( '.date-bookings' ).innerText = bookings.length;
  }

  function updateCalendarDayView( bookings ) {
    log( 'updateCalendarDayView', bookings );
    bookings.forEach( function( booking ) {
      booking.slotID = 's' + booking.station_id + '-' + padNum(booking.start_hour) + 'h' + padNum(booking.start_min);
      const elSlot = document.getElementById( booking.slotID );
      elSlot.innerHTML = renderBookingSummary( booking );
      elSlot.classList.add( 'booked' );
      const elBooking = elSlot.firstElementChild;
      elBooking.dataset.booking = booking.id;
      log( booking, elSlot, elBooking );
    } );    
  }

  function clearCalendarDayView() {
    log( 'clearCalendarDayView' );
    querySelectorAll( '.booked' ).forEach(el => { 
      el.innerHTML = ''; 
      el.style.backgroundColor = null;
    });
    F1.data.bookings = [];
  }

  function renderBookingSummary( booking ) {
    const name = booking.client + ', ' + booking.therapist;
    const slotCount = booking.duration / 15;
    const styles = `background-color:${booking.colour}; ` +
     `height:calc(${slotCount}px + ${slotCount}*var(--row--height))`;
    return `<div class="booking" style="${styles}">` +
             `<p class="trim" title="${name}">${name}</p>` +
           '</div>';
  }

  function renderBooking( booking ) {
    log( 'renderBooking', booking );
    const name = booking.client + ', ' + booking.therapist;
    return `
    <span id="booking_${booking.id}">
      <p><b>${booking.date} ${booking.time} ${booking.duration}min</b></p>
      <hr>
      <p>${booking.client} - ${booking.client_cell}</p>
      <p>${booking.therapist} - ${booking.therapist_cell}</p>
      <p>${booking.notes || ''}</p>
    </span>`;
  }

  function fetchBookings( dateYmd, success, fail ) {
    showLoadingIndicator();
    log( 'fetchBookings:', dateYmd );
    fetch( fetchUrl + '?do=getBookings&date=' + dateYmd, success, fail );
  }

  function fetchBookingsSuccess( fetchRequestObj ) {
    log( 'fetchBookingsSuccess', fetchRequestObj.statusText );
    const bookings = JSON.parse( fetchRequestObj.responseText );
    updateCalendarDateNav( selectedDateYmd, bookings );
    updateCalendarDayView( bookings );
    stashDebugInfo( bookings );
    hideLoadingIndicator(); 
  }

  function fetchBookingsError( fetchRequestObj ) {
    hideLoadingIndicator();
    err( 'fetchBookingsError', fetchRequestObj.status, 
      ', Message:', fetchRequestObj.statusText );
  }

  function fetchBooking( id, success, fail ) {
    showLoadingIndicator();
    log( 'fetchBooking, id:', id );
    fetch( fetchUrl + '?do=getBooking&id=' + id, success, fail );
  }

  function fetchBookingViewSuccess( fetchRequestObj ) {
    log( 'fetchBookingViewSuccess', fetchRequestObj );
    const booking = mapBooking( fetchRequestObj.responseText );
    const bookingHTML = renderBooking( booking );
    Modal.show( elBookingViewModal, { content: bookingHTML, event } ); 
    elBookingViewModal.booking = booking;    
    hideLoadingIndicator(); 
  }

  function fetchBookingEditSuccess( fetchRequestObj ) {
    log( 'fetchBookingEditSuccess', fetchRequestObj );
    const booking = mapBooking( fetchRequestObj.responseText );
    log( 'booking =', booking );
    Modal.show( elBookingEditModal, { form: bookingForm, init: booking, focus: 1, event } ); 
    hideLoadingIndicator(); 
  }  

  function fetchBookingError( fetchRequestObj ) {
    hideLoadingIndicator();
    err( 'fetchBookingError', fetchRequestObj.status, 
      ', Message:', fetchRequestObj.statusText );
  }


  /* Global Event Handlers */

  F1.onGotoToday = function( event ) {
    log( 'onGotoToday', event );
    clearCalendarDayView();
    selectedDateYmd = getSelectedDateYmd();
    fetchBookings( selectedDateYmd, fetchBookingsSuccess, fetchBookingsError );
  }

  F1.onGotoNextDay = function( event ) {
    log( 'onGotoNextDay', event );
    clearCalendarDayView();
    selectedDateYmd = nextDayYmd( selectedDateYmd );
    fetchBookings( selectedDateYmd, fetchBookingsSuccess, fetchBookingsError );
  }

  F1.onGotoPrevDay = function( event ) {
    log( 'onGotoPrevDay', event );
    clearCalendarDayView();
    selectedDateYmd = prevDayYmd( selectedDateYmd );
    fetchBookings( selectedDateYmd, fetchBookingsSuccess, fetchBookingsError );
  } 

  F1.onNewAppointment = function( event ) {
    log( 'onNewAppointment', event );
    const init = { date: selectedDateYmd, duration: '0' };
    Modal.show( elBookingEditModal, { form: bookingForm, init, focus: 1, event } );
  };

  F1.onEditAppointment = function( event ) {
    log( 'onEditAppointment', event );
    Modal.close( elBookingViewModal, event );
    fetchBooking( elBookingViewModal.booking.id, fetchBookingEditSuccess, fetchBookingError );
    elBookingViewModal.booking = null;
  };

  F1.onSubmitBooking = function( event ) {
    log( 'onSubmitBooking', event );
    bookingForm.validate();
    const errors = bookingForm.getErrors();
    if ( errors.length > 0 ) { 
      event.preventDefault();
      bookingForm.showErrors( errors );
      errors[0].focus();
    }
  };

  F1.onCalendarClick = function( event ) {
    log( 'onCalendarClick', event );
    const el = event.target;
    const clickedOnBooking = el.className === 'booking';
    const slotId = clickedOnBooking ? el.parentElement.id : el.id;
    let parts = slotId.split( '-' );
    const stationId = parts.length ? parseInt( parts[0].replace( 's', '' ) ) : undefined;
    parts = parts[1] ? parts[1].split( 'h' ) : [];
    const startingHour = parseInt( parts[0] );
    const startingMin = parseInt( parts[1] );
    let debugInfo = { stationId, startingHour, startingMin, el };
    if ( clickedOnBooking ) {
      const bookingId = el.dataset.booking;
      log( 'onCalendarClick - clickedOnBooking', { bookingId, ...debugInfo } );
      fetchBooking( bookingId, fetchBookingViewSuccess, fetchBookingError );
    } else {
      log( 'onCalendarClick - clickedOnEmptySlot', debugInfo );
      const bookingBase = {
        station_id: stationId,
        start_hour: startingHour,
        start_min: startingMin,
        date: selectedDateYmd,
        time: padNum( startingHour ) + ':' + padNum( startingMin ),
        duration: '0'
      }
      Modal.show( elBookingEditModal, { form: bookingForm, init: bookingBase, focus: 1, event } );      
    }
  };


  /* ------- *
   *  Start  *
   * ------- */

  const elBookingViewModal = document.getElementById( 'booking-view-modal' );
  const elBookingEditModal = document.getElementById( 'booking-edit-modal' );
  const elDateNav = document.getElementById( 'date-nav' );

  const bookingForm = new F1.Form({
    onlyShowSummary: true,
    selector: '#booking-edit-modal form'
  });

  makeDraggable( elBookingViewModal );
  makeDraggable( elBookingEditModal );

  selectedDateYmd = getSelectedDateYmd();
  fetchBookings( selectedDateYmd, fetchBookingsSuccess );

});



// Fix - onCalendarClick() event to detect if we click on a booking element - DONE
// Click on a cell and open a new booking with selected date & station! - DONE


// Get Form JS to detect selected hidden fields and update them like
// regular fields, but without validation or display update...? 


// Save using AJAX!

// Remember today after saving!

// MRP - Don't duplicate appointment when time is changed

// MRP - Check if time-slot is booked - Validate.


// Click on date in Date Nav to open a calendar modal to select the current date

// Add an event handler for selecting the date from the calendar modal.

// MRP - Only creator can edit. Role system.

// MRP - Add delete button.