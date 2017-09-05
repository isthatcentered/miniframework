import * as jQuery from 'jquery'

export interface IComponent
{
	render: () => jQuery<Node>
}