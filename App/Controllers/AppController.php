<?php


namespace App\Controllers;


use Api\Entities\Users\User;
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
			'BASE_URL'     => $this -> baseUrl,
			'URL_ADMIN'    => $this -> baseUrl . '/admin',
			'URL_HOME'     => $this -> baseUrl . '/',
			'USER'         => $this -> getUser() ? : null,
			'IS_ADMIN'     => $this -> isAdmin(),
			'IS_LOGGED_IN' => $this -> isLoggedIn()
		], $vars );
		
		// Buffer everything here (vars are passed)
		ob_start();
		
		require $template;
		
		// End buffering and return buffered content
		return ob_get_clean();
		
	}
	
	protected function guard( bool $condition )
	{
		
		if ( !$condition ) {
			echo '<h1>Unauthorized</h1>';
			echo '<img src="https://media.giphy.com/media/5ftsmLIqktHQA/giphy.gif" alt="Unauthorized">';
			die;
		}
	}
	
	/**
	 * @return User
	 */
	protected function getUser()
	{
		return $_SESSION[ 'user' ];
	}
	
	/**
	 * @return bool
	 */
	protected function isLoggedIn()
	{
		return $this -> getUser() != null;
	}
	
	/**
	 * @return bool
	 */
	protected function isAdmin()
	{
		return $this -> getUser() ? $this -> getUser() -> isAdmin() : false;
	}
}