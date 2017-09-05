import { IComponent } from '../../IComponent'

export class BasketItemsListComponent implements IComponent
{
	private __items: Array<IComponent>
	
	constructor( items: Array<IComponent> )
	{
		this.__items = items
	}
	
	private _renderItems(): string
	{
		return this.__items
			.map( item =>
				'<li>' + item.render() + '</li>' )
			.join( '' )
	}
	
	render()
	{
		let list = $( `<ul class="list-unstyled"></ul>` )
			.append( this.__items.map( item => item.render() ) )
		
		return list
	}
}