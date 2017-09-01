<?php


namespace Core\Services;


use Api\Response;
use Core\Entities\Path;
use Core\Services\Container\Container;
use Core\Services\Router\Router;

class App
{
	/**
	 * @var Container
	 */
	private $container;
	
	/**
	 * @var Router
	 */
	private $router;
	
	/**
	 * App constructor.
	 */
	public function __construct( Container $container )
	{
		
		$this -> container = $container;
		$this -> router = $this -> container -> get( 'router' );
	}
	
	/**
	 * @return Container
	 */
	public function getContainer(): Container
	{
		return $this -> container;
	}
	
	public function registerGet( string $path, $controller )
	{
		$this -> router -> registerGet( $path, $controller );
		
		return $this;
	}
	
	public function registerPost( string $path, $controller )
	{
		$this -> router -> registerPost( $path, $controller );
		
		return $this;
	}
	
	public function registerPut( string $path, $controller )
	{
		$this -> router -> registerPut( $path, $controller );
		
		return $this;
	}
	
	public function registerDelete( string $path, $controller )
	{
		$this -> router -> registerDelete( $path, $controller );
		
		return $this;
	}
	
	public function render( Path $path, string $method )
	{
		/**
		 * @var Response $res
		 */
		$res = $this -> router -> getResponse( $path, $method, $this -> container, [] );
		
		http_response_code( $res -> getStatusCode() );
		header( 'Content-Type: ' . $res -> getFormat() );
		
		echo $res -> getContent();
		
		return $this;
	}
}