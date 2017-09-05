export interface IFlashData
{
	type: string
	message: string
	link?: string
	read?: boolean
}

export class FlashEventData
{
	
	type: string
	message: string
	link: string
	read: boolean = false
	
	constructor( data: IFlashData )
	{
		this.type = data.type
		this.message = data.message
		this.read = data.read || false
		this.link = data.link
	}
}