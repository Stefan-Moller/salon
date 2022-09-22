F1.Form.Validators = {

	Required: new F1.Form.Validator( 'Required',
	  function( field ) { if ( ! field.getRequired() ) return true; else return field.getValue() !== ''; },
	  function( field ) { return field.getLabel() + ' is required.'; }
	),

};