<?php

session_start();

use GuzzleHttp\Client;

if ( $_SERVER[ 'PATH_INFO' ] !== '/' )
	$BASE_URL = 'http://' . $_SERVER[ 'HTTP_HOST' ] . str_replace( $_SERVER[ 'PATH_INFO' ], '', $_SERVER[ 'REQUEST_URI' ] );
// handle home case
else
	$BASE_URL = rtrim( 'http://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ], '/' ); // //localhost:3000/puppy_commerce/ -> //localhost:3000/puppy_commerce

$API_URL = $BASE_URL . '/api/';

//dump( $BASE_URL );
//dump( $API_URL );
//dump( $_SERVER[ 'PATH_INFO' ] );
//dump( $_SERVER[ 'REQUEST_URI' ] );
//dump( str_replace( $_SERVER[ 'PATH_INFO' ], '', $_SERVER[ 'REQUEST_URI' ] ) );
//dump( $_SERVER );
//die;

$container = new \Core\Services\Container\Container();

$container -> add( 'router', function ( $c ) {
	return new Core\Services\Router\Router();
} );

$container -> add( 'pathHandler', function ( $c ) {
	return new \Core\Services\Path\PathHandler();
} );

$container -> add( 'baseUrl', function ( $c ) use ( $BASE_URL ) {
	return $BASE_URL;
} );


$container -> add( 'apiClient', function ( $c ) use ( $API_URL ) {
	return new Client( [
		'base_uri'    => $API_URL,
		'timeout'     => 2,
		'http_errors' => false
	] );
} );

$container -> add( 'database', function ( $c ) {
	
	$pdoFactory = new \Core\Services\PDOFactory\PDOFactory();
	
	return $pdoFactory -> make( 'dev', [
		'db_name' => 'puppy_commerce',
	] );
} );
