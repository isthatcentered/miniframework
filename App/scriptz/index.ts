import * as $ from 'jQuery'
import './products/index.ts'
import './action/index.ts'
import './flash/index.ts'
import './users/index.ts'
import './basket/index.ts'
import './pictures/index.ts'
import StoreSessionHandler from './StoreSessionHandler'
import { EVENTS_FLASHS } from './flash/events'
import { EVENTS_BASKET } from './basket/events'

let body = $( 'body' )

// Display all cached alerts (ex stored for a redirect
StoreSessionHandler.getAlerts().forEach( alert =>
	EVENTS_FLASHS.NEW.dispatch( alert ) )

EVENTS_BASKET.POPULATE.dispatch( null )


// Helpers ==================================================================
let arrToDictionnary = arr => arr.reduce( ( acc, item, ind ) => {
	return { ...acc, [item.name]: item.value }
}, {} )

// let dispatch = ( eventName, data ) => {
// 	console.log( eventName )
// 	return body.trigger(
// 		$.Event( eventName, { customData: data } )
// 	)
// }
//
// let dispatchAlert = ( type, msg ) =>
// 	dispatch( EVENTS.ALERT.NEW, new Alert( type, msg ) )

// let clearForm = ( form ) =>
// 	form.find( 'input:not(input[type="submit"]), textarea' ).val( '' )

