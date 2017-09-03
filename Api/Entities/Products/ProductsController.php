<?php


namespace Api\Entities\Products;

use Api\ApiController;
use Api\Exceptions\ItemNotFoundException;
use Api\JsonErrorResponse;
use Api\JsonResponse;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class ProductsController extends ApiController
{
	
	public function __construct( Container $container )
	{
		parent ::__construct( 'products', Product::class, $container );
	}
	
	
	public function indexAction( array $params )
	{
		try {
			
			$resources = $this -> listAll( $this -> __table );
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage() );
		}
		
		return new JsonResponse( $resources );
	}
	
	
	public function singleAction( array $params )
	{
		
		/**
		 * @var PathHandler $pathHandler
		 */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		try {
			
			$u = $this -> show( $this -> __table, $id );
		} catch ( ItemNotFoundException $e ) {
			
			return new JsonErrorResponse( 'Sorry, this guy might exist but definitly not in the database', 404 );
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage(), 500 );
		}
		
		return new JsonResponse( $u );
	}
}