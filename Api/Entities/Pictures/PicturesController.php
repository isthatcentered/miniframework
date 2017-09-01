<?php


namespace Api\Entities\Pictures;


use Api\JsonErrorResponse;
use Api\JsonResponse;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class PicturesController
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
		$picturesResource = $db
			-> query( "SELECT * FROM pictures" )
			-> fetchAll();
		
		// Mapping returned resource to a User object
		$pictures = array_map(
			function ( $picture ) use ( &$pictures ) {
				
				return new Picture( $picture );
			},
			$picturesResource );
		
		//	// Display
		//	// Create json response from node
		return new JsonResponse( $pictures );
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
		$pictureResource = $db
			-> prepare( "SELECT * FROM pictures WHERE id = :id" );
		$pictureResource -> execute( [ 'id' => $arg ] );
		
		$p = $pictureResource -> fetch();
		
		if ( !$p )
			return new JsonErrorResponse( 'Sorry, this product might exist but definitly not in the database', 404 );
		
		
		return new JsonResponse( new Picture($p) );
	}
}