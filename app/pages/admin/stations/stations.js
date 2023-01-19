/* globals F1 */

/* View Specific JS */

import Form from './js/vendors/f1js/form.js';
import Modal from './js/vendors/f1js/modal.js';
import Select from './js/vendors/f1js/select.js';
import fieldTypes from './js/vendors/f1js/form__fieldtypes.js';
import validatorTypes from './js/vendors/f1js/form__validatortypes.js';


F1.deferred.push(function initPage() {

  console.log( '[Stations Page Controller] Says Hi!' );


  /* Global Variable Aliases */

  const baseUrl = F1.pageHref;


  /* Global Service Aliases */

  const log = console.log;
  const logError = console.error;
  const urlParams = new URLSearchParams( window.location.search );

  function reduceData( data, use ) { 
    return use.reduce( (o, k) => { o[k] = data[k]; return o; }, {} );
  }

  function makeRow( data ) {
    const use = [ 'id', 'no', 'name', 'therapist', 'colour', 'notes' ];
    const viewData = reduceData( data, use );
    const rowTemplate = elRowTemplate.innerHTML;
    const elTempRowContainer = document.createElement( 'div' );
    elTempRowContainer.innerHTML = renderHtmlTemplate( rowTemplate, viewData );
    const elRow = elTempRowContainer.firstElementChild;
    const elDelete = elRow.querySelector( '.button-delete' );
    elDelete.classList.toggle( 'hidden', ! elToggleDelete.checked );
    return elRow;
  }

  function findRow( id ) {
    return document.getElementById( 'row-' + id );
  }

  function addListRow( data ) {
    log( 'addListRow', { data } );
    const elRow = makeRow( data );
    elList.querySelector( '.list-body' ).append( elRow );
  }

  function updateListRow( data ) {
    log( 'updateListRow', { data } );
    const elNewRow = makeRow( data );
    const elRow = findRow( data.id );
    elRow.innerHTML = elNewRow.innerHTML;
  }

  function removeListRow( id ) {
    log( 'removeListRow', { id } );    
    const elRow = findRow( id );
    elRow.remove();
  }

  function updateModalAfterShow( modalCtrl ) {
    const elSubmit = modalCtrl.elm.querySelector( 'footer button' );
    elSubmit.innerHTML = modalCtrl.title === 'Edit Station' ? 'Save' : 'Submit';
  }

  function showLoadingIndicator() {
    log( 'showLoadingIndicator' );
    document.documentElement.classList.add( 'loading' );
  }

  function hideLoadingIndicator() {
    log( 'hideLoadingIndicator' );
    document.documentElement.classList.remove( 'loading' );
  }

  function renderHtmlTemplate( htmlTemplate, data ) {
    log( 'renderHtmlTemplate', { htmlTemplate, data } );
    let html = htmlTemplate;
    for ( const propName in data ) {
      log( 'propName =', propName );
      const regex = new RegExp( '\\[data\\.' + propName + '\\]', 'g' );
      html = html.replace( regex, data[ propName ] );
    }
    log( 'renderHtmlTemplate', { html } );
    return html;
  }

  function mountErrorSummary( formCtrl, elSummary ) {
    formCtrl.elm.parentElement.insertBefore( elSummary, formCtrl.elm );
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

  function fetchItem( id, onSuccess ) {
    log( 'fetchItem' );
    ajaxFetch( baseUrl + '?do=getStation&id=' + id, onSuccess );
  }

  function fetchItemSuccess( item ) {
    log( 'fetchItemSuccess', item );
    const afterShow = updateModalAfterShow;
    modalCtrl_editForm.show( { data: item, title: 'Edit Station', afterShow } ); 
    hideLoadingIndicator();
  }

  function saveStation( station ) {
    log( 'saveStation', station );
    const formData = new FormData( elEditForm ).entries();
    const postData = { __action__: 'save', ...Object.fromEntries( formData ) };
    ajaxSubmit( baseUrl, postData, saveResp => saveStationDone( saveResp, station ) );
  }

  function saveStationDone( savedResp, station ) {
    log( 'saveStationDone', savedResp );
    if ( savedResp.error ) {
      const errors = [];
      logError( 'saveStationDone', savedResp.error );
      formCtrl_editForm.addFormError( savedResp.error );
      formCtrl_editForm.showErrors();
      return hideLoadingIndicator();
    }
    modalCtrl_editForm.close();
    const savedStation = savedResp;
    if ( station.id ) updateListRow( savedStation );
    else addListRow( savedStation );
    hideLoadingIndicator();
  }

  function deleteStation( id ) {
    log( 'deleteStation', id );
    const postData = { __action__: 'delete', id };
    ajaxSubmit( baseUrl, postData, deleteStationDone );    
  }

  function deleteStationDone( deleteResp ) {
    log( 'deleteStationDone', deleteResp );
    if ( deleteResp.error ) {
      const errors = [];
      logError( 'deleteStationDone', deleteResp.error );
      alert( deleteResp.error );
      return hideLoadingIndicator();
    }
    removeListRow( deleteResp.id );
    hideLoadingIndicator();    
  }


  /* Global Event Handlers */

  F1.onEdit = function( event, id ) {
    log( 'onEdit', event, id );
    fetchItem( id, fetchItemSuccess );
  };
  
  F1.onDelete = function( event, id ) {
    log( 'onDelete', event, id );
    if ( confirm( 'DELETE this station... Are you sure?' ) )
      deleteStation( id );
  };

  F1.onAddNew = function( event, id ) {
    log( 'onEdit', event, id );
    const newStationBase = { elm: undefined };
    modalCtrl_editForm.show( { data: newStationBase, title: 'Add Station' } ); 
  };

  F1.onSubmit = function( event, id ) {
    log( 'onSubmit', event, id );
    event.preventDefault();
    if ( ! formCtrl_editForm.validate() ) {
      const fieldErrors = formCtrl_editForm.showErrors();
      log( 'onSubmit, fieldErrors:', fieldErrors );
      return fieldErrors[0].focus();
    } 
    saveStation( modalCtrl_editForm.ENTITY );
  };

  F1.onToggleShowDelete = function( event ) {
    log( 'onToggleShowDelete', event );
    const deleteButtons = elList.querySelectorAll( '.button-delete' );
    deleteButtons.forEach( elBtn => elBtn.classList.toggle( 'hidden' ) );
  };


  /* Init */

  function initEditForm() {
    log( 'initEditForm' );
    const showErrorSummary = true;
    /* const afterInit = () => {}; */
    return new Form({ elm: elEditForm, fieldTypes, validatorTypes,
      /* afterInit ,*/ showErrorSummary, mountErrorSummary });
  }

  function initEditModal() {
    return new Modal( { elm: elEditModal,
      formController: formCtrl_editForm,
      focusFormOnShow: 1  } );
  }


  /* Debugging */

  function stashDebugInfo() {
    log( 'stashDebugInfo, Mainly for debugging :::)' );
    /* Components */
    F1.components.elList = elList;
    F1.components.elHeader = elHeader;
    F1.components.elEditModal = elEditModal;
    /* Controllers */
    F1.controllers.formCtrl_editForm = formCtrl_editForm;
    F1.controllers.modalCtrl_editForm = modalCtrl_editForm;
    formCtrl_editForm.fields.forEach( field => { if ( field.controller.name ) 
      F1.controllers[ field.controller.name ] = field.controller; } ); 
  }

  Object.assign( F1, { Modal, Form, Select, fieldTypes, validatorTypes } );



  /* ------- *
   *  Start  *
   * ------- */

  const elHeader = document.getElementById( 'main-header' );
  const elList = document.getElementById( 'stations-list' );
  const elEditModal = document.getElementById( 'edit-modal' );
  const elEditForm  = elEditModal.querySelector( 'form ' );
  const elRowTemplate = document.getElementById( 'row-template' );
  const elToggleDelete = document.getElementById( 'tsd-switch' );

  const formCtrl_editForm = initEditForm();
  const modalCtrl_editForm = initEditModal();

  stashDebugInfo();

});