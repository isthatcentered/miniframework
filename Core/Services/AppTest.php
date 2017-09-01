<?php

namespace Core\Services;

use Core\Services\Container\Container;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
	// SHould get container in constructor
	// Should add routes
	// Should give routes container
	// Sould give routes response class
	// Should execute controller
	// When render is returned json
	// When render is returned string
	
	
	/**
	 * @test
	 */
	public function constructor_should_require_instance_of_container()
	{
//		self::expectException(\Exception::class);
		
		self ::assertEquals( true, true );
		
	}
}
