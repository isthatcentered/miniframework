export interface IUserResource
{
	name: string
	password: string
	id: number
	admin: boolean
}

export class User
{
	
	name: string
	password: string
	id: number
	admin: boolean
	
	
	constructor( user: IUserResource )
	{
		this.name = user.name
		this.password = user.password
		this.id = user.id
		this.admin = user.admin
	}
}