<?php


namespace Core\Entities;


interface IPathHandler
{
	public static function isSame( string $uri, string $uri2 );
	
	public static function isArg( string $crumb );
	
	public static function getArg( string $uri );
	
	public static function hasArg( string $uri );
	
	public static function getArglessUri( string $uri );
}