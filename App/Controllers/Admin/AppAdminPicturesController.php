<?php


namespace App\Controllers\Admin;


use App\Controllers\AppController;
use Core\Response;

class AppAdminPicturesController extends AppController
{
	
	public function indexAction()
	{
		// Model
		$items = $this -> fetchFromApi( 'pictures' );
		
		return new Response(
			$this -> render( __DIR__ . '/views/pictures/list.php', [
				'items'       => $items,
				'page_title' => 'Images',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Images', 'url' => '/pictures' ]
				]
			] )
		);
	}
	
	
	public function newAction()
	{
		return new Response(
			$this -> render( __DIR__ . '/views/pictures/new.php', [
				'page_title' => 'Nouveau',
				'breadcrumbs' => [
					[ 'link' => 'Accueil', 'url' => '' ],
					[ 'link' => 'Images', 'url' => '/pictures' ],
					[ 'link' => 'Nouveau', 'url' => '' ],
				]
			] )
		);
	}
}