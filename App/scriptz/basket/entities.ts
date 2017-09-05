import { Product } from '../products/entities'

export interface IBasketItem
{
	product: Product
	qty: number
}

export class BasketItem implements IBasketItem
{
	product: Product
	qty: number
	
	constructor( item: IBasketItem )
	{
		this.product = item.product
		this.qty = item.qty
	}
	
	getTotal(): number
	{
		return this.product.price * this.qty
	}
	
	getQty(): number
	{
		return this.qty
	}
	
	getPrice(): number
	{
		return this.product.price
	}
}