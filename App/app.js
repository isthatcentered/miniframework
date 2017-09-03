let body = $( 'body' )

const API_URL = APP_URL + '/api'

const API_ENDPOINTS = {
	PRODUCTS: '/products'
}

const EVENTS = {
	ALERT: {
		NEW: 'ALERT_NEW'
	},
	DELETE: {
		ASK: 'DELETE_ASK',
		CONFIRMED: 'DELETE_CONFIRMED',
		CANCELED: 'DELETE_CANCELED',
		SUCCESS: 'DELETE_SUCCESS',
		ERROR: 'DELETE_ERROR'
	},
	FORM: {
		SUBMIT: 'FORM_AJAX_SUBMIT',
		SUCCESS: 'FORM_AJAX_SUCCESS',
		ERROR: 'FORM_AJAX_ERROR'
	},
	PRODUCTS: {
		NEW: 'PRODUCT_POST',
		DELETE: {
			ASK: 'PRODUCT_DELETE_ASK',
			CONFIRMED: 'PRODUCT_DELETE_CONFIRMED',
			CANCELED: 'PRODUCT_DELETE_CANCELED'
		}
	}
}


// PRODUCTS ===============================================================
// Post
$( 'form.js-product-post' ).on( 'submit', function ( e ) {

	// Prevent page change
	e.preventDefault()

	// Dispatch event w+ data and let observers handle data
	dispatch( EVENTS.PRODUCTS.NEW, { formData: $( this ).serializeArray(), form: $( this ) } )

	dispatch( EVENTS.FORM.SUBMIT, { form: $( this ) } )
} )

// Delete
$( '.js-products-delete' ).on( 'click', function ( e ) {

	let $link = $( this ),
		id = $link.data( 'product-id' )

	// Prevent page change
	e.preventDefault()

	dispatch( EVENTS.DELETE.ASK, { from: $link, action: API_URL + API_ENDPOINTS.PRODUCTS + '/' + id } )
} )


// Alerts ===================================================================
class Alert
{

	constructor( type, msg, link )
	{
		this.type = type
		this.msg = msg
		this.link = link
	}
}


// Components ===============================================================
let cAlert = ( type, msg ) =>
	$( '<div class="alert alert-' + type + '">' + msg + '</div>' )

let cLink = ( href, text, classes ) =>
	$( '<a href="' + href + '" class="' + classes + '">' + text + '</a>' )

// Helpers ==================================================================
let arrToDictionnary = arr => arr.reduce( ( acc, item, ind ) => {
	return { ... acc, [item.name]: item.value }
}, {} )

let dispatch = ( eventName, data ) =>
	body.trigger(
		$.Event( eventName, { customData: data } )
	)

let dispatchAlert = ( type, msg ) =>
	dispatch( EVENTS.ALERT.NEW, new Alert( type, msg ) )

let clearForm = ( form ) =>
	form.find( 'input:not(input[type="submit"]), textarea' ).val( '' )