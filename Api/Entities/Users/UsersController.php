<?php


namespace Api\Entities\Users;


use Api\Entities\Repository;
use Api\JsonErrorResponse;
use Api\JsonResponse;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class UsersController
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
		$usersResource = $db
			-> query( "SELECT * FROM users" )
			-> fetchAll();
		
		// Mapping returned resource to a User object
		$users = [];
		$usersResource = array_map(
			function ( $user ) use ( &$users ) {
				
				$users[] = new User( $user );
			},
			$usersResource );
		
		
		//	// Display
		//	// Create json response from node
		return new JsonResponse( $users );
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
		$usersResource = $db
			-> prepare( "SELECT * FROM users WHERE id = :id" );
		$usersResource -> execute( [ 'id' => $arg ] );
		
		$u = $usersResource -> fetch();
		
		if ( !$u )
			return new JsonErrorResponse( 'Sorry, this guy might exist but definitly not in the database', 404 );
		
		return new JsonResponse( new User( $u ) );
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
				[ 'id' => Repository ::insert( $db, 'users', $_POST ) ]
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
		
		$deletedRows = Repository ::delete( $db, 'users', $arg );
		
		if ( !$arg || !$deletedRows )
			return new JsonErrorResponse( 'If you want me to kill someone, please provide a valid id', 404 );
		
		return new JsonResponse( [ 'success' =>  true] );
	}
}