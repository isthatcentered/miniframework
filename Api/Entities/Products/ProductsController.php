<?php


namespace Api\Entities\Products;

use Api\Entities\Repository;
use Api\JsonErrorResponse;
use Api\JsonResponse;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class ProductsController
{
	/**
	 * @var Container
	 */
	private $container;
	
	
	public function __construct( Container $container )
	{
		$this -> container = $container;
	}
	
	public function indexAction( array $params )
	{
		/**
		 * @var \PDO $db
		 */
		$db = $this -> container -> get( 'database' );
		
		// Fetching all users
		$productsResource = $db
			-> query( "SELECT * FROM products" )
			-> fetchAll();
		
		// Mapping returned resource to a User object
		$products = array_map(
			function ( $product ) use ( &$products ) {
				
				return new Product( $product );
			},
			$productsResource );
		
		//	// Display
		//	// Create json response from node
		return new JsonResponse( $products );
	}
	
	
	public function singleAction( array $params )
	{
		
		
		/**
		 * @var PathHandler $pathHandler
		 */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$arg = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		// Get matching user
		/**
		 * @var \PDO $db
		 */
		$db = $this -> container -> get( 'database' );
		
		
		// Fetching all users
		$productResource = $db
			-> prepare( "SELECT * FROM products WHERE id = :id" );
		$productResource -> execute( [ 'id' => $arg ] );
		
		$p = $productResource -> fetch();
		
		if ( !$p )
			return new JsonErrorResponse( 'Sorry, this product might exist but definitly not in the database', 404 );
		
		
		return new JsonResponse( new Product( $p ) );
	}
	
	public function postAction()
	{
		/**
		 * @var \PDO $db
		 */
		$db = $this -> container -> get( 'database' );
		
		if ( !$_POST )
			return new JsonResponse(
				[ 'message' => 'If you want to post something, then submitting data might be useful', 'code' => 500 ],
				500
			);
		
		try {
			return new JsonResponse(
				[ 'id' => Repository ::insert( $db, 'products', $_POST ) ]
			);
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage(), 500 );
		}
	}
	
	public function deleteAction()
	{
		
		/**
		 * @var PathHandler $pathHandler
		 */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$arg = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		/**
		 * @var \PDO $db
		 */
		$db = $this -> container -> get( 'database' );
		
		$deletedRows = Repository ::delete( $db, 'products', $arg );
		
		
		if ( !$arg || !$deletedRows )
			return new JsonErrorResponse( 'If you want me to kill someone, please provide a valid id', 404 );
		
		return new JsonResponse( [ 'success' => true ] );
	}
}