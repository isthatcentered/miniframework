<?php

namespace Api;

use Api\Entities\Repository;
use Core\Services\Container\Container;

class ApiController
{
	/**
	 * @var Container
	 */
	private $container;
	
	/**
	 * ApiController constructor.
	 *
	 * @param Container $container the instance of App Container passed by the Router
	 */
	public function __construct( Container $container )
	{
		$this -> container = $container;
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
	 * @param array  $data Data to populate table w+
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
}