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



