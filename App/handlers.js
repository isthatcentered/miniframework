body
// PRODUCTS ================================================================
	.on( EVENTS.PRODUCTS.NEW, function ( e ) {

		let { formData, form } = e.customData

		let { name, description, price } = arrToDictionnary( formData )

		// All necessary data passed
		if ( name && description && price )
			$.post( API_URL + API_ENDPOINTS.PRODUCTS, { name, description, price } )
				.done( ( data ) => {
					dispatchAlert(
						'success',
						'Success creating new product with id ' + '<br>' + '<a href="' + APP_URL + '/products/' + data.id + '" >Voir le produit</a>'
					)
					dispatch( EVENTS.FORM.SUCCESS, { form } )
				} )
				.fail( ( err ) => {
					dispatchAlert( 'danger', 'Failed while creating new product' )
					dispatch( EVENTS.FORM.ERROR, { form } )
				} )

		// Else trigger error message
		else {
			dispatchAlert( 'warning', 'All fields need to be filled' )
			dispatch( EVENTS.FORM.ERROR, { form } )
		}
	} )

	// FORMS ====================================================================
	.on( EVENTS.FORM.SUBMIT, function ( e ) {

		let { form } = e.customData,
			submit = form.find( 'button' )

		// Disable submit
		submit
			.prop( 'disabled', true )
			.addClass( 'loading' )

	} )
	.on( EVENTS.FORM.SUCCESS, function ( e ) {

		let { form } = e.customData

		clearForm( form )
	} )
	.on( EVENTS.FORM.ERROR, function ( e ) {

	} )
	.on( EVENTS.FORM.ERROR + ' ' + EVENTS.FORM.SUCCESS, function ( e ) {

		let { form } = e.customData,
			submit = form.find( 'button' )

		submit
			.prop( 'disabled', false )
			.removeClass( 'loading' )
	} )

	// ALERTS ====================================================================
	.on( EVENTS.ALERT.NEW, function ( e ) {

		let { type, msg } = e.customData

		body.prepend( cAlert( type, msg ) )
	} )

	// DELETE ====================================================================
	.on( EVENTS.DELETE.ASK, function ( e ) {

		// ALert, you sure
		if ( confirm( 'Are you sure about deleting this product' ) )
			dispatch( EVENTS.DELETE.CONFIRMED, e.customData )
		else
			dispatch( EVENTS.DELETE.CANCELED, e.customData )
	} )
	.on( EVENTS.DELETE.CONFIRMED, function ( e ) {

		let { action, link } = e.customData

		// Make a call to action,
		$.ajax( {
			url: action,
			method: 'DELETE'
		} )
			.done( ( data ) => dispatch( EVENTS.DELETE.SUCCESS, {
				data,
				msg: 'Produit supprimé, <a href="' + APP_URL + '/products' + '">Revenir aux produits?</a>'
			} ) )
			.fail( ( err ) => dispatch( EVENTS.DELETE.ERROR, { err } ) )
	} )
	.on( EVENTS.DELETE.CANCELED, function ( e ) {
		dispatchAlert( 'info', 'As asked, nothing was deleted' )
	} )
	.on( EVENTS.DELETE.SUCCESS, function ( e ) {

		let { data, msg } = e.customData

		dispatchAlert( 'success', msg )
	} )
	.on( EVENTS.DELETE.ERROR, function ( e ) {

		let { err } = e.customData

		dispatchAlert( 'danger', err.responseJSON.code + ': ' + err.responseJSON.message )
	} )