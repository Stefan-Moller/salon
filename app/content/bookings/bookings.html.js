 /* globals F1, VanillaCalendar */

 /* View Specific JS */

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

 
  /* Global Helper Function Aliases */

  function padNum( numStr ) { return numStr.toString().length > 1 ? numStr : '0' + numStr; }
  function ymd2dmy( ymdStr ) { return F1.Date.ymd2dmy( ymdStr ); }
  function ymd2long ( ymdStr ) { return F1.Date.ymd2long( ymdStr ); }
  function formatYmd( dateObj ) { return F1.Date.formatYmd( dateObj ); }
  function prevDayYmd( todayYmd ) { return F1.Date.prevDayYmd( todayYmd ); }
  function nextDayYmd( todayYmd ) { return F1.Date.nextDayYmd( todayYmd ); }
  function querySelector( selector ) { return document.querySelector( selector ); }
  function querySelectorAll( selector ) { return document.querySelectorAll( selector ); }
  

  /* Local Functions */
    
  function getSelectedDateYmd() {
    return urlParams.get( 'date' ) || formatYmd( new Date() );
  }

  function renderLongDate( dateYmd ) {
    return ymd2long( dateYmd );
  }

  function renderBookingSummary( booking ) {
    const slotCount = booking.duration / 15;
    const styles = `background-color:${booking.colour}; ` +
     `height:calc(${slotCount}px + ${slotCount}*var(--row--height))`;
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

  function updateDateNavCalendar( dateYmd ) {
    const dateYmdParts = dateYmd.split( '-' );
    const month = parseInt( dateYmdParts[1] ) - 1
    dateNavCalCtrl.settings.selected.dates = [ dateYmd ]; 
    dateNavCalCtrl.settings.selected.month = month;     
    dateNavCalCtrl.update();
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
    elDateNav.querySelector( '.date-view' ).innerText = renderLongDate( dateYmd );
    elDateNav.querySelector( '.date-bookings' ).innerText = bookings.length;
  }

  function updateDayViewContent( bookings ) {
    log( 'updateDayViewContent', bookings );
    bookings.forEach( booking => updateDayViewBookingSlot( 
      findBookingSlotElm( booking ), booking ) );    
  }

  function clearDayViewContent() {
    log( 'clearDayViewContent' );
    querySelectorAll( '.booked' ).forEach( elSlot => clearDayViewTimeSlot( elSlot ) );
    F1.data.bookings = [];
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
      if ( init ) stashDebugInfo( bookings );
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
    bookingViewModalCtrl.show( { data: booking, body: modalBodyHTML } ); 
    hideLoadingIndicator(); 
  }

  function fetchBookingToEditSuccess( booking ) {
    log( 'fetchBookingToEditSuccess', booking );
    booking.time = padNum(booking.start_hour) + ':' + padNum(booking.start_min);
    booking.elSlot = findBookingSlotElm( booking );
    booking.elm = booking.elSlot.firstElementChild;
    bookingFormModalCtrl.show( { data: booking } ); 
    hideLoadingIndicator();
  }

  function saveBooking( booking ) {
    log( 'saveBooking', booking );
    const formData = new FormData( bookingFormCtrl.elm ).entries();
    const postData = { __action__: 'saveBooking', ...Object.fromEntries( formData ) };
    ajaxSubmit( baseUrl, postData, saveResp => saveBookingDone( saveResp, booking.elSlot ) );
  }

  function saveBookingDone( savedResp, elCurrentlyBookedSlot ) {
    log( 'saveBookingDone', savedResp );
    if ( savedResp.error ) {
      const errors = [];
      logError( 'saveBookingDone', savedResp.error );
      bookingFormCtrl.addGlobalError( savedResp.error );
      bookingFormCtrl.showErrors();
    } else {
      bookingFormModalCtrl.close();
      const savedBooking = savedResp;
      // If we changed the DAY of the appointment, so we need to go to a new DAY!
      if ( savedBooking.date !== selectedDateYmd ) return gotoDate( savedBooking.date );
      if ( elCurrentlyBookedSlot ) clearDayViewTimeSlot( elCurrentlyBookedSlot );
      const elNewBookingSlot = findBookingSlotElm( savedBooking );
      updateDayViewBookingSlot( elNewBookingSlot, savedBooking );
    }
    hideLoadingIndicator();
  }

  function deleteBooking( booking ) {
    log( 'deleteBooking', booking );
    const id = booking.elm.dataset.booking;
    const postData = { __action__: 'deleteBooking', date: selectedDateYmd, id };
    ajaxSubmit( baseUrl, postData, deleteBookingDone );
  }

  function deleteBookingDone( deleteResp ) {
    log( 'deleteBookingDone', deleteResp );
    if ( deleteResp.error ) {
      const errors = [];
      logError( 'saveBookingDone', deleteResp.error );
      alert( deleteResp.error );
    } else {    
      clearDayViewTimeSlot( bookingViewModalCtrl.ENTITY.elm.parentElement );
      bookingViewModalCtrl.close();
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
    dateNavCalModalCtrl.close();
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
    const date = formatYmd( new Date() );
    if ( selectedDateYmd === date ) return;
    clearDayViewContent();
    selectedDateYmd = date;
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );
    fetchBookings( selectedDateYmd );
  }

  F1.onGotoNextDay = function( event ) {
    log( 'onGotoNextDay', event );
    clearDayViewContent();
    selectedDateYmd = nextDayYmd( selectedDateYmd );
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );    
    fetchBookings( selectedDateYmd );
  }

  F1.onGotoPrevDay = function( event ) {
    log( 'onGotoPrevDay', event );
    clearDayViewContent();
    selectedDateYmd = prevDayYmd( selectedDateYmd );
    urlParams.set( 'date', selectedDateYmd );
    history.pushState( { page: 'bookings' }, '', baseUrl + '?' + urlParams.toString() );    
    fetchBookings( selectedDateYmd );
  }

  F1.onShowCalendarModal = function( event ) {
    log( 'onShowCalendarModal', event );
    dateNavCalModalCtrl.show();
  }

  F1.onNewBooking = function( event ) {
    log( 'onNewBooking', event );
    const newBookingBase = { date: selectedDateYmd, duration: '0', elm: undefined };
    bookingFormModalCtrl.show( { data: newBookingBase } );
  };

  F1.onEditBooking = function( event ) {
    log( 'onEditBooking', bookingViewModalCtrl, event );
    const id = bookingViewModalCtrl.ENTITY.id;
    bookingViewModalCtrl.close();
    fetchBooking( id, fetchBookingToEditSuccess );
  };

  F1.onDeleteBooking = function( event ) {
    log( 'onDeleteBooking', event );
    if ( confirm( 'DELETE this booking... Are you sure?' ) ) {
      bookingFormModalCtrl.close();
      deleteBooking( bookingViewModalCtrl.ENTITY );
    }
  };

  F1.onSubmitBooking = function( event ) {
    log( 'onSubmitBooking', event );
    event.preventDefault();
    if ( ! bookingFormCtrl.validate() ) {
      bookingFormCtrl.addGlobalError( 'Some field values are invalid.' );
      const fieldErrors = bookingFormCtrl.showErrors()
      log( 'onSubmitBooking, fieldErrors:', fieldErrors );
      return fieldErrors.pop().focus();
    } 
    saveBooking( bookingFormModalCtrl.ENTITY );
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
      }
      bookingFormModalCtrl.show( { data: newBookingBase } );      
    }
  };


  /* Init */

  function initDateNavCalendar() {
    const ctrl = new VanillaCalendar( elDateNavCalendar );
    const dateYmdParts = selectedDateYmd.split( '-' );
    const month = parseInt( dateYmdParts[1] ) - 1
    ctrl.settings.selected.dates = [ selectedDateYmd ]; 
    ctrl.settings.selected.month = month;    
    ctrl.actions.clickDay = onClickDay;
    ctrl._type = 'DateNavCalendar_Controller';
    ctrl.name = 'selectedDateYmd';
    ctrl.init();
    return ctrl;
  }

  function initBookingEditForm() {
    return new F1.Form( { elm: elBookingEditForm, onlyShowSummary: true } );
  }

  function initDateNavCalendarModal() {
    return new F1.Modal( { elm: elDateSelectModal } );
  }

  function initBookingViewModal() {
    return new F1.Modal( { elm: elBookingViewModal } );
  }

  function initBookingEditModal() {
    return new F1.Modal( { elm: elBookingEditModal,
      formController: bookingFormCtrl,
      focusFormOnShow: 1  } );
  }


  /* Debugging */

  function stashDebugInfo( bookings ) {
    log( 'stashDebugInfo, Mainly for debugging :::)' );
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
    F1.controllers.push( dateNavCalCtrl  );
    F1.controllers.push( bookingFormCtrl );
    F1.controllers.push( bookingFormModalCtrl );
    F1.controllers.push( bookingViewModalCtrl );
    F1.controllers.push( dateNavCalModalCtrl );
  }


  /* ------- *
   *  Start  *
   * ------- */

  window.onpopstate = onPopState;

  selectedDateYmd = getSelectedDateYmd();

  const elDateNav          = document.getElementById( 'date-nav' );
  const elDateNavCalendar  = document.getElementById( 'date-nav-calendar'  );
  const elDateSelectModal  = document.getElementById( 'date-select-modal'  );
  const elBookingViewModal = document.getElementById( 'booking-view-modal' );
  const elBookingEditModal = document.getElementById( 'booking-edit-modal' );
  const elBookingEditForm  = elBookingEditModal.querySelector( 'form ');

  const dateNavCalCtrl  = initDateNavCalendar();
  const dateNavCalModalCtrl = initDateNavCalendarModal();

  const bookingFormCtrl = initBookingEditForm(); 
  const bookingViewModalCtrl = initBookingViewModal();
  const bookingFormModalCtrl = initBookingEditModal();

  fetchBookings( selectedDateYmd, 'init' );

});


// 25 Nov 2022
// -----------
// Re-factor F1.Modal and implement changes - DONE
// Fix a bunch of bugs! - DONE


// Data Model features in DB?  Get all table column names and auto-set update filter...?
// Improve Date Nav with a days ribbon accross the bottom.