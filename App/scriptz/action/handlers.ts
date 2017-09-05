import * as $ from 'jQuery'
import { AppEvent } from '../AppEvent'
import { ActionEventData } from './entities'
import { EVENTS_FLASHS } from '../flash/events'
import { ACTION_EVENTS } from './events'
import StoreSessionHandler from '../StoreSessionHandler'

let body = $( 'body' )
body
// ASK =============================================================
	.on( ACTION_EVENTS.ASK.getType(), function ( e ) {
		
		let eData: ActionEventData = AppEvent.getEventData( e )
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		// Confirm action
		if ( confirm( eData.onConfirm.message ) )
			ACTION_EVENTS.AUTHORIZED.dispatch( eData ) // dispatch authorized
		else
			ACTION_EVENTS.CANCELED.dispatch( eData ) // Dispatch canceled
		
	} )
	
	// AUTHORIZED ======================================================
	.on( ACTION_EVENTS.AUTHORIZED.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let eData: ActionEventData = AppEvent.getEventData( e )
		
		// Make a call using event action congig
		$.ajax( eData.action )
			.done( data =>
				ACTION_EVENTS.SUCCESS.dispatch( eData ) )
			.fail( err => ACTION_EVENTS.ERROR.dispatch( err ) )
	} )
	
	// CANCELED ======================================================
	.on( ACTION_EVENTS.CANCELED.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let eData: ActionEventData = AppEvent.getEventData( e )
		
		EVENTS_FLASHS.NEW.dispatch( eData.onCancel )
	} )
	.on( ACTION_EVENTS.SUCCESS.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let eData: ActionEventData = AppEvent.getEventData( e )
		
		// If redirect,
		if ( eData.redirect ) {
			
			// Store alert for next page
			StoreSessionHandler.addAlert( eData.onSuccess )
			
			// redirect
			console.log( 'Redirecting to', eData.redirect )
			window.location.href = eData.redirect
		}
		
		// Else, display alert directly
		else
			EVENTS_FLASHS.NEW.dispatch( eData.onSuccess )
	} )
	.on( ACTION_EVENTS.ERROR.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let err = AppEvent.getEventData( e )
		
		EVENTS_FLASHS.NEW.dispatch( {
			type:    'danger',
			message: err.responseJSON.code + ': ' + err.responseJSON.message
		} )
	} )

