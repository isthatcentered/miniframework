import { AppEvent } from '../AppEvent'

const EVENTS_PICTURES = {
	POST:       new AppEvent( 'PICTURE_POST' ),
	POST_QUIET: new AppEvent( 'PICTURE_POST_QUIET' ),
	DELETE:     new AppEvent( 'PICTURE_DELETE' ),
	FETCH:      new AppEvent( 'PICTURE_FETCH' )
}

export { EVENTS_PICTURES }