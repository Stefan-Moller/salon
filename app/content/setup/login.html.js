/* View Specific JS */
F1.deferred.push(function initPage() {

  console.log( '[Salon Login Page] Says Hi!' );

  F1.loginForm = new F1.Form({
    onlyShowSummary: true,
    selector: 'form',
    submit: function(event) {
      console.log('submit(), event:', event);
      F1.loginForm.validate();
      const errors = F1.loginForm.getErrors();
      if ( errors.length > 0 ) { 
        event.preventDefault(); F1.loginForm.showErrors( errors ); errors[0].focus();
      }
    }
  });

});