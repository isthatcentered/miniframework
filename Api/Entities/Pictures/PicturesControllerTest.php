<?php

namespace Api\Entities\Pictures;

use Api\FunctionalTestCase;
use PHPUnit\Framework\TestCase;

class PicturesControllerTest extends FunctionalTestCase
{
	// List action ===============================================================
	/**
	 * @test
	 */
	public function indexAction_when_called_should_always_return_status_200()
	{
		
		$req = $this -> client -> get( 'api/pictures' );
		
		self ::assertEquals( 200, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function indexAction_when_called_should_return_json()
	{
		
		$req = $this -> client -> get( 'api/pictures' );
		
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
		
		$req = $this -> client -> get( 'api/pictures' );
		
		$res = \GuzzleHttp\json_decode( $req -> getBody() -> getContents() );
		
		self ::assertInternalType( 'array', $res );
	}
	
	
	// Single action ===========================================================
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_unexisting_picture_should_return_status_404()
	{
		
		$req = $this -> client -> get( 'api/pictures/454' );
		
		self ::assertEquals( 404, $req -> getStatusCode() );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_unexisting_picture_should_return_json_err_msg()
	{
		$req = $this -> client -> get( 'api/pictures/454' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertJson( $body );
		
		self ::assertObjectHasAttribute( 'message', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertObjectHasAttribute( 'code', \GuzzleHttp\json_decode( $body ) );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_picture_should_return_json()
	{
		$req = $this -> client -> get( 'api/pictures/1' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertJson( $body );
	}
	
	/**
	 * @test
	 */
	public function singleAction_when_called_on_existing_picture_should_return_object()
	{
		$req = $this -> client -> get( 'api/pictures/1' );
		
		$body = $req -> getBody() -> getContents();
		
		self ::assertObjectHasAttribute( 'id', \GuzzleHttp\json_decode( $body ) );
		
		self ::assertEquals( 1, \GuzzleHttp\json_decode( $body ) -> id );
	}
}
