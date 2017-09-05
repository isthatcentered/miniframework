<?php


namespace App\Controllers;


use App\Exceptions\UnableToReachApiException;
use Core\Services\Container\Container;
use GuzzleHttp\Client;

class AppController
{
	/**
	 * @var Container $container
	 */
	protected $container;
	
	/**
	 * @var Client $client
	 */
	protected $client;
	
	/**
	 * @var string $baseUrl
	 */
	protected $baseUrl;
	
	public function __construct( Container $container )
	{
		$this -> container = $container;
		
		$this -> client = $this -> container -> get( 'apiClient' );
		
		$this -> baseUrl = $this -> container -> get( 'baseUrl' );
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
		
		$vars = array_merge( [
			'BASE_URL'  => $this -> baseUrl,
			'URL_ADMIN' => $this -> baseUrl . '/admin',
			'URL_HOME'  => $this -> baseUrl . '/',
			'USER'      => $_SESSION[ 'user' ] ? : null
		], $vars );
		
		// Buffer everything here (vars are passed)
		ob_start();
		
		require $template;
		
		// End buffering and return buffered content
		return ob_get_clean();
		
	}
}