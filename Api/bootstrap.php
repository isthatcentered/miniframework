<?php

$container = new \Core\Services\Container\Container();

$container -> add( 'router', function ( $c ) {
	return new Core\Services\Router\Router();
} );

$container -> add( 'pathHandler', function ( $c ) {
	return new \Core\Services\Path\PathHandler();
} );

$container -> add( 'database', function ( $c ) {
	
	$pdoFactory = new \Core\Services\PDOFactory\PDOFactory();
	
	return $pdoFactory -> make( 'dev', [
		'db_name' => 'puppy_commerce',
	] );
} );
