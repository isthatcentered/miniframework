import { FlashEventData, IFlashData } from './flash/entities'
import { User } from './users/entities'


class StoreSessionHandler
{
	
	private KEY_ALERTS = 'ALERTS'
	private KEY_USER = 'USER'
	private __storageHandler: Storage
	
	
	constructor( storageHandler: Storage )
	{
		this.__storageHandler = storageHandler
	}
	
	getAll(): object
	{
		return this.__storageHandler
	}
	
	getAlerts(): Array<IFlashData>
	{
		let alerts = JSON.parse( this.__storageHandler.getItem( this.KEY_ALERTS ) ) ||
			[]
		
		// At this point every item in store has been caught, lets reset the basket
		this.clearAlerts()
		
		return alerts || []
	}
	
	addAlert( alert: FlashEventData ): this
	{
		
		// Get existing alerts
		let _alerts = this.getAlerts()
		
		// Add new one
		_alerts.push( alert )
		
		// Set all again
		this.__storageHandler.setItem( this.KEY_ALERTS, JSON.stringify( _alerts ) )
		
		// Fluent
		return this
	}
	
	clearAlerts()
	{
		this.__storageHandler.setItem( this.KEY_ALERTS, JSON.stringify( [] ) )
	}
	
	setUser( user: User ): this
	{
		this.__storageHandler.setItem( this.KEY_USER, JSON.stringify( user ) )
		
		return this
	}
	
	getUser()
	{
		return this.__storageHandler.getItem( this.KEY_USER )
	}
	
	clearUser(): this
	{
		this.__storageHandler.setItem( this.KEY_USER, null )
		
		return this
	}
}

export default new StoreSessionHandler( window.sessionStorage )