import { AppEvent } from '../AppEvent'

const EVENTS_BASKET = {
	POPULATE: new AppEvent( 'BASKET_POPULATE' ),
	ADD:      new AppEvent( 'BASKET_ADD' ),
	REMOVE:   new AppEvent( 'BASKET_REMOVE' ),
	CHECKOUT: new AppEvent( 'BASKET_CHECKOUT' )
}

export { EVENTS_BASKET }