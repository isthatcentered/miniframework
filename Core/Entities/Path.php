<?php


namespace Core\Entities;


class Path implements IPathHandler
{
	protected $__ignore;
	protected $__uri;
	
	/**
	 * Path constructor.
	 *
	 * @param string $uri
	 */
	public function __construct( string $uri )
	{
		$this -> __uri = $uri;
	}
	
	public function getUri()
	{
		return str_replace( $this -> __ignore, "", $this -> __uri );
	}
	
	public function setIgnore( string $ignore )
	{
		$this -> __ignore = $ignore;
	}
	
	public function isSameAs( string $uri )
	{
		return self ::isSame( $this -> getUri(), $uri );
	}
	
	public static function isSame( string $uri, string $uri2 )
	{
		
		$uriArg = self ::getArg( $uri );
		$uri2Arg = self ::getArg( $uri2 );
		
		
		// Same if both have args & rest of path is same
		if ( isset( $uriArg ) === isset( $uri2Arg ) )
			return self ::getArglessUri( $uri ) === self ::getArglessUri( $uri2 );
		
		return false;
	}
	
	public static function isArg( string $crumb )
	{
		// If last item is an int or contains ":" we assume it is an arg
		return ( is_numeric( $crumb ) || strpos( $crumb, ':' ) !== false );
	}
	
	public static function getArg( string $uri )
	{
		// Explode uri to isolate last item
		$last = explode( '/', $uri );
		
		// Get last item
		$last = array_pop( $last );
		
		return self ::isArg( $last ) ? $last : null;
	}
	
	public static function hasArg( string $uri )
	{
		return self ::getArg( $uri ) ? true : false;
	}
	
	public static function getArglessUri( string $uri )
	{
		// If no arg, no need to process further
		if ( !$arg = self ::getArg( $uri ) )
			return $uri;
		
		// If there was an arg, then there was a trailing '/' that we need to remove
		return rtrim(
			str_replace( $arg, '', $uri ),
			'/'
		);
	}
}