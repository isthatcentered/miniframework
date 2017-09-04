<?php


namespace App\Controllers\Admin;


use App\Controllers\AppController;
use Core\Response;

class AppAdminController extends AppController
{
	
	
	public function indexAction()
	{
		$products = array_slice( $this -> fetchFromApi( 'products' ), 0, 6 );
		
		// List all products
		return new Response(
			$this -> render( __DIR__ . '/home.php', [ 'products' => $products ] )
		);
	}
	
	public function productsListAction()
	{
		$products = $this -> fetchFromApi( 'products' );
		
		return new Response(
			$this -> render( __DIR__ . '/views/products/list.php', [ 'products' => $products ] )
		);
	}
}