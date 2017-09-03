<?php

use GuzzleHttp\Client;

$BASE_URL = 'http://' . $_SERVER[ 'HTTP_HOST' ] . str_replace( $_SERVER[ 'PATH_INFO' ], '', $_SERVER[ 'REQUEST_URI' ] );
$API_URL = $BASE_URL . '/api/';

//dump( $API_URL );
//dump($_SERVER);

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
