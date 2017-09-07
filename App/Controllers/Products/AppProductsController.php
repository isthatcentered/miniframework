<?php


namespace App\Controllers\Products;


use App\Controllers\AppController;
use Core\Response;
use Core\Services\Path\PathHandler;

class AppProductsController extends AppController
{
	
	public function indexAction()
	{
		
		// Model
		$products = $this -> fetchFromApi( 'products' );
		
		return new Response(
			$this -> render( __DIR__ . '/views/list.php', [
				'products'    => $products, 'baseUrl' => $this -> baseUrl,
				'page_title'  => 'Produits',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '/' ],
					[ 'link' => 'Produits', 'url' => '/products' ],
				]
			] )
		);
		
		//@TODO: USE APP render method and return content
	}
	
	public function showAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$product = $this -> fetchFromApi( 'products/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/product.php', [
				'product' => $product, 'baseUrl' => $this -> baseUrl
			] )
		);
	}
	
	public function newAction()
	{
		return new Response(
			$this -> render( __DIR__ . '/create.php' )
		);
	}
	
	
}