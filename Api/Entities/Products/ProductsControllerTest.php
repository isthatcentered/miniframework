<?php

namespace Api\Entities\Users;


use Api\Entities\Products\Product;
use Api\Entities\Repository;
use Core\FunctionalTestCase;

class ProductsControllerTest extends FunctionalTestCase
{
	protected $itemMock;
	protected $endpoint;
	protected $table;
	protected $entity;
	
	public function setUp()
	{
		
		parent ::setUp();
		
		$this -> itemMock = ( new Product() )
			-> setName( 'Waffle' )
			-> setDescription( 'nice with syrup' )
			-> setPrice( 3 );
		
		$this -> endpoint = 'api/products';
		
		$this -> table = 'products';
		
		$this -> entity = Product::class;
	}
	
	
	// List action ===============================================================
	
	/**
	 * @test
	 */
	public function indexAction_when_called_should_return_200()
	{
		$req = $this -> client -> get( $this -> endpoint );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function indexAction_when_called_should_return_app_json_header()
	{
		$req = $this -> client -> get( $this -> endpoint );
		
		$res = $req -> getBody() -> getContents();
		
		$cType = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertContains( 'application/json', $cType );
	}
	
	/**
	 * @test
	 */
	public function indexAction_when_called_should_return_app_json()
	{
		$req = $this -> client -> get( $this -> endpoint );
		
		$res = $req -> getBody() -> getContents();
		
		self ::assertJson( $res );
	}
	
	
	/**
	 * @test
	 */
	public function indexAction_when_jsondecoded_should_return_array_of_items()
	{
		
		$req = $this -> client -> get( $this -> endpoint );
		
		$res = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertInternalType( 'array', $res );
		
		foreach ( $res as $user )
			self ::assertEquals( true, $this -> isArrInstanceOf( $this->entity, (array)$user ) );
	}
	
	
	// Single action ===========================================================
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_item_should_return_200()
	{
		$i = $this -> itemMock;
		
		// insert user
		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
		
		$req = $this -> client -> get( $this -> endpoint . '/' . $iId );
		
		// Make sure user does exist in db
		self ::assertNotFalse( Repository ::findBy( $this -> getDevDatabase(), $this -> table, [ 'id' => $iId ] ) );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_item_should_return_json_type()
	{
		
		$i = $this -> itemMock;
		
		// insert user
		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
		
		$req = $this -> client -> get( $this -> endpoint . '/' . $iId );
		
		// Make sure user does exist in db
		self ::assertNotFalse( Repository ::findBy( $this -> getDevDatabase(), $this -> table, [ 'id' => $iId ] ) );
		
		$cType = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertContains( 'application/json', $cType );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_item_should_return_item()
	{
		$i = $this -> itemMock;
		
		// insert user
		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
		
		$req = $this -> client -> get( $this -> endpoint . '/' . $iId );
		
		$body = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		// Make sure user does exist in db
		self ::assertNotFalse( Repository ::findBy( $this -> getDevDatabase(), $this -> table, [ 'id' => $iId ] ) );
		
		self ::assertEquals( true, $this -> isArrInstanceOf( $this->entity, (array)$body ) );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_non_existing_item_should_return_404()
	{
		$id = 12353599;
		$req = $this -> client -> get( $this -> endpoint . '/' . $id );
		
		// Make sure user doesnt exist in db
		self ::assertFalse( Repository ::findBy( $this -> getDevDatabase(), $this -> table, [ 'id' => $id ] ) );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_non_existing_item_should_return_json_type()
	{
		$id = 12353599;
		$req = $this -> client -> get( $this -> endpoint . '/' . $id );
		
		// Make sure user doesnt exist in db
		self ::assertFalse( Repository ::findBy( $this -> getDevDatabase(), $this -> table, [ 'id' => $id ] ) );
		
		$cType = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertContains( 'application/json', $cType );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_non_existing_item_should_return_err_msg()
	{
		$id = 12353599;
		$req = $this -> client -> get( $this -> endpoint . '/' . $id );
		
		// Make sure user doesnt exist in db
		self ::assertFalse( Repository ::findBy( $this -> getDevDatabase(), $this -> table, [ 'id' => $id ] ) );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	
	// Post action ======================================================================================
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_500()
	{
		$req = $this -> client -> post( $this -> endpoint, [] );
		
		self ::assertEquals( 500, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_json()
	{
		$req = $this -> client -> post( $this -> endpoint, [] );
		
		self ::assertEquals( 500, $req -> getStatusCode() );
		
		self ::assertJson( $req -> getBody() -> getContents() );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_without_data_should_return_err_msg()
	{
		$req = $this -> client -> post( $this -> endpoint, [] );
		
		$body = $req -> getBody() -> getContents();
		
		// Make sur message is usefull (kinda)
		self ::assertContains( 'no data provided', strtolower( $body ) );
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_with_incorrect_data_should_return_500()
	{
		$req = $this -> client -> post( $this -> endpoint, [ 'form_params' => [ 'INCORRECT' => 'DATA' ] ] );
		
		self ::assertEquals( 500, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_with_incorrect_data_should_return_json()
	{
		$req = $this -> client -> post( $this -> endpoint, [ 'form_params' => [ 'INCORRECT' => 'DATA' ] ] );
		
		self ::assertEquals( 500, $req -> getStatusCode() );
		
		self ::assertJson( $req -> getBody() -> getContents() );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_with_incorrect_data_should_return_err_msg()
	{
		$req = $this -> client -> post( $this -> endpoint, [ 'form_params' => [ 'INCORRECT' => 'DATA' ] ] );
		
		$body = $req -> getBody() -> getContents();
		
		// Make sur this is a PDO error
		self ::assertContains( 'SQLSTATE', $body );
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_with_correct_data_should_return_200()
	{
		$i = $this -> itemMock;
		
		$req = $this -> client -> post( $this -> endpoint, [ 'form_params' => (array)$i ] );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_should_return_json()
	{
		$i = $this -> itemMock;
		
		$req = $this -> client -> post( $this -> endpoint, [ 'form_params' => (array)$i ] );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
		
		self ::assertJson( $req -> getBody() -> getContents() );
	}
	
	/**
	 * @test
	 */
	public function postAction_when_posting_should_return_newly_created_item_including_id()
	{
		$i = $this -> itemMock;
		
		$req = $this -> client -> post( $this -> endpoint, [ 'form_params' => (array)$i ] );
		
		$body = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		$iId = ( (array)$body )[ 'id' ];
		
		self ::assertEquals( 200, $req -> getStatusCode() );
		
		self ::assertEquals( true, $this -> isArrInstanceOf( $this->entity, (array)$body ) );
		
		self ::assertEquals( true, $this -> seeInDevDb( $this -> table, $iId ) );
		
		self ::assertNotNull( $iId );
		
	}
	
	
	// updateAction() ==========================================================================================

//	/**
//	 * @test
//	 */
//	public function updateAction_when_called_on_existing_item_should_return_200()
//	{
//		$u = ( new User() )
//			-> setName( 'Kanye' )
//			-> setPassword( 'West' )
//			-> setAdmin( false );
//
//		// insert user
//		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
//
//		// make sure user exists
//		self ::assertTrue( $this -> seeInDevDb( $this -> table, $iId ) );
//
//		// call update on its id
//		$req = $this -> client -> put( $this->endpoint . '/ . $iId, [
//			'form_params' => [ 'id' => $iId ]
//		] );
//
//		var_dump($req->getBody()->getContents());
//		// assert was successful
//		self ::assertEquals( 200, $req -> getStatusCode() );
//	}
//
//	/**
//	 * @test
//	 */
//	public function updateAction_when_called_on_existing_item_should_return_json_type()
//	{
//
//		$u = ( new User() )
//			-> setName( 'Kanye' )
//			-> setPassword( 'West' )
//			-> setAdmin( false );
//
//		// insert user
//		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
//
//		// make sure user exists
//		self ::assertTrue( $this -> seeInDevDb( $this -> table, $iId ) );
//
//		// call delete on its id
//		$req = $this -> client -> put( $this->endpoint . '/ . $iId );
//
//		$cType = $req -> getHeaderLine( 'Content-Type' );
//
//		var_dump( $req -> getBody() -> getContents() );
//
//		self ::assertEquals( 200, $req -> getStatusCode() );
//
//		self ::assertContains( 'application/json', $cType );
//	}
//
//	/**
//	 * @test
//	 */
//	public function updateAction_when_called_on_existing_item_should_remove_item_from_db()
//	{
//		$u = ( new User() )
//			-> setName( 'Kanye' )
//			-> setPassword( 'West' )
//			-> setAdmin( false );
//
//		// insert user
//		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
//
//		// make sure user exists
//		self ::assertTrue( $this -> seeInDevDb( $this -> table, $iId ) );
//
//		// call delete on its id
//		$req = $this -> client -> put( $this->endpoint . '/ . $iId );
//
//		$body = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
//
//		self ::assertEquals( 200, $req -> getStatusCode() );
//
//		self ::assertEquals( false, $this -> seeInDevDb( $this -> table, $iId ) );
//	}
//
//	/**
//	 * @test
//	 */
//	public function updateAction_when_called_on_non_existing_item_should_return_404()
//	{
//		$iId = 12353599;
//
//		// make sure user doesnt exist
//		self ::assertFalse( $this -> seeInDevDb( $this -> table, $iId ) );
//
//		// call delete on its id
//		$req = $this -> client -> put( $this->endpoint . '/ . $iId );
//
//		self ::assertEquals( 404, $req -> getStatusCode() );
//	}
//
//	/**
//	 * @test
//	 */
//	public function updateAction_when_called_on_non_existing_item_should_return_json_type()
//	{
//		$iId = 12353599;
//
//		// make sure user doesnt exist
//		self ::assertFalse( $this -> seeInDevDb( $this -> table, $iId ) );
//
//		// call delete on its id
//		$req = $this -> client -> put( $this->endpoint . '/ . $iId );
//
//		$cType = $req -> getHeaderLine( 'Content-Type' );
//
//		self ::assertEquals( 404, $req -> getStatusCode() );
//
//		self ::assertContains( 'application/json', $cType );
//	}
//
//	/**
//	 * @test
//	 */
//	public function updateAction_when_called_on_non_existing_item_should_return_err_msg()
//	{
//		$iId = 12353599;
//
//		// make sure user doesnt exist
//		self ::assertFalse( $this -> seeInDevDb( $this -> table, $iId ) );
//
//		// call delete on its id
//		$req = $this -> client -> put( $this->endpoint . '/ . $iId );
//
//		$body = $req -> getBody() -> getContents();
//
//		self ::assertEquals( 404, $req -> getStatusCode() );
//
//		self ::assertContains( 'not found', strtolower( $body ) );
//
//		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
//
//		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
//	}
//
//
//
	// deleteAction ============================================================================================
	
	/**
	 * @test
	 */
	public function deleteAction_when_called_on_existing_item_should_return_200()
	{
		$i = $this -> itemMock;
		
		// insert user
		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
		
		// make sure user exists
		self ::assertTrue( $this -> seeInDevDb( $this -> table, $iId ) );
		
		// call delete on its id
		$req = $this -> client -> delete( $this -> endpoint . '/' . $iId );
		
		// assert was successful
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_called_on_existing_item_should_return_json_type()
	{
		
		$i = $this -> itemMock;
		
		// insert user
		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
		
		// make sure user exists
		self ::assertTrue( $this -> seeInDevDb( $this -> table, $iId ) );
		
		// call delete on its id
		$req = $this -> client -> delete( $this -> endpoint . '/' . $iId );
		
		$cType = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
		
		self ::assertContains( 'application/json', $cType );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_called_on_existing_item_should_remove_item_from_db()
	{
		$i = $this -> itemMock;
		
		// insert user
		$iId = $this -> insertInDevDb( $this -> table, (array)$i );
		
		// make sure user exists
		self ::assertTrue( $this -> seeInDevDb( $this -> table, $iId ) );
		
		// call delete on its id
		$req = $this -> client -> delete( $this -> endpoint . '/' . $iId );
		
		$body = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
		
		self ::assertEquals( false, $this -> seeInDevDb( $this -> table, $iId ) );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_called_on_non_existing_item_should_return_404()
	{
		$iId = 12353599;
		
		// make sure user doesnt exist
		self ::assertFalse( $this -> seeInDevDb( $this -> table, $iId ) );
		
		// call delete on its id
		$req = $this -> client -> delete( $this -> endpoint . '/' . $iId );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_called_on_non_existing_item_should_return_json_type()
	{
		$iId = 12353599;
		
		// make sure user doesnt exist
		self ::assertFalse( $this -> seeInDevDb( $this -> table, $iId ) );
		
		// call delete on its id
		$req = $this -> client -> delete( $this -> endpoint . '/' . $iId );
		
		$cType = $req -> getHeaderLine( 'Content-Type' );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
		
		self ::assertContains( 'application/json', $cType );
	}
	
	/**
	 * @test
	 */
	public function deleteAction_when_called_on_non_existing_item_should_return_err_msg()
	{
		$iId = 12353599;
		
		// make sure user doesnt exist
		self ::assertFalse( $this -> seeInDevDb( $this -> table, $iId ) );
		
		// call delete on its id
		$req = $this -> client -> delete( $this -> endpoint . '/' . $iId );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertEquals( 404, $req -> getStatusCode() );
		
		self ::assertContains( 'not found', strtolower( $body ) );
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
}
