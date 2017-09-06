<?php

use Api\Entities\Categories\CategoriesController;
use Api\Entities\Pictures\PicturesController;
use Api\Entities\Products\ProductsController;
use Api\Entities\Users\UsersController;
use Core\Entities\Path;
use Core\Services\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';


$app = new App( $container );

// Getting current api path used ============================================
$path_arg = $_SERVER[ 'PATH_INFO' ] ?? '/';
$PATH = str_replace( '/api', '', $path_arg ); // '/api/somestuff' -> '/somestuff'


// Registering api routes ====================================================
$app
	-> registerGet( '/', function () {
		echo 'Api home, nothing to see here';
		die;
	} )
	-> registerGet( '/users', [ UsersController::class, 'indexAction' ] )
	-> registerGet( '/users/:id', [ UsersController::class, 'singleAction' ] )
	-> registerPost( '/users', [ UsersController::class, 'postAction' ] )
	-> registerPut( '/users/:id', [ UsersController::class, 'updateAction' ] )
	-> registerDelete( '/users/:id', [ UsersController::class, 'deleteAction' ] )
	-> registerGet( '/products', [ ProductsController::class, 'indexAction' ] )
	-> registerGet( '/products/:id', [ ProductsController::class, 'singleAction' ] )
	-> registerPost( '/products', [ ProductsController::class, 'postAction' ] )
	-> registerPut( '/products/:id', [ ProductsController::class, 'updateAction' ] )
	-> registerDelete( '/products/:id', [ ProductsController::class, 'deleteAction' ] )
	-> registerGet( '/categories', [ CategoriesController::class, 'indexAction' ] )
	-> registerGet( '/categories/:id', [ CategoriesController::class, 'singleAction' ] )
	-> registerGet( '/pictures', [ PicturesController::class, 'indexAction' ] )
	-> registerPost( '/pictures', [ PicturesController::class, 'postAction' ] )
	-> registerGet( '/pictures/:id', [ PicturesController::class, 'singleAction' ] )
	-> render( new Path( $PATH ), $_SERVER[ 'REQUEST_METHOD' ] );

