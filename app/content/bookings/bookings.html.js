/* View Specific JS */
F1.deferred.push(function initPage() {

  console.log( '[Salon Page] Says Hi!' );

  function pad( numStr ) { return numStr.length > 1 ? numStr : '0' + numStr; }

  F1.elBookingModal = document.getElementById('booking-modal');
  F1.elBookingModalInner = F1.elBookingModal.querySelector('.modal-inner');
  F1.Modal.makeDraggable( F1.elBookingModalInner );

  F1.bookingForm = new F1.Form({
    onlyShowSummary: true,
    selector: '#booking-modal form',
    submit: function(event) {
      console.log('submit(), event:', event);
      F1.bookingForm.validate();
      const errors = F1.bookingForm.getErrors();
      if ( errors.length > 0 ) { 
        event.preventDefault(); F1.bookingForm.showErrors( errors ); errors[0].focus();
      }
    }
  });

  F1.addAppointment = function() {
    F1.Modal.show( F1.elBookingModal, {
      form: F1.bookingForm,
      reset: 1,
      focus: 1
    } );
  };

  F1.appointments.forEach(function(apm) {
    const slotID = 's' + apm.station_id + '-' + pad(apm.start_hour) + 'h' + pad(apm.start_min);
    const elSlot = document.getElementById( slotID );
    const name = apm.therapist + ', ' + apm.client;
    elSlot.innerHTML = '<span class="trim" title="' + name + '">' + name + '</span>';
    elSlot.style.backgroundColor = apm.colour;
    console.log(apm, slotID, elSlot);
  });

});