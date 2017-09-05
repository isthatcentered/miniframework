import { IComponent } from '../../IComponent'

interface IBasketTotalComponentState
{
	total: number
}

export class BasketTotalComponent implements IComponent
{
	state: IBasketTotalComponentState = { total: 0 }
	
	constructor( total: number )
	{
		this.state.total = total
	}
	
	render()
	{
		return $( ` <div class="mb-3">Total: ${this.state.total}€</div> ` )
	}
}