<?php

namespace Core\Services\Path;

use Core\Entities\Path;

/**
 * Facade for path class's static methods
 * Class PathHandler
 *
 * @package Core\Services\Path
 */
class PathHandler
{
	protected $path;
	
	/**
	 * PathHandler constructor.
	 *
	 */
	public function __construct()
	{
		return $this -> path = new Path( '' );
	}
	
	public function getArg( string $uri )
	{
		return $this -> path ::getArg( $uri );
	}
	
	public function hasArg( string $uri )
	{
		return $this -> path ::hasArg( $uri );
	}
	
	public function getArglessUri( string $uri )
	{
		return $this -> path ::getArglessUri( $uri );
	}
	
	public function isSame( string $uri, string $secondUri )
	{
		return $this -> path ::isSame( $uri, $secondUri );
	}
}