<?php


use Core\Services\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
	
	// Can be accessed like array
	
	/**
	 * @var Container
	 */
	protected $container;
	
	function setUp()
	{
		$this -> container = new Container();
	}
	
	function tearDown()
	{
	
	}
	
	
	/**
	 * @test
	 */
	public function add_should_add_an_item_to_bucket()
	{
		
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		
		// We have to instantiate service to check as get function instantiates items
		self ::assertEquals( $service(), $this -> container -> get( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function add_should_return_instance_of_class()
	{
		
		
		$service = function () {
			return 'hello';
		};
		
		
		self ::assertInstanceOf(
			Container::class,
			$this -> container -> add( 'randomService', $service )
		);
	}
	
	/**
	 * @test
	 */
	public function add_should_throw_when_registering_same_item_twice()
	{
		
		self ::expectException( Exception::class );
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		$this -> container -> add( 'randomService', $service );
		
	}
	
	/**
	 * @test
	 */
	public function get_should_return_instantiated_service()
	{
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		
		self ::assertEquals( $service(), $this -> container -> get( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function get_should_return_same_instance_of_service_when_called_multiple_times()
	{
		
		$service = function () {
			
			$i = 0; // tracking instantiations
			
			return function () use ( &$i ) {
				return $i++;
			};
		};
		
		$this -> container -> add( 'randomService', $service );
		
		$this -> container -> get( 'randomService' )();
		
		$this -> container -> get( 'randomService' )();
		
		$this -> container -> get( 'randomService' )();
		
		self ::assertEquals( 0, $service()() ); // checking instantiation tracking is well set up
		
		self ::assertEquals( 3, $this -> container -> get( 'randomService' )() ); // Function is called for the fourth time, counter should be 3 (i 0 based)
	}
	
	/**
	 * @test
	 */
	public function get_should_throw_when_getting_non_existing_item()
	{
		self ::expectException( \Exception::class );
		
		$this -> container -> get( 'randomService' );
	}
	
	/**
	 * @test
	 */
	public function get_should_pass_instance_of_container_to_closer()
	{
		
		$service = function ( $c ) {
			return $c;
		};
		
		$this -> container -> add( 'randomService', $service );
		
		
		self ::assertInstanceOf( Container::class, $this -> container -> get( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function isCached_should_return_true_if_a_service_has_been_called_once()
	{
		
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		
		$service = $this -> container -> get( 'randomService' );
		
		self ::assertEquals( true, $this -> container -> isCached( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function isCached_should_return_false_if_a_service_has_never_been_called()
	{
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		
		self ::assertEquals( false, $this -> container -> isCached( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function contains_should_return_true_when_contains_item()
	{
		
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		
		self ::assertEquals( true, $this -> container -> contains( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function contains_should_return_false_when_doesnt_contain_item()
	{
		
		
		self ::assertEquals( false, $this -> container -> contains( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function remove_should_remove_passed_item()
	{
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> add( 'randomService', $service );
		
		$this -> container -> remove( 'randomService' );
		
		self ::assertEquals( false, $this -> container -> contains( 'randomService' ) );
	}
	
	/**
	 * @test
	 */
	public function remove_should_not_throw_when_trying_to_remove_non_existing()
	{
		
		$service = function () {
			return 'hello';
		};
		
		$this -> container -> remove( 'randomService' );
		
		self ::assertTrue( true ); // if test doesn't crash, it works (but unsetting unexisting item actually doesn't throw
	}
	
	/**
	 * @test
	 */
	public function remove_should_return_instance_of_container()
	{
		
		self ::assertInstanceOf(
			Container::class,
			$this -> container -> remove( 'randomService' )
		);
	}
}
