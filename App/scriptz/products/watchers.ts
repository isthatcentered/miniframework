import * as $ from 'jQuery'
import { ActionEventData } from '../action/entities'
import { ACTION_EVENTS } from '../action/events'
import { FlashEventData } from '../flash/entities'
import { cLink } from '../components'


// Delete ======================================================================
$( '.js-products-delete' ).on( 'click', function ( e ) {
	
	let $link = $( this ),
	    id    = $link.data( 'product-id' )
	
	// Prevent page change
	e.preventDefault()
	
	const eventData = new ActionEventData( {
		from:      $link,
		action:    {
			url:    API_ENDPOINTS.PRODUCTS + '/' + id,
			method: 'DELETE'
		},
		onSuccess: new FlashEventData( {
			type:    'success',
			message: 'Success, product with id: ' + id + ' deleted, <br/>' + cLink( APP_ADMIN_URL + '/products', 'Back to products?' )
		} )
	} )
	
	// Request an action
	return ACTION_EVENTS.ASK.dispatch( eventData )
} )

// Post ======================================================================
$( 'form.js-product-post' ).on( 'submit', function ( e ) {
	
	let $form = $( this )
	
	// Prevent page change
	e.preventDefault()
	
	// Instantiate new post action
	const eventData = new ActionEventData( {
		from:      $form,
		action:    {
			url:    API_ENDPOINTS.PRODUCTS,
			method: 'POST',
			data:   $form.serializeArray()
		},
		onSuccess: new FlashEventData( {
			type:    'success',
			message: 'Success, product created! <br/>' + cLink( APP_ADMIN_URL + '/products', 'Back to products?' )
		} )
	} )
	
	// Request an action
	return ACTION_EVENTS.AUTHORIZED.dispatch( eventData )
} )
