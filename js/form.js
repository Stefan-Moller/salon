/* globals F1 */

/**
 * F1 Form JS
 * 
 * @author C. Moller <xavier.tnc@gmail.com>
 * 
 * @version 1.0.0 - 10 Jul 2022
 * 
 */

( function( window, document ) {


function extend( obj, props ) { 
  for ( let key in props || {} ) { obj[ key ] = props[ key ]; } }


function clearErrors( frmObj, errorsSelector ) {
  frmObj.errors = [];
  frmObj.elm.classList.remove( frmObj.unhappyClass );
  errorsSelector = errorsSelector || '.' + frmObj.errorsClass.replace( ' ', '.' );
  frmObj.elm.querySelectorAll( errorsSelector ).forEach(
    elMsgs => elMsgs.parentElement.removeChild( elMsgs ) );
}


const Form = function( options )
{
  const defaults = {
    selector: 'form',
    fieldSelector: '.field',
    summaryClass: 'summary',
    unhappyClass: 'unhappy',
    errorsClass: 'errors',
    fields: []
  };
  extend ( this, defaults );
  extend( this, options );
  this.elm = document.querySelector( this.selector || 'form' );
  this.getFields();
  this.init( this.initialValues );
};


Form.FieldTypes = {};
Form.Validators = {};


Form.Error = function( field, message )
{
  this.field = field;
  this.message = message;
}

Form.Error.prototype.focus = function() { this.field.focus(); }


Form.FieldType = function( id, options )
{
  this.type = id;
  extend( this, options );
};


Form.FieldType.prototype = {

  getInputs: function() { const field = this;
    const elements = this.elm.querySelectorAll( this.inputSelector );
    elements.forEach( elm => field.inputs.push( elm ) );
  },

  getLabel: function() { let label = this.elm.getAttribute( 'aria-label' );
    if ( ! label ) { const elLbl = this.elm.querySelector( 'label' );
      if ( elLbl ) { label = elLbl.innerHTML; } else label = this.getName(); }
    return label || 'Field';
  },

  getName: function() { return this.input.name; },
  getValue: function() { const val = this.input.type === 'checkbox'
    ? ( this.input.checked ? this.input.value : '' ) : this.input.value;
    return val;
  },
  setValue: function( val ) { this.input.type === 'checkbox' ? this.input.checked = ( 
    this.input.value === val ) : this.input.value = val || ''; },
  getRequired: function() { return this.elm.classList.contains( 'required' ); },
  clearErrors: function() { clearErrors( this ) },
  clear: function() { this.setValue( '' ); },
  reset: function() { this.setValue( this.initialValue || '' ); },
  focus: function() { this.input ? this.input.focus() : null; },

  showErrors: function() {
    if ( !this.errors.length ) return;
    this.elm.classList.add( this.unhappyClass );
    if ( this.form.onlyShowSummary ) return;
    const elMsgs = document.createElement( 'div' );
    elMsgs.innerHTML = this.errors.map( e => '<div class="error">'+e.message+'</div>' ).join('');
    elMsgs.className = this.errorsClass;
    this.elm.appendChild( elMsgs );
  },

  validate: function( options ) {
    const validator = Form.Validators.Required;
    const valid = validator.test( this, options );
    if ( ! valid ) this.errors.push( new Form.Error( this,
      validator.getInvalidMessage( this, options ) ) );
    return valid;
  },

  inputSelector: 'input,textarea,select'

};


Form.Field = function( form, elm )
{
  this.elm = elm;
  this.type = '';
  this.form = form;
  this.inputs = [];
  this.errors = [];
  this.initialValue = '';
  this.inputSelector = 'input';
  this.errorsClass = form.errorsClass;
  this.unhappyClass = form.unhappyClass;
  const fieldTypeId = elm.getAttribute( 'data-type' );
  const fieldType = Form.FieldTypes[ fieldTypeId ];
  extend( this, fieldType || new Form.FieldType( 'Text' ) );
  if (this.beforeInit) this.beforeInit();
  this.getInputs(); this.input = this.inputs[0];
  if (this.afterInit) this.afterInit();
};


Form.Validator = function( id, test, getInvalidMessage )
{
  this.id = id;
  if ( test ) { this.test = test; }
  if ( getInvalidMessage ) { this.getInvalidMessage = getInvalidMessage; }
};


Form.Validator.prototype = {
  test: function( field, args ) { return true; },  
  getInvalidMessage: function( field, args ) { return field.getLabel() + ' is invalid'; }
};


Form.prototype = {

  addField: function( elm ) {
    this.fields.push( new Form.Field( this, elm ) ); },

  getFields: function() {
    const elements = this.elm.querySelectorAll( this.fieldSelector );
    elements.forEach( elm => this.addField( elm ) ); },

  getErrors: function() {
    const errors = [];
    this.fields.forEach( field => { if ( field.errors[0] ) 
      errors.push( field.errors[0] ); } );
    return errors;
  },

  showErrors: function() {
    const errors = [];
    this.elm.classList.add( this.unhappyClass );
    this.fields.forEach( field => { field.showErrors(); 
      if ( field.errors[0] ) errors.push( field.errors[0] ); } );
    const elMsgs = document.createElement( 'div' );
    elMsgs.className = this.errorsClass + ' ' + this.summaryClass;
    elMsgs.innerHTML = errors.map( e => '<div class="error">'+e.message+'</div>' ).join('');
    this.elm.insertBefore( elMsgs, this.elm.firstElementChild );
  },

  clearErrors: function() { clearErrors( this, '.' + this.summaryClass );
    this.fields.forEach( field => field.clearErrors() ); },

  validate: function( options ) { this.clearErrors();
    this.fields.forEach( field => field.validate( options ) ); },

  focus: function() { this.fields[0].focus(); },
  clear: function() { this.clearErrors(); this.fields.forEach( field => field.clear() ); },
  reset: function() { this.clearErrors(); this.fields.forEach( field => field.reset() ); },

  init: function( initialValues, nameSpace ) {
    this.fields.forEach( f => { const fname = f.getName(), fid = nameSpace
      ? fname.replace( `${nameSpace}[`, '' ).replace( ']', '' ) : fname;
      f.initialValue = initialValues ? initialValues[ fid ] || '' : f.getValue();
      if ( initialValues ) f.setValue( f.initialValue ); } );
  },

};

window.F1.Form = Form;

}( window, document ) );