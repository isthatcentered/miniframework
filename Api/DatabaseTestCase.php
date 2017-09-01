<?php

namespace Api;

use Core\Services\PDOFactory\PDOFactory;
use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{
	/**
	 * @var \PDO $db
	 */
	public $db;
	
	public function setUp()
	{
		parent ::setUp();
		$this -> db = $this -> getDatabase();
		$this->db->beginTransaction();
	}
	
	public function tearDown()
	{
		
		parent ::tearDown();
		$this->db->rollBack();
		$this -> db = null;
	}
	
	public function getDatabase()
	{
		
		if ( $this -> db )
			return $this -> db;
		
		return ( new PDOFactory() ) -> make( 'test', [
			'db_name' => 'puppy_commerce',
		] );
	}
	
	public function addToDb( string $table, array $args )
	{
		
	}
	
	public function seeInDb( string $table, array $args )
	{
	}
	
	public function delete ( string $table, array $array ) {
	
	}
	
	public function insert ( string $table, array $data ) {
	
		$names = []; // array_keys($data);
		$values = []; // array_values($data);
		
		
		foreach($data as $key => $value) {
			
			if ($value) {
				$names[] = $key;
				$values[] = "'$value'";
			}
		}
		
		$q = 'INSERT INTO `users` ( '. implode(', ', $names) . ' ) VALUES ( ' . implode(', ', $values) . ' )';
		
		$query = $this->db->prepare($q);
		
		return $query->execute();
	}
	
	public function findOneBy ( string $table, array $args ) {
	
		$query = "SELECT * FROM $table";
		
		foreach ( $args as $key => $val ) {
			$i = array_search( $key, array_keys( $args ) );
			$query .= $i > 0 ?
				" AND $key = :$key" :
				" WHERE $key = :$key";
		}
		
		$match = $this -> db
			-> prepare( $query );
		
		$match -> execute( $args );
		
		return $match -> fetch( PDO::FETCH_ASSOC );
	}
	
	public function findAll( string $table )
	{
		$q = $this->db->query("SELECT * FROM $table");
		
		return $q->fetchAll();
		
	}
	
	
	// only instantiate pdo once for test clean-up/fixture load
	static private $pdo = null;
	
	// only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
	private $conn = null;
	
	final public function getConnection()
	{
		if ( $this -> conn === null ) {
			if ( self ::$pdo == null ) {
				self ::$pdo = new PDO( $GLOBALS[ 'DB_DSN' ], $GLOBALS[ 'DB_USER' ], $GLOBALS[ 'DB_PASSWD' ] );
			}
			$this -> conn = $this -> createDefaultDBConnection( self ::$pdo, $GLOBALS[ 'DB_DBNAME' ] );
		}
		
		return $this -> conn;
	}
}
