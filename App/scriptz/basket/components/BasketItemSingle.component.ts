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
	
	render()
	{
		let tpl = $( `
			<div class="media mb-3">
				<div class="media-body mr-2">
					<a href="${APP_URL}/products/${this.state.item.product.id}">${this.state.item.getQty()}x ${this.state.item.product.name} </a>
					<br>
				</div>
				<div class="media-right">
					<span class="text-muted">${this.state.item.getTotal()}€</span>
				</div>
			</div>
		` )
		
		tpl
			.find( '.media-body' )
			.append( new BasketItemRemoveComponent( this.state.item.product.id ).render() )
		
		return tpl
	}
}