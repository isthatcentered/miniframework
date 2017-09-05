import { BasketItem } from './entities'
import { Product } from '../products/entities'

class BasketBag
{
	
	private KEY_BASKET = 'BASKET'
	private __storageHandler: Storage
	
	
	constructor( storageHandler: Storage )
	{
		this.__storageHandler = storageHandler
	}
	
	// Get all
	getAll(): Array<BasketItem>
	{
		return JSON.parse( this.__storageHandler.getItem( this.KEY_BASKET ) ) ||
			[]
	}
	
	setAll( products: Array<BasketItem> ): this
	{
		
		this.__storageHandler.setItem( this.KEY_BASKET, JSON.stringify( products ) )
		
		return this
	}
	
	has( id: number ): boolean
	{
		return this.getAll()
			.some( item => item.product.id === id )
	}
	
	private _getIndex( id: number ): number
	{
		let items = this.getAll(),
		    match = items
			    .filter( item => item.product.id === id )[ 0 ]
		
		return items.indexOf( match )
	}
	
	/**
	 * Add a product to basket store
	 * Quantity is computed automatically
	 *
	 * @param {Product} product
	 * @returns this
	 */
	add( product: Product ): this
	{
		if ( !product )
			return this
		
		let _products = this.getAll()
		
		if ( this.has( product.id ) ) {
			
			let matchInd = this._getIndex( product.id ),
			    match    = this.getAll()[ matchInd ]
			
			_products[ matchInd ] = new BasketItem( { qty: (match.qty + 1), product: match.product } )
		}
		else
			_products.push( new BasketItem( <BasketItem>{ qty: 1, product } ) )
		
		this.setAll( _products )
		
		return this
	}
	
	
	remove( id: number ): this
	{
		if ( id === undefined )
			return this
		
		let _products = this.getAll(),
		    matchInd  = this._getIndex( id ),
		    match     = this.getAll()[ matchInd ]
		
		if ( match && match.qty > 1 )
			_products[ matchInd ].qty = _products[ matchInd ].qty - 1
		else
			_products = _products.filter( item => item.product.id !== id )
		
		this.setAll( _products )
		
		return this
	}
	
	clear(): this
	{
		this.setAll( [] )
		
		return this
	}
}

export default new BasketBag( window.sessionStorage )