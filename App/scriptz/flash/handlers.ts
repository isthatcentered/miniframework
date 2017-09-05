import * as $ from 'jQuery'
import { EVENTS_FLASHS } from './events'
import { FlashEventData } from './entities'
import { AppEvent } from '../AppEvent'
import { cAlert } from '../components'

let body = $( 'body' )
body.on( EVENTS_FLASHS.NEW.getType(), function ( e ) {
	
	console.log( 'caught:', AppEvent.logEvent( e ) )
	
	let eData: FlashEventData = AppEvent.getEventData( e )
	
	body.prepend( cAlert( eData ) )
} )

