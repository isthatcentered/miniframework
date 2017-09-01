<?php


namespace Api;


class Response
{
	
	protected $format;
	protected $statusCode;
	protected $content;
	
	/**
	 * ApiResponse constructor.
	 *
	 * @param string|array $content
	 */
	public function __construct( $content, $statusCode = 200, $format = 'text/html' ) {
		$this -> content = $content;
		$this -> statusCode = $statusCode;
		$this -> format = $format;
	}
	
	/**
	 * @return string
	 */
	public function getFormat(): string
	{
		return $this -> format;
	}
	
	/**
	 * @param string $format
	 *
	 * @return $this
	 */
	public function setFormat( string $format )
	{
		$this -> format = $format;
		
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this -> statusCode;
	}
	
	/**
	 * @param int $statusCode
	 *
	 * @return $this
	 */
	public function setStatusCode( int $statusCode )
	{
		$this -> statusCode = $statusCode;
		
		return $this;
	}
	
	/**
	 * @return array|string
	 */
	public function getContent()
	{
		return $this -> content;
	}
	
	/**
	 * @param array|string $content
	 *
	 * @return $this
	 */
	public function setContent( $content )
	{
		$this -> content = $content;
		
		return $this;
	}
}