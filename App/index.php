<?php


use App\Controllers\Admin\AppAdminController;
use App\Controllers\Admin\AppAdminPicturesController;
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
	// - Products
	-> registerGet( '/admin/products', [ AppAdminController::class, 'productsListAction' ] )
	-> registerGet( '/admin/products/new', [ AppAdminController::class, 'productsNewAction' ] )
	-> registerGet( '/admin/products/:id', [ AppAdminController::class, 'productsShowAction' ] )
	// - Users
	-> registerGet( '/admin/users', [ AppAdminController::class, 'usersListAction' ] )
	-> registerGet( '/admin/users/:id', [ AppAdminController::class, 'usersShowAction' ] )
	// - Pictures
	-> registerGet( '/admin/pictures', [ AppAdminPicturesController::class, 'indexAction' ] )
	-> registerGet( '/admin/pictures/new', [ AppAdminPicturesController::class, 'newAction' ] )
	// Home =================================================================================
	-> registerGet( '/', [ AppProductsController::class, 'indexAction' ] )
	// Front ================================================================================
	// - Products
	-> registerGet( '/products', [ AppProductsController::class, 'indexAction' ] )
	-> registerGet( '/products/:id', [ AppProductsController::class, 'showAction' ] )
	-> registerGet( '/products/new', [ AppProductsController::class, 'newAction' ] )
	-> registerPost( '/products/new', [ AppProductsController::class, 'newAction' ] )
	// Users ================================================================================
	-> registerGet( '/login', [ AppUsersController::class, 'loginAction' ] )
	-> registerGet( '/register', [ AppUsersController::class, 'registerAction' ] )
	-> registerPost( '/authenticate', [ AppUsersController::class, 'authenticateAction' ] )
	-> registerGet( '/logout', [ AppUsersController::class, 'logoutAction' ] )
	-> render( new Path( $PATH ), $_SERVER[ 'REQUEST_METHOD' ] );
