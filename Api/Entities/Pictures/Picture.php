<?php


namespace Api\Entities\Pictures;


class Picture
{
	/**
	 * @var integer
	 */
	public $id;
	
	
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
	public function __construct( array $picture = [] )
	{
		if ( $picture ) {
			$this -> id = $picture[ 'id' ];
			$this -> url = $picture[ 'url' ];
			$this -> alt = $picture[ 'alt' ] ? : '';
		}
		
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
	 * @return Picture
	 */
	public function setId( int $id ): Picture
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
	 * @return Picture
	 */
	public function setUrl( string $url ): Picture
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
	 * @return Picture
	 */
	public function setAlt( string $alt ): Picture
	{
		$this -> alt = $alt;
		
		return $this;
	}
	
	
}