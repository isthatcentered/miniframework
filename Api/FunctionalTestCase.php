<?php


namespace Api;

use Core\Services\PDOFactory\PDOFactory;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

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
		
		$this->db = $this->getDatabase();
	}
	
	public function tearDown()
	{
		parent ::tearDown();
		$this -> client = null;
	}
	
	public function getDatabase()
	{
		
		if ( $this -> db )
			return $this -> db;
		
		return ( new PDOFactory() ) -> make( 'dev', [
			'db_name' => 'puppy_commerce',
		] );
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