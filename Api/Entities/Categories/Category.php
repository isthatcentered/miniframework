<?php


namespace Api\Entities\Categories;


class Category
{
	/**
	 * @var integer
	 */
	public $id;
	
	/**
	 * @var string
	 */
	public $name;
	
	
	
	public function __construct( array $data )
	{
		$this -> id = $data['id'];
		$this -> name = $data['name'];
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
	 * @return Category
	 */
	public function setId( int $id ): Category
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
	 * @return Category
	 */
	public function setName( string $name ): Category
	{
		$this -> name = $name;
		
		return $this;
	}
}