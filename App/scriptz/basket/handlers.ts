import * as $ from 'jQuery'
import { EVENTS_BASKET } from './events'
import { AppEvent } from '../AppEvent'
import BasketBag from './BasketBag'
import { BasketItem } from './entities'
import { BasketItemSingleComponent } from './components/BasketItemSingle.component'
import { BasketItemsListComponent } from './components/BasketItemsList.component'
import { IEventDataBasketAdd, IEventDataBasketRemove } from './watchers'
import { BasketTotalComponent } from './components/BasketTotal.component'

let body   = $( 'body' ),
    basket = $( '#basket' )

body
	.on( EVENTS_BASKET.POPULATE.getType(), function ( e ) {
		
		let eData = AppEvent.getEventData( e )
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		let _products = BasketBag.getAll()
			    .map( item => new BasketItem( item ) ),
		    _price    = _products.reduce( ( acc, item, arr ) => acc + item.getTotal(), 0 )
		
		
		
		basket.empty()
			.prepend( '<a href="#">Checkout</a>' )
			.prepend( new BasketTotalComponent( _price ).render() )
			.prepend(
				new BasketItemsListComponent(
					_products.map( item =>
						new BasketItemSingleComponent( item ) ) )
					.render() )
		
		
		
	} )
	.on( EVENTS_BASKET.ADD.getType(), function ( e ) {
		
		let eData: IEventDataBasketAdd = AppEvent.getEventData( e )
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		// Add product to basket
		BasketBag.add( eData.product )
		
		EVENTS_BASKET.POPULATE.dispatch( null )
	} )
	.on( EVENTS_BASKET.REMOVE.getType(), function ( e ) {
		
		let eData: IEventDataBasketRemove = AppEvent.getEventData( e )
		
		console.log( 'caught:', AppEvent.logEvent( e ) )
		
		// Add product to basket
		BasketBag.remove( eData.productId )
		
		EVENTS_BASKET.POPULATE.dispatch( null )
	} )