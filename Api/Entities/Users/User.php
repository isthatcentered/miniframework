<?php


namespace Api\Entities\Users;


class User
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
	public $password;
	

	/**
	 * @var boolean
	 */
	public $admin;
	
	public function __construct( array $user = [] )
	{
		if ($user) {
			$this -> id = $user['id'];
			$this -> name = $user['name'];
			$this -> password = $user['password'];
			$this -> admin = $user['admin'] ?: '';
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
	 * @return User
	 */
	public function setId( int $id ): User
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
	 * @return User
	 */
	public function setName( string $name ): User
	{
		$this -> name = $name;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this -> password;
	}
	
	/**
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword( string $password ): User
	{
		$this -> password = $password;
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isAdmin(): bool
	{
		return $this -> admin;
	}
	
	/**
	 * @param bool $admin
	 *
	 * @return User
	 */
	public function setAdmin( bool $admin ): User
	{
		$this -> admin = $admin;
		
		return $this;
	}
}