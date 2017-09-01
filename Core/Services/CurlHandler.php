<?php


namespace Core\Services;


class CurlHandler implements IRequestHandler
{
	
	public function get( string $url )
	{
		
		$req  = curl_init();
		
		curl_setopt( $req, CURLOPT_URL, $url );
		
		curl_setopt( $req, CURLOPT_RETURNTRANSFER, true );
		
//		var_dump( curl_getinfo( $req ) );
		
		return curl_exec( $req );
		
		return new RequestHandlerResponse();
	}
}