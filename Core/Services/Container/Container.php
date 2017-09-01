<?php


namespace Core\Services\Container;

/**
 * DI Container
 * By wrapping in closure, object won't be instanciated until required
 * Used to store & cache sevices for their use application wide
 *
 * Provides array like acces to objects ($container['stuff']
 *
 *
 * @package App
 */
class Container implements \ArrayAccess
{
	
	protected $__bucket = [];
	protected $__cache = [];
	
	/**
	 * Adds an item to the container
	 * (Convenience method for offsetSet)
	 *
	 * Passing in service as closure to allow lazy loading
	 * & passing of container to service
	 *
	 * @param string   $name    service name
	 * @param \Closure $service service handler
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function add( string $name, \Closure $service )
	{
		if ( isset( $this -> __bucket[ $name ] ) )
			throw new \Exception( 'Trying to register already set container item: "' . $name . '"' );
		
		$this -> offsetSet( $name, $service );
		
		return $this;
	}
	
	public function get( string $serviceName )
	{
		return $this -> offsetGet( $serviceName );
	}
	
	public function remove( string $serviceName )
	{
		if ( $this -> contains( $serviceName ) )
			unset( $this -> __bucket[ $serviceName ] );
		
		return $this;
	}
	
	public function contains( string $serviceName )
	{
		return $this -> offsetExists( $serviceName );
	}
	
	public function isCached( string $serviceName )
	{
		return isset( $this -> __cache[ $serviceName ] );
	}
	
	protected function __getCached( string $serviceName )
	{
		return $this -> __cache[ $serviceName ] ?? null;
	}
	
	
	// ArrayAccess implementation =====================================================================
	
	/**
	 * Whether a offset exists
	 */
	public function offsetExists( $offset )
	{
		return isset( $this -> __bucket[ $offset ] );
	}
	
	/**
	 * Offset to retrieve
	 */
	public function offsetGet( $offset )
	{
		// Service wasn't registered
		if ( !$this -> contains( $offset ) )
			throw new \Exception( 'Trying to get unregistered service of name ' . $offset );
		
		// Service in cache ?
		if ( $this -> isCached( $offset ) )
			return $this -> __getCached( $offset );
		
		// Not in cache? instantiate & cache it
		$this -> __cache[ $offset ] = $this -> __bucket [ $offset ]( $this );
		
		// Return cached version
		return $this -> __getCached( $offset );
	}
	
	/**
	 * Offset to set
	 */
	public function offsetSet( $offset, $value )
	{
		$this -> __bucket[ $offset ] = $value;
	}
	
	/**
	 * Offset to unset
	 */
	public function offsetUnset( $offset )
	{
		// TODO: Implement offsetUnset() method.
	}
	
	
}