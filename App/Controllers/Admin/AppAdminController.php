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
		
		$this -> guard( $this -> isAdmin() );
		
		// List all products
		return new Response(
			$this -> render( __DIR__ . '/home.php', [
				'products'    => $products,
				'page_title'  => 'Accueil',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
				]
			] )
		);
	}
	
	public function productsListAction()
	{
		$products = $this -> fetchFromApi( 'products' );
		
		return new Response(
			$this -> render( __DIR__ . '/views/products/list.php', [
				'products'    => $products,
				'page_title'  => 'Produits',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Produits', 'url' => '/products' ],
				]
			] )
		);
	}
	
	public function productsShowAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$product = $this -> fetchFromApi( 'products/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/views/products/single.php', [
				'product'     => $product,
				'page_title'  => $product -> name,
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Produits', 'url' => '/products' ],
					[ 'link' => $product -> name, 'url' => '' ],
				]
			] )
		);
	}
	
	public function productsNewAction()
	{
		
		return new Response(
			$this -> render( __DIR__ . '/views/products/new.php', [
				'page_title'  => 'Nouveau',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Produits', 'url' => '/products' ],
					[ 'link' => 'Nouveau', 'url' => '' ],
				]
			] )
		);
	}
	
	public function usersListAction()
	{
		$items = $this -> fetchFromApi( 'users' );
		
		return new Response(
			$this -> render( __DIR__ . '/views/users/list.php', [
				'items'       => $items,
				'page_title'  => 'Utilisateurs',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Utilisateurs', 'url' => '/users' ]
				]
			] )
		);
	}
	
	public function usersShowAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$item = $this -> fetchFromApi( 'users/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/views/users/single.php', [
				'item'        => $item,
				'page_title'  => $item -> name,
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Utilisateurs', 'url' => '/users' ],
					[ 'link' => $item -> name, 'url' => '' ],
				]
			] )
		);
	}
	
}