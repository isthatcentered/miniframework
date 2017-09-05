import * as $ from 'jQuery'
import { EVENTS_FLASHS } from '../flash/events'
import { FlashEventData, IFlashData } from '../flash/entities'
import { USERS_EVENTS } from './events'
import { IUserResource, User } from './entities'

$( 'form.js-auth-register' ).on( 'submit', function ( e ) {
	
	e.preventDefault()
	
	let $form        = $( this ),
	    formData     = $form.serializeArray(),
	    formUsername = formData[ 0 ].value,
	    formPassword = formData[ 1 ].value
	
	
	$.get( API_URL + '/users' )
		.done( ( users: Array<IUserResource> ) => {
			
			// There's already a guy with that name
			if ( users.some( ( user: IUserResource ) => user.name === formUsername ) )
				EVENTS_FLASHS.NEW.dispatch( new FlashEventData( {
					type:    'danger',
					message: 'A user with that username already exists'
				} ) )
			
			// None with that name, register the guy
			else
				USERS_EVENTS.REGISTER.dispatch( $form )
		} )
		.fail( err => EVENTS_FLASHS.NEW.dispatch( new FlashEventData( {
			type:    'danger',
			message: 'Something went wrong, please try again'
		} ) ) )
} )


$( 'form.js-auth-login' ).on( 'submit', function ( e ) {
	
	e.preventDefault()
	
	let $form        = $( this ),
	    formData     = $form.serializeArray(),
	    formUsername = formData[ 0 ].value,
	    formPassword = formData[ 1 ].value
	
	
	
	$.get( API_URL + '/users' )
		.done( ( users: Array<IUserResource> ) => {
			
			
			// Found  and pass matching ? redirect
			let match = users
				.filter( ( user: IUserResource ) =>
					user.name === formUsername && user.password === user.password )
			
			
			if ( match )
				USERS_EVENTS.LOG.dispatch( new User( match.pop() ) )
			
			// Found and pass not matching|| Not found => alert
			else
				EVENTS_FLASHS.NEW.dispatch( new FlashEventData( {
					type:    'danger',
					message: 'Mauvais email ou password'
				} ) )
		} )
		.fail( err => EVENTS_FLASHS.NEW.dispatch( new FlashEventData( {
			type:    'danger',
			message: 'Something went wrong, please try again'
		} ) ) )
} )

$( '.js-auth-logout' ).on( 'click', function ( e ) {
	
	e.preventDefault()
	
	USERS_EVENTS.LOGOUT.dispatch(
		{
			from:    $( this ),
			message: new FlashEventData( <IFlashData>{
				type:    'success',
				message: 'Déconnexion réussie'
			} )
		}
	)
	
	// Redirect
	window.location.href = APP_URL + '/logout'
} )