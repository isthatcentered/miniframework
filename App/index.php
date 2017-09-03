<?php


use App\Controllers\Products\AppProductsController;
use Core\Entities\Path;
use Core\Services\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../App/bootstrap.php';

$app = new App( $container );

// Getting current api path used ============================================
$PATH = $_SERVER[ 'PATH_INFO' ] ?? '/';

// Registering api routes ====================================================
$app
	-> registerGet( '/products', [ AppProductsController::class, 'indexAction' ] )
	-> registerGet( '/products/:id', [ AppProductsController::class, 'showAction' ] )
	-> registerGet( '/products/new', [ AppProductsController::class, 'newAction' ] )
	-> registerPost( '/products/new', [ AppProductsController::class, 'newAction' ] )
	-> render( new Path( $PATH ), $_SERVER[ 'REQUEST_METHOD' ] );
