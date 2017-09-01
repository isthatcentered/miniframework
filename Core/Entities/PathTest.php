<?php

namespace Core\Entities;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
	
	public function setUp()
	{
	}
	
	/**
	 * @test
	 */
	public function getUri_should_return_uri()
	{
		$uri = '/random/waffles';
		$path = new Path( $uri );
		
		self ::assertEquals( $uri, $path -> getUri() );
	}
	
	/**
	 * @test
	 */
	public function getUri_should_return_uri_minus_ignore_path()
	{
		$uri = '/random/waffles';
		$path = new Path( $uri );
		$path -> setIgnore( '/random' );
		
		self ::assertEquals( '/waffles', $path -> getUri() );
	}
	
	
	/**
	 * @test
	 */
	public function static_isArg_should_return_true_when_passed_integer()
	{
		self ::assertEquals( true, Path ::isArg( '3' ) );
	}
	
	/**
	 * @test
	 */
	public function static_isArg_should_return_false_when_passed_integer_and_chars()
	{
		self ::assertEquals( false, Path ::isArg( '3ds' ) );
	}
	
	/**
	 * @test
	 */
	public function static_isArg_should_return_true_when_passed_string_containing_a_colon()
	{
		self ::assertEquals( true, Path ::isArg( ':id' ) );
	}
	
	/**
	 * @test
	 */
	public function static_getArg_should_return_arg_placeholder_of_path_definitions()
	{
		self ::assertEquals( ':id', Path ::getArg( '/random/waffles/:id' ) );
	}
	
	/**
	 * @test
	 */
	public function static_getArg_should_return_arg_for_uri_when_exists()
	{
		self ::assertEquals( '3', Path ::getArg( '/random/waffles/3' ) );
	}
	
	/**
	 * @test
	 */
	public function static_getArg_should_return_null_for_uri_when_no_args()
	{
		self ::assertEquals( null, Path ::getArg( '/random/waffles' ) );
	}
	
	/**
	 * @test
	 */
	public function static_hasArg_should_return_false_for_uri_when_no_arg()
	{
		self ::assertEquals( false, Path ::hasArg( '/random/waffles' ) );
	}
	
	/**
	 * @test
	 */
	public function static_hasArg_should_return_true_for_uri_when_arg()
	{
		self ::assertEquals( true, Path ::hasArg( '/random/waffles/3' ) );
	}
	
	/**
	 * @test
	 */
	public function static_hasArg_should_return_true_for_uri_when_arg_placeholder()
	{
		self ::assertEquals( true, Path ::hasArg( '/random/waffles/:id' ) );
	}
	
	/**
	 * @test
	 */
	public function static_getArglessUri_should_return_uri_without_arg_and_trailing_slash_when_arg()
	{
		self ::assertEquals( '/random/waffles', Path ::getArglessUri( '/random/waffles/:id' ) );
	}
	
	/**
	 * @test
	 */
	public function static_getArglessUri_should_return_passed_uri_if_no_arg_trailing_slash_included()
	{
		$uri = '/random/waffles/';
		
		self ::assertEquals( $uri, Path ::getArglessUri( $uri ) );
	}
	
	/**
	 * @test
	 */
	public function static_isSame_should_return_true_when_perfect_match()
	{
		$uri = '/random/waffles';
		
		self ::assertEquals(
			true,
			Path::isSame( $uri, $uri )
		);
	}
	
	/**
	 * @test
	 */
	public function static_isSame_should_return_false_when_any_difference()
	{
		self ::assertEquals(
			false,
			Path::isSame( '/random/waffle', '/random/waffles' )
		);
	}
	
	/**
	 * @test
	 */
	public function static_isSame_should_return_true_with_argument_path_definition()
	{
		self ::assertEquals(
			true,
			Path::isSame( '/random/waffles/:id', '/random/waffles/3' )
		);
	}
}
