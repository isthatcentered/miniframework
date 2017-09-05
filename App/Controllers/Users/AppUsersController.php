<?php


namespace App\Controllers\Users;


use Api\Entities\Users\User;
use Api\JsonErrorResponse;
use App\Controllers\AppController;
use Core\Response;

class AppUsersController extends AppController
{
	public function loginAction()
	{
		return new Response(
			$this -> render( __DIR__ . '/views/login.php' )
		);
	}
	
	public function registerAction()
	{
		// no user with same username
		// Encode pword
		return new Response(
			$this -> render( __DIR__ . '/views/register.php' )
		);
	}
	
	public function authenticateAction()
	{
		
		if ( !$_POST )
			return new JsonErrorResponse( 'No post data', 500 );
		
		$users = $this -> fetchFromApi( 'users' );
		
		$match = array_filter( $users, function ( $u ) {
			return $u -> name === $_POST[ 'name' ] &&
				$u -> password === $_POST[ 'password' ];
		} );
		
		// Is there a match for this username
		if ( !$match )
			return new JsonErrorResponse( 'Not authorized', 403 );
		
		
		// Store user in session
		$_SESSION[ 'user' ] = ( new User() )
			-> setName( $_POST[ 'name' ] )
			-> setId( $_POST[ 'id' ] )
			-> setAdmin( $_POST[ 'admin' ] );
		
		return new Response( 'success' );
	}
	
	public function logoutAction()
	{
		// Store user in session
		$_SESSION[ 'user' ] = null;
		
		header( "Location: $this->baseUrl/", true, 301 );
		die();
	}
}