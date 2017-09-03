<?php

namespace Api;

use Api\Entities\Repository;
use Api\Exceptions\ItemNotFoundException;
use Api\Exceptions\NoDataProvidedForInsertException;
use Api\Exceptions\NoDataProvidedForUpdateException;
use Api\Exceptions\NoIdProdividedForUpdateException;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class ApiController
{
	/**
	 * @var Container
	 */
	protected $container;
	
	/**
	 * @var string $__table
	 */
	protected $__table;
	
	/**
	 * @var string $__entity
	 */
	protected $__entity;
	
	/**
	 * ApiController constructor.
	 *
	 * @param Container $container the instance of App Container passed by the Router
	 */
	public function __construct( string $table, string $entity, Container $container )
	{
		$this -> container = $container;
		
		$this -> __entity = $entity;
		
		$this -> __table = $table;
	}
	
	public function postAction()
	{
		$data = $_POST;
		
		try {
			
			$posted = $this -> post( $this -> __table, $data );
		} catch ( NoDataProvidedForInsertException $e ) {
			
			return new JsonResponse(
				[ 'message' => 'No data provided. If you want to post something, then submitting data might be useful', 'code' => 500 ],
				500
			);
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage(), 500 );
		}
		
		return new JsonResponse( $posted );
	}
	
	public function updateAction()
	{

//		/**
//		 * @var PathHandler $pathHandler
//		 */
//		$pathHandler = $this -> container -> get( 'pathHandler' );
//
//		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
//
//		$data = $_POST;
//		var_dump($_POST);
//		try {
//
//			$user = $this -> update( $this->>__table, $data );
//		} catch ( ItemNotFoundException $e ) {
//
//			return new JsonErrorResponse( 'Not found. If you want me do my job, please do yours and provide a valid id', 404 );
//		} catch ( NoDataProvidedForUpdateException $e ) {
//
//			return new JsonErrorResponse( 'No data. If you want me do my job, please do yours and provide a valid id', 500 );
//		} catch ( NoIdProdividedForUpdateException $e ) {
//
//			return new JsonErrorResponse( 'No id. If you want me do my job, please do yours and provide a valid id', 500 );
//		} catch ( \Exception $e ) {
//
//			return new JsonErrorResponse( $e -> getMessage(), 500 );
//		}
//
//		return $user;
	}
	
	public function deleteAction()
	{
		/**
		 * @var PathHandler $pathHandler
		 */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		try {
			
			$succeded = $this -> delete( $this -> __table, $id );
		} catch ( ItemNotFoundException $e ) {
			
			return new JsonErrorResponse( 'Not found. If you want me to kill someone, please provide a valid id', 404 );
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage(), 500 );
		}
		
		return new JsonResponse( [ 'success' => $succeded ] );
	}
	
	
	/**
	 * Returns the PDO instance stored in Container
	 *
	 * @return \PDO
	 */
	protected function __getDb()
	{
		return $this -> container -> get( 'database' ); // @Todo: Could be cached, although not that useful
	}
	
	/**
	 * Lists all items in a given table as array
	 *
	 * @param string $table Name of the table to fetch from
	 *
	 * @return array
	 * @throws \PDOException when table not found
	 */
	public function listAll( string $table )
	{
		$db = $this -> __getDb();
		
		return Repository ::findAll( $db, $table );
	}
	
	/**
	 * Fetch one item from table and return it as associative array
	 *
	 * @param string $table Name of the table to fetch from
	 * @param int    $id    Id of item to fetch
	 *
	 * @return array The queried object
	 * @throws ItemNotFoundException when item not found
	 * @throws \PDOException when table not found
	 */
	public function show( string $table, int $id )
	{
		$db = $this -> __getDb();
		
		$resource = Repository ::findBy( $db, $table, [ 'id' => $id ] );
		
		// Not found
		if ( !$resource )
			throw new ItemNotFoundException();
		
		// Return found
		return $resource;
	}
	
	/**
	 * Add a new item to specified table
	 *
	 * @param string $table Name of the table to fetch from
	 * @param array  $data  Data to populate table w+
	 *
	 * @return array The newly created object with it's id
	 * @throws NoDataProvidedForInsertException
	 * @throws \PDOException when table not found
	 */
	public function post( string $table, array $data )
	{
		$db = $this -> __getDb();
		
		// No need to process further if no data provided
		if ( !$data )
			throw new NoDataProvidedForInsertException();
		
		// Insert and store item's id
		$id = Repository ::insert( $db, $table, $data );
		
		// Fetch & return newly created item
		return Repository ::findBy( $db, $table, [ 'id' => $id ] );
	}
	
	/**
	 * Update a specified item with new data
	 *
	 * @param string $table Name of the table to fetch from
	 * @param array  $data  Data to populate table w+
	 *
	 * @return array The updated item as array
	 * @throws ItemNotFoundException
	 * @throws NoDataProvidedForUpdateException
	 * @throws NoIdProdividedForUpdateException
	 * @throws \PDOException when table not found
	 */
	public function update( string $table, array $data )
	{
		
		if ( !$data )
			throw new NoDataProvidedForUpdateException();
		
		if ( !isset( $data[ 'id' ] ) )
			throw new NoIdProdividedForUpdateException();
		
		$db = $this -> __getDb();
		
		$didUpdate = Repository ::update( $db, $table, (int)$data[ 'id' ], $data );
		
		// update will return false if no rows affected (aka no matching id or no change in data) or trhow
		if ( !$didUpdate && !Repository ::findBy( $db, $table, [ 'id' => $data[ 'id' ] ] ) )
			throw new ItemNotFoundException();
		
		return Repository ::findBy( $db, $table, [ 'id' => $data[ 'id' ] ] );
	}
	
	/**
	 * Remove item from a specified table
	 *
	 * @param string $table Name of the table to fetch from
	 * @param int    $id    Id of item to delete
	 *
	 * @return bool Was delete operation successful or not ?
	 * @throws ItemNotFoundException
	 * @throws \PDOException when table not found
	 */
	public function delete( string $table, int $id )
	{
		$db = $this -> __getDb();
		
		$succeded = Repository ::delete( $db, $table, $id ); // Returns true if success, false if err
		
		if ( !$succeded )
			throw new ItemNotFoundException();
		
		return true;
	}
	
	// Helpers ============================================================================================
	
	/**
	 *
	 * @param string $class class to map into
	 * @param array  $items array of items or single item to map
	 *
	 * @return array array of items of specified class
	 */
	public function mapTo( string $class, array $items ): array
	{
		if ( !$items )
			return [];
		
		// is an array of items
		if ( isset( $items[ 0 ] ) )
			return array_map( function ( $item ) use ( $class ) {
				return new $class( $item );
			}, $items );
		
		// you've been passed a single item
		return [ new $class( $items ) ];
	}
}