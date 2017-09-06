import { AppEvent } from '../AppEvent'

const EVENTS_PICTURES = {
	POST:       new AppEvent( 'PRODUCT_POST' ),
	POST_QUIET: new AppEvent( 'PRODUCT_POST_QUIET' ),
	DELETE:     new AppEvent( 'PRODUCT_DELETE' ),
	FETCH:      new AppEvent( 'PRODUCT_FETCH' )
}

export { EVENTS_PICTURES }