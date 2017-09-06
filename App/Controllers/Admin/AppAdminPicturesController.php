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
				'items' => $items
			] )
		);
	}
	
	public function showAction()
	{
		/** @var PathHandler $pathHandler */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		$item = $this -> fetchFromApi( 'pictures/' . $id );
		
		return new Response(
			$this -> render( __DIR__ . '/views/pictures/single.php', [
				'item' => $item
			] )
		);
	}
	
	public function newAction()
	{
		return new Response(
			$this -> render( __DIR__ . '/views/pictures/new.php' )
		);
	}
}