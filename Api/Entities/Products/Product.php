<?php


namespace Api\Entities\Products;


class Product
{
	/**
	 * @var integer
	 */
	public $id;
	
	/**
	 * @var string
	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $description;
	
	/**
	 * @var integer
	 */
	public $price;
	
	/**
	 * @var integer[]
	 */
	public $pictures;
	
	/**
	 * @var integer[]
	 */
	public $categories;
	
	/**
	 * Product constructor.
	 *
	 * @param array $product
	 */
	public function __construct( array $product = [] )
	{
		$this -> setCategories( [] );
		$this -> setPictures( [] );
		
		if ( $product ) {
			$this -> id = $product[ 'id' ];
			$this -> name = $product[ 'name' ];
			$this -> description = $product[ 'description' ];
			$this -> price = $product[ 'price' ];
			$this -> setCategories( $product[ 'categories' ] );
			$this -> setPictures( $product[ 'pictures' ] );
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
	 * @return Product
	 */
	public function setId( int $id ): Product
	{
		$this -> id = $id;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this -> name;
	}
	
	/**
	 * @param string $name
	 *
	 * @return Product
	 */
	public function setName( string $name ): Product
	{
		$this -> name = $name;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this -> description;
	}
	
	/**
	 * @param string $description
	 *
	 * @return Product
	 */
	public function setDescription( string $description ): Product
	{
		$this -> description = $description;
		
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getPrice(): int
	{
		return $this -> price;
	}
	
	/**
	 * @param int $price
	 *
	 * @return Product
	 */
	public function setPrice( int $price ): Product
	{
		$this -> price = $price;
		
		return $this;
	}
	
	/**
	 * @return integer[]
	 */
	public function getPictures(): array
	{
		return json_decode( $this -> pictures );
	}
	
	/**
	 * @param integer[]|string $pictures
	 *
	 * @return Product
	 */
	public function setPictures( $pictures ): Product
	{
		
		if ( is_string( $pictures ) )
			$this -> pictures = $pictures;
		else
			$this -> pictures = json_encode( $pictures );
		
		return $this;
	}
	
	/**
	 * @return integer[]
	 */
	public function getCategories(): array
	{
		return json_decode( $this -> categories );
	}
	
	/**
	 * @param integer[]|string $categories
	 *
	 * @return Product
	 */
	public function setCategories( $categories ): Product
	{
		if ( is_string( $categories ) ) // handling hydration from db
			$this -> categories = $categories;
		else
			$this -> categories = json_encode( $categories );
		
		return $this;
	}
}