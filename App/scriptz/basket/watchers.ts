// Elements that will trigger an event on basket
import * as $ from 'jQuery'
import { EVENTS_BASKET } from './events'
import { Product } from '../products/entities'


export interface IEventData
{
	from: any
}

export interface IEventDataBasketAdd extends IEventData
{
	product: Product,
	from: any
}

export interface IEventDataBasketRemove extends IEventData
{
	productId: number,
	from: any
}

const $addToBasketButton      = $( '.js-basket-add' ),
      $removeFromBasketButton = $( '.js-basket-remove' )

$addToBasketButton
	.on( 'click', function ( e ) {
		
		e.preventDefault()
		
		let $from   = $( this ),
		    product = new Product( $from.data( 'product' ) )
		
		// Dispatch add product event
		EVENTS_BASKET.ADD.dispatch( <IEventDataBasketAdd>{
			from: $from,
			product
		} )
	} )


$removeFromBasketButton
	.on( 'click', function ( e ) {
		e.preventDefault()
		
		let $from     = $( this ),
		    productId = +$from.data( 'productId' )
		
		// Dispatch remove product event
		EVENTS_BASKET.REMOVE.dispatch( <IEventDataBasketRemove>{
			from: $from,
			productId
		} )
	} )
