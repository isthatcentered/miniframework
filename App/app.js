// Alerts ===================================================================
class Alert
{

	constructor( type, msg, link )
	{
		this.type = type
		this.msg = msg
		this.link = link
	}
}


// Components ===============================================================
let cAlert = ( type, msg ) =>
	$( '<div class="alert alert-' + type + '">' + msg + '</div>' )

let cLink = ( href, text, classes ) =>
	$( '<a href="' + href + '" class="' + classes + '">' + text + '</a>' )

