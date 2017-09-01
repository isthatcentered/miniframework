<?php


namespace Api;


use Api\JsonResponse;

class JsonErrorResponse extends JsonResponse
{
	
	
	public function __construct( string $err, int $code = 500)
	{
		parent ::__construct(
			[ 'message' => $err, 'code' => $code ],
			$code
		);
	}
}