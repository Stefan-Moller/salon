/* globals F1 */

/* View Specific JS */


/* Import required F1JS modules */

// import { Form } from './js/vendors/f1js/form/form.js';


F1.deferred.push(function initPage() {

  console.log( '[Salon Login Page] Says Hi!' );
  
  const log = console.log;
  const logError = console.error;
  const loginForm = new Form( { selector: 'form', onlyShowSummary: true });


  F1.onSubmit = function( event ) {
    log( 'LoginForm::onSubmit(), event:', event );
    loginForm.validate();
    const errors = loginForm.getErrors();
    if ( errors.length > 0 ) { 
      event.preventDefault();
      loginForm.showErrors( errors );
      errors[0].focus();
    }
  };


  F1.Form = Form;

  F1.controllers.formCtrl_loginForm = loginForm;

});