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
		let button = $( `<a class="text-secondary -underline" href="#">Enlever</a>` )
			.on( 'click', () => {
				EVENTS_BASKET.REMOVE.dispatch( <IEventDataBasketRemove>{
					from:      undefined,
					productId: this.__productId
				} )
			} )
		
		return button
	}
}