import { FlashEventData } from '../flash/entities'

export interface IAjaxAction
{
	url: string
	method: string // 'GET', 'POST'
	data?
	contentType?: string|boolean
	processData?:  boolean
	beforeSend: any
	
}

export interface IActionEvent
{
	from // Element action was instantiated on
	action: JQueryAjaxSettings // link to call when action confirmed
	redirect?: string
	onSuccess?: FlashEventData
	onError?: FlashEventData
	onCancel?: FlashEventData
	onConfirm?: FlashEventData
}

export class ActionEventData implements IActionEvent
{
	
	from // Element action was instantiated on
	action: JQueryAjaxSettings // link to call when action confirmed
	redirect?: string
	onSuccess?: FlashEventData
	onError?: FlashEventData
	onCancel?: FlashEventData
	onConfirm?: FlashEventData
	
	constructor( config: IActionEvent )
	{
		this.from = config.from
		this.action = config.action
		this.redirect = config.redirect
		this.onSuccess = config.onSuccess || new FlashEventData( { type: 'success', message: 'Success!' } )
		this.onError = config.onError || new FlashEventData( { type: 'error', message: 'Something went wrong!' } )
		this.onCancel = config.onCancel || new FlashEventData( {
			type:    'success',
			message: 'As you please, action cancelled'
		} )
		this.onConfirm = config.onConfirm || new FlashEventData( { type: 'success', message: 'Are you sure?' } )
	}
}