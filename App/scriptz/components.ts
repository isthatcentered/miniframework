import { FlashEventData } from './flash/entities'

const cAlert = ( data: FlashEventData ) =>
	'<div class="alert alert-' + data.type + '">' + data.message + '</div>'

const cLink = ( href: string, text: string, classes?: string ) =>
	'<a href="' + href + '" class="' + classes + '">' + text + '</a>'

export { cAlert, cLink }