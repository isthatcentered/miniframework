export interface IProductResource
{
	id: number
	name: string
	description: string
	price: number
}

export class Product implements IProductResource {
	
	id: number
	name: string
	description: string
	price: number
	
	constructor( product: IProductResource ) {
		
		this.id = +product.id
		this.name = product.name
		this.description = product.description
		this.price = +product.price
	}
}

