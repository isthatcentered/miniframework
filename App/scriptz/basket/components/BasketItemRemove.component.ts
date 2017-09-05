import { IComponent } from '../../IComponent'
import { EVENTS_BASKET } from '../events'
import { IEventDataBasketRemove } from '../watchers'

export class BasketItemRemoveComponent implements IComponent
{
	private __productId: number
	
	constructor( productId: number )
	{
		this.__productId = productId
		
		// this.render = this.render.bind( this )
	}
	
	render()
	{
		let button = $( `<a href="#">X</a>` )
			.addClass('ml-1')
			.on( 'click', () => {
				EVENTS_BASKET.REMOVE.dispatch( <IEventDataBasketRemove>{
					from:      undefined,
					productId: this.__productId
				} )
			} )
		
		return button
	}
}