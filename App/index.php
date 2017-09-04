<?php


use App\Controllers\Admin\AppAdminController;
use App\Controllers\Products\AppProductsController;
use App\Controllers\Users\AppUsersController;
use Core\Entities\Path;
use Core\Services\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../App/bootstrap.php';

$app = new App( $container );

// Getting current api path used ============================================================
$PATH = $_SERVER[ 'PATH_INFO' ] ?? '/';

// Registering api routes ===================================================================
$app
	// Admin ================================================================================
	-> registerGet( '/admin', [ AppAdminController::class, 'indexAction' ] )
	-> registerGet( '/admin/products', [ AppAdminController::class, 'productsListAction' ] )
	
	// Front ================================================================================
	-> registerGet( '/products', [ AppProductsController::class, 'indexAction' ] )
	-> registerGet( '/products/:id', [ AppProductsController::class, 'showAction' ] )
	-> registerGet( '/products/new', [ AppProductsController::class, 'newAction' ] )
	-> registerPost( '/products/new', [ AppProductsController::class, 'newAction' ] )
	
	-> registerGet( '/login', [ AppUsersController::class, 'loginAction' ] )
	-> registerPost( '/authenticate', [ AppUsersController::class, 'authAction' ] )
	-> render( new Path( $PATH ), $_SERVER[ 'REQUEST_METHOD' ] );
