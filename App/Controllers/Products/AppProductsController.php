<?php


namespace App\Controllers\Products;


use App\Exceptions\UnableToReachApiException;
use Core\Response;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;
use GuzzleHttp\Client;

class AppProductsController
{
	/**
	 * @var Container $container
	 */
	private $container;
	
	/**
	 * @var Client $client
	 */
	private $client;
	
	/**
	 * @var string $baseUrl
	 */
	private $baseUrl;
	
	public function __construct( Container $container )
	{
		$this -> container = $container;
		
		$this -> client = $this -> container -> get( 'apiClient' );
		
		$this -> baseUrl = $this -> container -> get( 'baseUrl' );
	}
	
	public function indexAction()
	{
		// Model
		$products = $this -> fetchFromApi( 'products' );
		
		return new Response(
			$this -> render( __DIR__ . '/products.php', [
				'products' => $products, 'baseUrl' => $this -> baseUrl
			] )
		);
		
		//@TODO: USE APP render method and return content
	}
	
	public function showAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$product = $this -> fetchFromApi( 'products/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/product.php', [
				'product' => $product, 'baseUrl' => $this -> baseUrl
			] )
		);
	}
	
	public function newAction()
	{
		
		$messages = [];
//		if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
//			dump( $_POST );
//			// make a call to api
//			$res = $this -> postToApi( 'products', $_POST );
//
//			$messages[] = [ 'type' => 'success', 'text' => 'Product created successfully with id ' . $res -> id ];
//
//			$_POST = [];
//		}
		
		return new Response(
			$this -> render( __DIR__ . '/create.php', [
				'baseUrl' => $this -> baseUrl, 'messages' => $messages
			] )
		);
	}
	
	
	protected function fetchFromApi( string $endpoint )
	{
		
		$req = $this -> client -> get( $endpoint );
		
		
		if ( $req -> getStatusCode() !== 200 )
			throw new UnableToReachApiException();
		
		return \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
	}
	
	protected function postToApi( string $endpoint, $data )
	{
		$req = $this -> client -> post( $endpoint, [
			'form_params' => $data
		] );
		
		if ( $req -> getStatusCode() !== 200 )
			throw new UnableToReachApiException();
		
		return \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
	}
	
	protected function render( string $template, array $vars = [] )
	{
		// Buffer everything here (vars are passed)
		ob_start();
		
		require $template;
		
		// End buffering and return buffered content
		return ob_get_clean();
		
	}
}