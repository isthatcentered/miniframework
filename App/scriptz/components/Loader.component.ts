import { IComponent } from '../IComponent'

export class LoaderComponent implements IComponent
{
	render()
	{
		return $( `<img class="app-loader" src="${APP_URL}/public/images/loader.gif" />` )
	}
}