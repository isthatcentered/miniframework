<?php


namespace Api\Entities\Pictures;


use Api\ApiController;
use Api\Exceptions\ItemNotFoundException;
use Api\Exceptions\NoDataProvidedForInsertException;
use Api\JsonErrorResponse;
use Api\JsonResponse;
use Core\Services\Container\Container;
use Core\Services\Path\PathHandler;

class PicturesController extends ApiController
{
	
	public function __construct( Container $container )
	{
		parent ::__construct( 'pictures', Picture::class, $container );
	}
	
	public function indexAction( array $params )
	{
		try {
			
			$resources = $this -> listAll( $this -> __table );
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage() );
		}
		
		return new JsonResponse( $resources );
	}
	
	
	public function singleAction( array $params )
	{
		
		/**
		 * @var PathHandler $pathHandler
		 */
		$pathHandler = $this -> container -> get( 'pathHandler' );
		
		$id = $pathHandler -> getArg( $_SERVER[ 'PATH_INFO' ] );
		
		try {
			
			$u = $this -> show( $this -> __table, $id );
		} catch ( ItemNotFoundException $e ) {
			
			return new JsonErrorResponse( 'Sorry, this guy might exist but definitly not in the database', 404 );
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage(), 500 );
		}
		
		return new JsonResponse( $u );
	}
	
	public function uploadAction()
	{
		
		
		// Get path
		// Store path in db w/ id
		
		return new JsonResponse( [], 200 );
	}
	
	/**
	 * @param array    $file $_FILES arr item
	 * @param string[] $allowed
	 * @param string   $to   dir to upload to
	 *
	 * @return array
	 * @throws \Exception
	 */
	protected function __uploadImg(
		array $file,
		array $allowed = [ 'jpeg', 'jpg', 'png' ],
		string $to = __DIR__ . '/../../../public/uploads/images/'
	): array
	{
		if ( !$file )
			throw new \Exception( 'No file submitted for upload' );
		
		$file_name = $file[ 'name' ];
		$file_ext = explode( '.', $file_name );
		$file_ext = array_pop( $file_ext );
		
		if ( !in_array( $file_ext, $allowed ) )
			throw new \Exception( 'File extension ' . $file_ext . ' not allowed for images' );
		
		// @Todo: check file size
		
		$is_successful = move_uploaded_file( $file[ 'tmp_name' ], $to . $file_name );
		
		if ( !$is_successful )
			throw new \Exception( 'Something wrong happend while uploading file ' . $file_name, 500 );
		
		return [
			"name" => $file_name
		];
	}
	
	public function upload( string $filePath, string $to = __DIR__ . '/../../../public/uploads/images/' )
	{
		$temp_dir = $this -> __getTempDir();
		
		$file = $temp_dir . '/' . $filePath;
		
		var_dump( $file );
		// Folder post exists ?
		// File at path exists ?
		
		return file_exists( $file );
	}
	
	public function postAction()
	{
		$file = array_pop( $_FILES );
		
		if ( !$file || !$file[ 'name' ] )
			return new JsonErrorResponse( 'No image provided', 500 );
		
		$img = $this -> __uploadImg( $file );
		
		$data = ( new Picture() )
			-> setAlt( isset( $_POST[ 'alt' ] ) ? $_POST[ 'alt' ] : '' )
			-> setProductId( $_POST[ 'productId' ] ? (int)$_POST[ 'productId' ] : -1 )
			-> setUrl( $img[ 'name' ] );
		
		
		try {
			
			$posted = $this -> post( $this -> __table, (array)$data );
		} catch ( NoDataProvidedForInsertException $e ) {
			
			return new JsonResponse(
				[ 'message' => 'No data provided. If you want to post something, then submitting data might be useful', 'code' => 500 ],
				500
			);
		} catch ( \Exception $e ) {
			
			return new JsonErrorResponse( $e -> getMessage(), 500 );
		}
		
		return new JsonResponse( $posted );
	}
}