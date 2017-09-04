<?php


namespace App\Controllers\Users;


use App\Controllers\AppController;
use Core\Response;

class AppUsersController extends AppController
{
	public function loginAction()
	{
		return new Response(
			$this -> render( __DIR__ . '/login.php' )
		);
	}
	
	public function authAction()
	{
		dump( $_POST );
		$users = $this -> fetchFromApi( 'users' );
		
		$match = array_filter( $users, function ( $u ) {
			return $u -> name === $_POST[ 'username' ] &&
				$u->password === $_POST[ 'password' ];
		} );
		
		// Is there a match for this username
		if ( $match  )
			dump( array_pop($match) );
		// Yes, check password
		// fails, redirect with err
		
		else
			dump( $users );
		// Nope? redirect with err
		
	}
}