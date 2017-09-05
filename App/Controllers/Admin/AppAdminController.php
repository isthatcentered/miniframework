<?php


namespace App\Controllers\Admin;


use App\Controllers\AppController;
use Core\Response;
use Core\Services\Path\PathHandler;

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
	
	public function productsShowAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$product = $this -> fetchFromApi( 'products/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/views/products/single.php', [ 'product' => $product ] )
		);
	}
	
	public function usersListAction()
	{
		$items = $this -> fetchFromApi( 'users' );
		
		return new Response(
			$this -> render( __DIR__ . '/views/users/list.php', [ 'items' => $items ] )
		);
	}
	
	public function usersShowAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$item = $this -> fetchFromApi( 'users/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/views/users/single.php', [ 'item' => $item ] )
		);
	}
	
	public function productsNewAction()
	{
		
		return new Response(
			$this -> render( __DIR__ . '/views/products/new.php', [] )
		);
	}
}