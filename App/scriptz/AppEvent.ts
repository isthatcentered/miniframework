import * as $ from 'jQuery'

export class AppEvent
{
	private __type: string
	
	constructor( type: string )
	{
		this.__type = type
	}
	
	getType(): string
	{
		return this.__type
	}
	
	dispatch( data: any )
	{
		console.log( 'triggered: ', { type: this.__type, data } )
		
		return $( 'body' ).trigger(
			$.Event( this.__type, { customData: data } )
		)
	}
	
	static getEventData( $e )
	{
		return $e.customData
	}
	
	static logEvent( $e )
	{
		
		return {
			type: $e.type,
			data: $e.customData
		}
	}
}