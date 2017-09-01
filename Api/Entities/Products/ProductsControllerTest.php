<?php

namespace Api\Entities\Products;

use Api\Entities\Repository;
use Api\FunctionalTestCase;

class ProductsControllerTest extends FunctionalTestCase
{
	// List action ===============================================================
	/**
	 * @test
	 */
	public function indexAction_when_called_should_always_return_status_200()
	{
		
		$req = $this -> client -> get( 'api/products' );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function indexAction_when_called_should_return_json()
	{
		
		$req = $this -> client -> get( 'api/products' );
		
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
		
		$req = $this -> client -> get( 'api/products' );
		
		$res = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertInternalType( 'array', $res );
	}
	
	
	// Single action ===========================================================
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_unexisting_product_should_return_status_404()
	{
		
		$req = $this -> client -> get( 'api/products/454' );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_unexisting_product_should_return_json_err_msg()
	{
		$req = $this -> client -> get( 'api/products/454' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertJson( $body );
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_product_should_return_json()
	{
		$req = $this -> client -> get( 'api/products/1' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertJson( $body );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_product_should_return_object()
	{
		$req = $this -> client -> get( 'api/products/1' );
		
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
		
		$req = $this -> client -> post( 'products' );
		
		$type = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertEquals( 'application/json', $type );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_500()
	{
		
		$req = $this -> client -> post( 'products' );
		
		$code = $req -> getStatusCode();
		
		self ::assertEquals( 500, $code );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_err_msg()
	{
		$req = $this -> client -> post( 'products' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_with_valid_data_should_return_200()
	{
		$p = ( new Product() )
			-> setName( 'waffles' )
			-> setDescription( 'panckaes' )
			-> setPrice( 4000 );
		
		$req = $this -> client -> post( 'products', [ 'form_params' => (array)$p ] );
		
		$code = $req -> getStatusCode();
		
		self ::assertEquals( 200, $code );
	}
	
	
	/**
	 * @test
	 */
	public function postAction_when_posting_valid_product_should_return_product_with_id()
	{
		$p = ( new Product() )
			-> setName( 'waffles' )
			-> setDescription( 'panckaes' )
			-> setPrice( 4000 );
		
		$req = $this -> client -> post( 'products', [ 'form_params' => (array)$p ] );
		
		self ::assertInternalType( 'int', (int)\GuzzleHttp\json_decode( $req -> getBody() -> getContents() ) -> id );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_non_valid_product_should_return_err_msg()
	{
		
		$req = $this -> client -> post( 'products', [ 'form_params' => [ 'wrong' => 'param' ] ] );
		
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
		
		self ::assertJson( $req -> getBody() -> getContents() );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_non_valid_id_should_return_404()
	{
		// Got to delete user
		$req = $this -> client -> delete( "users/118389386" );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
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
	public function deleteAction_when_valid_id_should_remove_product_from_db()
	{
		$p = ( new Product() )
			-> setName( 'waffles' )
			-> setDescription( 'panckaes' )
			-> setPrice( 4000 );
		
		// Insert user
		$id = Repository ::insert( $this -> db, 'products', (array)$p );
		
		// Got to delete user
		$req = $this -> client -> delete( "products/$id" );
		
		// Trying to find user w+ id should fail
		self ::assertEquals( false, Repository ::findBy( $this -> db, 'products', [ 'id' => $id ] ) );
		
		self ::assertInternalType( 'int', (int)$id );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_valid_id_should_return_json()
	{
		$p = ( new Product() )
			-> setName( 'waffles' )
			-> setDescription( 'panckaes' )
			-> setPrice( 4000 );
		
		// Insert user
		$id = Repository ::insert( $this -> db, 'products', (array)$p );
		
		// Got to delete user
		$req = $this -> client -> delete( "products/$id" );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'success', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertJson( $body );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_valid_id_should_return_200()
	{
		$p = ( new Product() )
			-> setName( 'waffles' )
			-> setDescription( 'panckaes' )
			-> setPrice( 4000 );
		
		// Insert user
		$id = Repository ::insert( $this -> db, 'products', (array)$p );
		
		// Got to delete user
		$req = $this -> client -> delete( "products/$id" );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
}
