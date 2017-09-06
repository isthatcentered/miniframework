import { IComponent } from '../../IComponent'
import AjaxSettings = JQuery.AjaxSettings

export class PictureAjaxUploadComponent implements IComponent
{
	
	onFileChosen( e )
	{
		let form  = e.delegateTarget,
		    $form = $( form )
		console.log( form )
		// Get formData
		
		// dispatch picture post quiet
		// Config new post action
		const c: AjaxSettings = {
			method:      $form.prop( 'method' ).toUpperCase(),
			url:         $form.prop( 'action' ),
			data:        new FormData( form ),
			contentType: false, // required for this shit to work // @todo: find out why
			processData: false, // required for this shit to work // @todo: find out why
			// cache:       false,
			beforeSend:  function ( req, settings ) {
				console.log( 'BEFORE' )
			}
		}
		
		$.ajax( c )
		// .done()
		// .fail()
		
		
		
		console.log( 'changed' )
		console.log( $( this ) )
		
		
		// Upload
		// On pre
		// replace input w/ img
	}
	
	render()
	{
		
		let $form      = $( `<form></form>` )
			    .prop( 'action', API_URL + '/pictures' )
			    .prop( 'method', 'post' )
			    .prop( 'enctype', 'multipart/form-data' )
			    .addClass( 'js-picture-post' )
			    .on( 'change', this.onFileChosen ),
		    $fileInput = $( `<input type="file" name="image">` )
		
		$form.append( $fileInput )
		
		return $form
	}
}