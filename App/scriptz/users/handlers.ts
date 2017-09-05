import * as $ from 'jQuery'
import { USERS_EVENTS } from './events'
import { AppEvent } from '../AppEvent'
import { ACTION_EVENTS } from '../action/events'
import { ActionEventData } from '../action/entities'
import { FlashEventData } from '../flash/entities'
import { cLink } from '../components'
import { User } from './entities'
import StoreSessionHandler from '../StoreSessionHandler'

let body = $( 'body' )
body
// REGISTER ========================================================================
	.on( USERS_EVENTS.REGISTER.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let $form = AppEvent.getEventData( e )
		
		// Action authorize
		ACTION_EVENTS.AUTHORIZED.dispatch( new ActionEventData( {
			from:      $form,
			action:    {
				url:    API_URL + '/users',
				method: 'POST',
				data:   $form.serializeArray()
			},
			redirect:  APP_URL + '/',
			onSuccess: new FlashEventData( {
				type:    'success',
				message: 'Compte créé! ' + cLink( APP_URL + '/login', 'Se connecter?' )
			} )
		} ) )
	} )
	
	// LOG =============================================================================
	.on( USERS_EVENTS.LOG.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let user: User = AppEvent.getEventData( e )
		
		// Action authorize
		ACTION_EVENTS.AUTHORIZED.dispatch( new ActionEventData( {
			from:      user,
			action:    {
				url:    APP_URL + '/authenticate',
				method: 'POST',
				data:   user
			},
			redirect:  APP_URL + '/',
			onSuccess: new FlashEventData( {
				type:    'success',
				message: 'Loggé en tant que: "' + user.name + '"'
			} )
		} ) )
	} )
	
	// LOG =============================================================================
	.on( USERS_EVENTS.LOGOUT.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let eData = AppEvent.getEventData( e )
		
		// Store flash message
		StoreSessionHandler.addAlert( eData.message )
	} )

