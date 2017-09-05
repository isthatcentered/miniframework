import { AppEvent } from '../AppEvent'

const PRODUCTS_EVENTS = {
	DELETE: new AppEvent( 'PRODUCT_DELETE' ),
	POST:   new AppEvent( 'PRODUCT_POST' ),
	UPDATE: new AppEvent( 'PRODUCT_UPDATE' ),
	FETCH:  new AppEvent( 'PRODUCT_FETCH' )
}

export { PRODUCTS_EVENTS }