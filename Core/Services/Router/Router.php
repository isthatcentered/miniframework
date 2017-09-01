<?php


namespace Core\Services\Router;

use Core\Entities\Path;
use Core\Services\Container\Container;
use Core\Services\Router\Exceptions\RouterRouteAlreadySetForMethodException;
use Core\Services\Router\Exceptions\UnregisteredRouterRouteException;


/**
 * Class Router
 * In charge of registering routes and their controllers
 * Returns but does not execute any controller
 *
 * @package App\Services
 */
class Router
{
	
	private $__routes = [];
	
	
	public function getRegisteredRoutes()
	{
		return $this -> __routes;
	}
	
	public function registerRoute( string $path, string $method, $controller )
	{
		if (
		isset( $this -> __routes[ strtoupper( $method ) ][ $path ] )
		)
			throw new RouterRouteAlreadySetForMethodException( "Route $path for method $method has already been set" );
		
		$this -> __routes[ strtoupper( $method ) ][ $path ] = $controller;
		
		return $this;
	}
	
	public function registerGet( string $path, $controller )
	{
		return $this -> registerRoute( $path, 'GET', $controller );
	}
	
	public function registerPost( string $path, $controller )
	{
		return $this -> registerRoute( $path, 'POST', $controller );
	}
	
	public function registerDelete( string $path, $controller )
	{
		return $this -> registerRoute( $path, 'DELETE', $controller );
	}
	
	public function registerPut( string $path, $controller )
	{
		return $this -> registerRoute( $path, 'PUT', $controller );
	}
	
	public function getControllerForPath( Path $path, string $method )
	{
		
		// Nothing registered under this method (GET - POST - ... ), no need to go further
		if ( !isset( $this -> __routes[ strtoupper( $method ) ] ) )
			return null;
		
		// Iterate over each route under method and try to find a match
		$match = array_filter( $this -> __routes[ strtoupper( $method ) ], function ( $k ) use ( $path ) {
			return $path -> isSameAs( $k );
		}, ARRAY_FILTER_USE_KEY );
		
		return $match ?
				$match[array_keys($match)[0]] : // First item in arr returned is match but we have to access it by name
				null;
	}
	
	public function getResponse( Path $path, string $method, Container $container = null, $args = null )
	{
		$controller = $this -> getControllerForPath( $path, $method );
		
		if ( !$controller )
			throw new UnregisteredRouterRouteException( 'Trying to get unregistered route for path ' . $path -> getUri() . ' with method ' . $method );
		
		// We passed reference to controller -> ['App\RandomController', 'homeAction']
		if ( is_array( $controller ) ) {
			
			// We passed string reference, not initialized controller
			if ( !is_object( $controller[ 0 ] ) )
				$controller[ 0 ] = new $controller[ 0 ]( $container ); // [Ø] is controller, [1] is controller's method
		}
		
		// Execute & pass args to method
		return call_user_func( $controller, $args );
	}
}