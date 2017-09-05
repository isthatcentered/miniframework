import { BasketItem } from '../entities'
import { IComponent } from '../../IComponent'
import { BasketItemRemoveComponent } from './BasketItemRemove.component'

export interface IBasketItemSingleComponentState
{
	item: BasketItem
}

export class BasketItemSingleComponent implements IComponent
{
	
	state: IBasketItemSingleComponentState = { item: null }
	
	constructor( item: BasketItem )
	{
		this.state.item = item
	}
	
	onDelClick()
	{
		console.log( 'Yeah' )
	}
	
	render()
	{
		let removeButton = new BasketItemRemoveComponent( this.state.item.product.id ).render(),
		    link         = $( ` <a href="${APP_URL}/products/${this.state.item.product.id}"> ${this.state.item.product.name} </a> ` ),
		    qty          = $( `<span>- x${this.state.item.getQty()}</span>` ),
		    total        = $( ` <span> ${this.state.item.getTotal()}€</span>` )
		
		return $( '<div></div>' )
			.append( link )
			.append( qty )
			.append( total )
			.append( removeButton )
	}
}