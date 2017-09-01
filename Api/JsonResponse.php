<?php


namespace Api;


class JsonResponse extends Response
{
	public function __construct( $content, $status = 200) {
		parent ::__construct( json_encode($content), $status, 'application/json' );
	}
	
	public function setContent( $content )
	{
		return parent ::setContent( json_encode($content) );
	}
}