import * as $ from 'jQuery'
import { PRODUCTS_EVENTS } from './events'

let body = $( 'body' )
body.on( PRODUCTS_EVENTS.DELETE.getType(), function ( e ) {

} )

