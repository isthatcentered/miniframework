import { AppEvent } from '../AppEvent'

const ACTION_EVENTS = {
	ASK:       new AppEvent( 'ACTION_ASK' ),
	AUTHORIZED: new AppEvent( 'ACTION_AUTHORIZE' ),
	CANCELED:    new AppEvent( 'ACTION_CANCEL' ),
	SUCCESS:   new AppEvent( 'ACTION_SUCCESS' ),
	ERROR:     new AppEvent( 'ACTION_ERROR' )
}

export { ACTION_EVENTS }