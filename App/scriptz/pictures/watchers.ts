import * as $ from 'jQuery'
import { EVENTS_PICTURES } from './events'
import { PictureAjaxUploadComponent } from './components/PictureAjaxUpload.component'

const $picturePostForm = $( '.js-picture-post' )

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
		
		$( this ).append( new PictureAjaxUploadComponent().render() )
	} )
