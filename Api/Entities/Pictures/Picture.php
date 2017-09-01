<?php


namespace Api\Entities\Pictures;


class Picture
{
	/**
	 * @var integer
	 */
	public $id;
	
	/**
	 * @var int
	 */
	public $productId;
	
	/**
	 * @var string
	 */
	public $url;
	
	/**
	 * @var string
	 */
	public $alt;
	
	/**
	 * Picture constructor.
	 *
	 * @param array $picture
	 */
	public function __construct( array $picture )
	{
		$this -> id = $picture['id'];
		$this -> productId = $picture['productId'];
		$this -> url = $picture['url'];
		$this -> alt = $picture['alt'] ?: '';
	}
	
	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this -> id;
	}
	
	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function setId( int $id )
	{
		$this -> id = $id;
		
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getProductId(): int
	{
		return $this -> id;
	}
	
	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function setProductId( int $id )
	{
		$this -> id = $id;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this -> url;
	}
	
	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl( string $url )
	{
		$this -> url = $url;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getAlt(): string
	{
		return $this -> alt;
	}
	
	/**
	 * @param string $alt
	 *
	 * @return $this
	 */
	public function setAlt( string $alt )
	{
		$this -> alt = $alt;
		
		return $this;
	}
	
	
	
}