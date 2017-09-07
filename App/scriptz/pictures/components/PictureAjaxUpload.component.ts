import { IComponent } from '../../IComponent'
import { LoaderComponent } from '../../components/Loader.component'
import AjaxSettings = JQuery.AjaxSettings


export interface IPictureResource
{
	id: number
	url: string
	alt?: string
}

class Picture implements IPictureResource
{
	id: number
	url: string
	alt: string
	
	constructor( picture: IPictureResource )
	{
		this.id = picture.id
		this.url = picture.url
		this.alt = picture.alt
	}
}

export class PictureAjaxUploadedComponent implements IComponent
{
	state = { picture: <Picture>{} }
	template
	
	constructor( picture: Picture )
	{
		this.state.picture = picture
		this.onDeleteClick = this.onDeleteClick.bind( this )
	}
	
	onDeleteClick( e )
	{
		e.preventDefault()
		this.template.empty().attr( 'class', '' ).append( new PictureAjaxUploadComponent().render() )
	}
	
	render()
	{
		let url = APP_URL + '/public/uploads/images/' + this.state.picture.url
		this.template = $( `
			<div class="media d-flex align-items-center thumbnail mb-3">
				<img class="mr-3" src="${url}" alt="${this.state.picture.alt}" style="max-height: 80px;">
				<div class="media-body">
					<p class="mb-0">${this.state.picture.url} - ${this.state.picture.id}</p>
					<a href="#" class="js-picture-delete" data-picture="${this.state.picture.id}">Supprimer</a>
				</div>
			</div>
		` )
		
		this.template.find( '.js-picture-delete' )
			.on( 'click', this.onDeleteClick )
		
		return this.template
	}
}



export class PictureAjaxUploadComponent implements IComponent
{
	private __productId: number
	
	constructor( productId: number )
	{
		this.__productId = productId
	}
	
	onFileChosen( e )
	{
		let form  = e.delegateTarget,
		    $form = $( form ),
		    $wrapper
		
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
				
				$wrapper = $form
					.wrap( '<div></div>' )
					.parent()
				
				$wrapper.append( new LoaderComponent().render() )
				
				$form.remove()
			}
		}
		
		$.ajax( c )
			.done( ( data: Picture ) => {
				
				console.log( 'data', data )
				
				// Just gives a little time tu understand what is happening in view
				setTimeout( () =>
					$wrapper
						.empty()
						.append( new PictureAjaxUploadedComponent( data ).render() ), 1500 )
				
			} )
			.fail( err => console.log( err ) )
	}
	
	render()
	{
		
		let $form           = $( `<form ></form>` )
			    .prop( 'action', API_URL + '/pictures' )
			    .prop( 'method', 'post' )
			    .prop( 'enctype', 'multipart/form-data' )
			    .addClass( 'js-picture-post mb-3' )
			    .on( 'change', this.onFileChosen ),
		    $fileInput      = $( `<input type="file" name="image">` ),
		    $productIdInput = $( `<input hidden type="number" name="productId" value="${this.__productId || -1}"/>` )
		
		return $form
			.append( $fileInput )
			.append( $productIdInput )
	}
}