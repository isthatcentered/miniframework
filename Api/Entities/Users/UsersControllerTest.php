<?php

namespace Api\Entities\Users;


use Api\Entities\Repository;
use Api\FunctionalTestCase;

class UsersControllerTest extends FunctionalTestCase
{
	// List action ===============================================================
	/**
	 * @test
	 */
	public function indexAction_when_called_should_always_return_status_200()
	{
		
		$req = $this -> client -> get( 'api/users' );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function indexAction_when_called_should_return_json()
	{
		
		$req = $this -> client -> get( 'api/users' );
		
		$res = $req -> getBody() -> getContents();
		
		$cType = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertContains( 'application/json', $cType );
		self ::assertJson( $res );
	}
	
	/**
	 * @test
	 */
	public function indexAction_when_jsondecoded_should_return_array()
	{
		
		$req = $this -> client -> get( 'api/users' );
		
		$res = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertInternalType( 'array', $res );
	}
	
	
	// Single action ===========================================================
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_unexisting_user_should_return_status_404()
	{
		
		$req = $this -> client -> get( 'api/users/454' );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_unexisting_user_should_return_json_err_msg()
	{
		$req = $this -> client -> get( 'api/users/454' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertJson( $body );
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_user_should_return_json()
	{
		$req = $this -> client -> get( 'api/users/1' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertJson( $body );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_user_should_return_object()
	{
		$req = $this -> client -> get( 'api/users/1' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'id', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertEquals( 1, \GuzzleHttp\json_decode( $body ) -> id );
	}
	
	
	// Post action ======================================================================================
	
	/**
	 * @test
	 */
	public function postAction_when_calling_should_return_json_response()
	{
		
		$req = $this -> client -> post( 'users' );
		
		$type = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertEquals( 'application/json', $type );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_500()
	{
		
		$req = $this -> client -> post( 'users' );
		
		$code = $req -> getStatusCode();
		
		self ::assertEquals( 500, $code );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_err_msg()
	{
		$req = $this -> client -> post( 'users' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_with_valid_data_should_return_200()
	{
		$u = ( new User() )
			-> setName( 'Whatevz' )
			-> setPassword( 'random' );
		
		$req = $this -> client -> post( 'users', [ 'form_params' => (array)$u ] );
		
		$code = $req -> getStatusCode();
		
		self ::assertEquals( 200, $code );
	}
	
	
	/**
	 * @test
	 */
	public function postAction_when_posting_valid_user_should_return_user_with_id()
	{
		$u = ( new User() )
			-> setName( 'Whatevz' )
			-> setPassword( 'random' );
		
		$req = $this -> client -> post( 'users', [ 'form_params' => (array)$u ] );
		
		self ::assertInternalType( 'int', (int)\GuzzleHttp\json_decode( $req -> getBody() -> getContents() ) -> id );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_non_valid_user_should_return_err_msg()
	{
		
		$req = $this -> client -> post( 'users', [ 'form_params' => [ 'wrong' => 'param' ] ] );
		
		$body = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertObjectHasAttribute( 'message', $body );
		
		self ::assertObjectHasAttribute( 'code', $body );
	}
	
	// deleteAction ============================================================================================
	
	
	/**
	 * @test
	 */
	public function deleteAction_when_non_valid_id_should_return_json()
	{
		// Got to delete user
		$req = $this -> client -> delete( "users/118389386" );
		
		self ::assertJson( $req->getBody()->getContents() );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_non_valid_id_should_return_404()
	{
		// Got to delete user
		$req = $this -> client -> delete( "users/118389386" );
		
		self ::assertEquals( 404, $req->getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_non_valid_id_should_return_err_message()
	{
		// Got to delete user
		$req = $this -> client -> delete( "users/118389386" );
		
		$body = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertObjectHasAttribute( 'message', $body );
		self ::assertObjectHasAttribute( 'code', $body );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_valid_id_should_remove_user_from_db()
	{
		$u = ( new User() )
			-> setName( 'Carlos' )
			-> setPassword( 'Santana' );
		
		// Insert user
		$id = Repository ::insert( $this -> db, 'users', (array)$u );
		
		// Got to delete user
		$req = $this -> client -> delete( "users/$id" );
		
		// Trying to find user w+ id should fail
		self ::assertEquals( false, Repository ::findBy( $this -> db, 'users', [ 'id' => $id ] ) );
		
		self ::assertInternalType( 'int', (int)$id );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_valid_id_should_return_json()
	{
		$u = ( new User() )
			-> setName( 'Carlos' )
			-> setPassword( 'Santana' );
		
		// Insert user
		$id = Repository ::insert( $this -> db, 'users', (array)$u );
		
		// Got to delete user
		$req = $this -> client -> delete( "users/$id" );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'success', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertJson( $body );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_valid_id_should_return_200()
	{
		$u = ( new User() )
			-> setName( 'Carlos' )
			-> setPassword( 'Santana' );
		
		// Insert user
		$id = Repository ::insert( $this -> db, 'users', (array)$u );
		
		// Got to delete user
		$req = $this -> client -> delete( "users/$id" );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
}
