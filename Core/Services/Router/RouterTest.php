<?php

namespace Core\Services\Router;

use Core\Entities\Path;
use Core\Services\Router\Exceptions\RouterRouteAlreadySetForMethodException;
use Core\Services\Router\Exceptions\UnregisteredRouterRouteException;
use PHPUnit\Framework\TestCase;

class RandomController
{
	
	public function __construct()
	{
	}
	
	public function homeAction()
	{
		return 'waffles';
	}
	
	public function getPassedArgsAction()
	{
		return func_get_args();
	}
}

class RouterTest extends TestCase
{
	
	// run should return closure for mthod and route
	// should throw exception if not found
	
	/**
	 * @var Router
	 */
	protected $router;
	
	function setUp()
	{
		$this -> router = new Router();
	}
	
	function tearDown()
	{
		
	}
	
	/**
	 * @test
	 */
	public function registerRoute_method_should_register_path_under_method_type()
	{
		
		$this -> router -> registerRoute( '/random', 'GET', function () {
		} );
		
		self ::assertEquals( 'GET', key( $this -> router -> getRegisteredRoutes() ) ); // Returns key of first item
	}
	
	/**
	 * @test
	 */
	public function registerRoute_method_should_register_path_under_method_type_in_uppercase()
	{
		
		// Method is passed in lowercase
		$this -> router -> registerRoute( '/random', 'get', function () {
		} );
		
		// Retrieved in lowercase
		self ::assertSame( 'GET', key( $this -> router -> getRegisteredRoutes() ) ); // Returns key of first item
	}
	
	/**
	 * @test
	 */
	public function registerRoute_method_should_register_controller_under_method_type_then_under_path_()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerRoute( '/random', 'GET', $controller );
		
		self ::assertSame( $controller, reset( $this -> router -> getRegisteredRoutes()[ 'GET' ] ) ); // Returns first item in array
	}
	
	/**
	 * @test
	 */
	public function registerRoute_method_should_return_instance_of_router()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		self ::assertInstanceOf( Router::class, $this -> router -> registerRoute( '/random', 'GET', $controller ) );
	}
	
	/**
	 * @test
	 */
	public function registerRoute_method_should_throw_if_trying_to_registered_already_existing_path_for_method()
	{
		
		self ::expectException( RouterRouteAlreadySetForMethodException::class );
		
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerRoute( '/random', 'GET', $controller );
		
		$this -> router -> registerRoute( '/random', 'GET', $controller );
	}
	
	/**
	 * @test
	 */
	public function registerGet_should_add_passed_routes_to_get_methods()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerGet( '/random', $controller );
		
		self ::assertSame( '/random', key( $this -> router -> getRegisteredRoutes()[ 'GET' ] ) ); // Returns first item in array
	}
	
	/**
	 * @test
	 */
	public function registerGet_should_return_instance_of_Router()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		self ::assertInstanceOf( Router::class, $this -> router -> registerGet( '/random', $controller ) );
	}
	
	/**
	 * @test
	 */
	public function registerPost_should_add_passed_routes_to_post_methods()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerPost( '/random', $controller );
		
		self ::assertSame( '/random', key( $this -> router -> getRegisteredRoutes()[ 'POST' ] ) ); // Returns first item in array
	}
	
	/**
	 * @test
	 */
	public function registerPost_should_return_instance_of_Router()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		self ::assertInstanceOf( Router::class, $this -> router -> registerPost( '/random', $controller ) );
	}
	
	/**
	 * @test
	 */
	public function getControllerForPath_should_return_null_if_method_type_not_registered()
	{
		
		self ::assertEquals( null, $this -> router -> getControllerForPath( new Path( '/whatevz' ), 'GET' ) );
		
	}
	
	/**
	 * @test
	 */
	public function getControllerForPath_should_return_null_if_no_matching_path_under_method_type()
	{
		
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerGet( '/random', $controller );
		
		self ::assertEquals( null, $this -> router -> getControllerForPath( new Path( '/whatevz' ), 'GET' ) );
	}
	
	/**
	 * @test
	 */
	public function getControllerForPath_should_return_controller_for_path_without_args()
	{
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerGet( '/whatevz', $controller );
		
		self ::assertEquals( $controller, $this -> router -> getControllerForPath( new Path( '/whatevz' ), 'GET' ) );
	}
	
	/**
	 * @test
	 */
	public function getControllerForPath_should_return_controller_for_path_with_args()
	{
		$controller = function () {
			return 'hello';
		};
		
		$this -> router -> registerGet( '/whatevz/:id', $controller );
		
		self ::assertEquals( $controller, $this -> router -> getControllerForPath( new Path( '/whatevz/3' ), 'GET' ) );
	}
	
	
	/**
	 * @test
	 */
	public function getResponse_should_throw_when_trying_to_get_unregistered_path()
	{
		self ::expectException( UnregisteredRouterRouteException::class );
		
		
		self ::assertSame( 'waffles', $this -> router -> getResponse( new Path( '/whatevz' ), 'GET' ) );
	}
	
	
	/**
	 * @test
	 */
	public function getResponse_should_work_with_callables()
	{
		$controller = function () {
			return 'waffles';
		};
		
		$this -> router -> registerGet( '/random', $controller );
		
		self ::assertSame( 'waffles', $this -> router -> getResponse( new Path( '/random' ), 'GET' ) );
	}
	
	/**
	 * @test
	 */
	public function getResponse_should_work_with_array_string_reference_to_controller()
	{
		
		$this -> router -> registerGet( '/random', [ RandomController::class, 'homeAction' ] );
		
		self ::assertSame( 'waffles', $this -> router -> getResponse( new Path( '/random' ), 'GET' ) );
	}
	
	/**
	 * @test
	 */
	public function getResponse_should_work_with_array_and_instanciated_controller()
	{
		
		$this -> router -> registerGet( '/random', [ new RandomController(), 'homeAction' ] );
		
		self ::assertSame( 'waffles', $this -> router -> getResponse( new Path( '/random' ), 'GET' ) );
	}
	
	/**
	 * @test
	 */
	public function getResponse_should_pass_args_to_controllers_method()
	{
		
		$this -> router -> registerGet( '/random', [ new RandomController(), 'getPassedArgsAction' ] );
		
		self ::assertSame( 'wafflesConfig', $this -> router -> getResponse( new Path( '/random' ), 'GET', null, [ 'wafflesConfig' ] )[ 0 ][ 0 ] );
	}
	
	/**
	 * @test
	 */
	public function getResponse_should_match_placeholder_args_routes_with_args_routes()
	{
		
		$this ->
		router ->
		registerGet( '/random/:id', [ new RandomController(), 'getPassedArgsAction' ] );
		
		self ::assertSame( 'wafflesConfig', $this -> router -> getResponse( new Path( '/random/3' ), 'GET', null, [ 'wafflesConfig' ] )[ 0 ][ 0 ] );
	}
}
