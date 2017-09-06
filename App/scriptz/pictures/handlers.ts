import * as $ from 'jQuery'
import { EVENTS_PICTURES } from './events'
import { AppEvent } from '../AppEvent'
import { IEventDataPicturePost } from './watchers'
import { ActionEventData, IAjaxAction } from '../action/entities'
import { FlashEventData } from '../flash/entities'
import { ACTION_EVENTS } from '../action/events'

$( 'body' )
	.on( EVENTS_PICTURES.POST.getType(), function ( e ) {
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let eData: IEventDataPicturePost = AppEvent.getEventData( e )
		
		
		// Config new post action
		const c: IAjaxAction = {
			method:      eData.from.prop( 'method' ).toUpperCase(),
			url:         eData.from.prop( 'action' ),
			data:        eData.data,
			contentType: false, // required for this shit to work // @todo: find out why
			processData: false // required for this shit to work // @todo: find out why
			// cache:       false,
		}
		
		// Dispatch post action
		const eventData = new ActionEventData( {
			from:      eData.from,
			action:    c,
			onSuccess: new FlashEventData( {
				type:    'success',
				message: 'Success, image created!'
			} )
		} )
		
		// Request an action
		return ACTION_EVENTS.AUTHORIZED.dispatch( eventData )
	} )
	