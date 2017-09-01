<?php


namespace Api\Entities\Categories;


use Api\JsonErrorResponse;
use Api\JsonResponse;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class CategoriesController
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
		$categoriesResource = $db
			-> query( "SELECT * FROM categories" )
			-> fetchAll();
		
		// Mapping returned resource to a User object
		$categories = array_map(
			function ( $category ) use ( &$categories ) {
				
				return new Category( $category );
			},
			$categoriesResource );
		
		//	// Display
		//	// Create json response from node
		return new JsonResponse( $categories );
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
		$categoryResource = $db
			-> prepare( "SELECT * FROM categories WHERE id = :id" );
		$categoryResource -> execute( [ 'id' => $arg ] );
		
		$p = $categoryResource -> fetch();
		
		if ( !$p )
			return new JsonErrorResponse( 'Sorry, this product might exist but definitly not in the database', 404 );
		
		
		return new JsonResponse( new Category($p) );
	}
}