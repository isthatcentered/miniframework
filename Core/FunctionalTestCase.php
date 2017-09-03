<?php


namespace Core;

use Api\Entities\Repository;
use Core\Services\PDOFactory\PDOFactory;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class FunctionalTestCase
 * Provides a crawler and access to test databzse
 *
 * @package Api
 */
class FunctionalTestCase extends TestCase
{
	protected $_server = 'http://localhost:8888/puppy_commerce/';
	
	/**
	 * @var Client $client
	 */
	public $client;
	
	/**
	 * @var \PDO $db
	 */
	public $db;
	
	public function setUp()
	{
		
		parent ::setUp();
		
		$this -> client = $this -> getClient();
		
		$this -> db = $this -> getTestingDatabase();
		
		// Reset db
		Repository ::emptyAll( $this -> db );
	}
	
	public function tearDown()
	{
		parent ::tearDown();
		$this -> client = null;
	}
	
	// Helper functions ================================================================================
	
	/**
	 * Insert an object into specified Test table
	 *
	 * @param string $table
	 * @param array  $data
	 *
	 * @return int id of created item in table
	 */
	public function insertInTestDb( string $table, array $data ): int
	{
		return Repository ::insert( $this -> db, 'users', $data );
	}
	
	/**
	 * Insert an object into specified Dev table
	 *
	 * @param string $table
	 * @param array  $data
	 *
	 * @return int id of created item in table
	 */
	public function insertInDevDb( string $table, array $data ): int
	{
		return Repository ::insert( $this -> getDevDatabase(), $table, $data );
	}
	
	public function seeInDevDb( string $table, int $id ): bool
	{
		return Repository ::findBy( $this -> getDevDatabase(), $table, [ 'id' => $id ] ) != false;
	}
	
	public function isArrInstanceOf( string $class, array $arr ): bool
	{
		return array_keys( (array)new $class() ) === array_keys( $arr );
	}
	
	// Mutators ================================================================================
	public function getTestingDatabase()
	{
		
		if ( $this -> db )
			return $this -> db;
		
		return ( new PDOFactory() ) -> make( 'test', [ 'db_name' => 'puppy_commerce_test' ] );
	}
	
	public function getDevDatabase()
	{
		return ( new PDOFactory() ) -> make( 'dev', [ 'db_name' => 'puppy_commerce' ] );
	}
	
	public function getClient()
	{
		
		if ( $this -> client )
			return $this -> client;
		
		return new Client( [
			'base_uri'    => $this -> _server,
			'timeout'     => 2,
			'http_errors' => false
		] );
	}
}