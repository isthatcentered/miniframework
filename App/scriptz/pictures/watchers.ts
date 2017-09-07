import * as $ from 'jQuery'
import { EVENTS_PICTURES } from './events'
import { PictureAjaxUploadComponent } from './components/PictureAjaxUpload.component'

const $picturePostForm             = $( '.js-picture-post' ),
      $pictureAddDynamicFormButton = $( '.js-picture-add-form' )

export interface IEventDataPicturePost
{
	from: any,
	data: FormData
}

$picturePostForm
	.on( 'submit', function ( e ) {
		
		e.preventDefault()
		
		let $form = $( this ),
		    data  = new FormData( this )
		
		EVENTS_PICTURES.POST.dispatch( <IEventDataPicturePost>{
			from: $form,
			data
		} )
		
	} )

$pictureAddDynamicFormButton
	.on( 'click', function ( e ) {
		
		$( this )
			.wrap( `<div></div>` ) // @todo: This is gonna do nasty stuff in markup when multiple inputs
			.parent()
			.prepend( new PictureAjaxUploadComponent().render() )
		
	} )