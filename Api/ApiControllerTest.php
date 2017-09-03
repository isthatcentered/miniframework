<?php


use Api\Entities\Users\User;
use Api\Exceptions\ItemNotFoundException;
use Api\Exceptions\NoDataProvidedForInsertException;
use Api\Exceptions\NoDataProvidedForUpdateException;
use Api\Exceptions\NoIdProdividedForUpdateException;
use Core\FunctionalTestCase;

class ApiControllerTest extends FunctionalTestCase
{
	/** @var \Api\ApiController $__sut */
	protected $__sut;
	
	public function setUp()
	{
		
		parent ::setUp();
		
		
		// Prepare container mock to return test db
		$containerStub = self ::createMock( \Core\Services\Container\Container::class );
		$containerStub -> method( 'get' )
			-> with( 'database' )
			-> willReturn( $this -> db );
		
		
		// Instantiate SUT with brand new mock
		$this -> __sut = new \Api\ApiController( '', '', $containerStub );
	}
	
	
	// list() ====================================================================================================
	
	/**
	 * @test
	 */
	public function list_when_table_doesnt_exist_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$this -> __sut -> listAll( 'IDONTEXIST' );
	}
	
	/**
	 * @test
	 */
	public function list_when_no_items_should_return_empty_arr()
	{
		$res = $this -> __sut -> listAll( 'users' );
		
		self ::assertSame( [], $res );
	}
	
	/**
	 * @test
	 */
	public function list_when_items_found_should_return_arr_of_arrs()
	{
		// Create users to test against
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		$u1 = ( new User() )
			-> setName( 'Ri' )
			-> setPassword( 'hanna' )
			-> setAdmin( false );
		
		// Populate db to have something to return
		$u = $this -> insertInTestDb( 'users', (array)$u );
		
		$u1 = $this -> insertInTestDb( 'users', (array)$u1 );
		
		// Fetch
		$res = $this -> __sut -> listAll( 'users' );
		
		// Check you get back what you previously added
		self ::assertEquals( 2, count( $res ) );
		
		self ::assertInternalType( 'array', $res[ 0 ] );
		
		self ::assertEquals( 'Kanye', $res[ 0 ][ 'name' ] );
		
		self ::assertEquals( 'Ri', $res[ 1 ][ 'name' ] );
	}
	
	
	// Show() ====================================================================================================
	
	/**
	 * @test
	 */
	public function show_when_table_doesnt_exist_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$this -> __sut -> show( 'IDONTEXIST', 3 );
	}
	
	/**
	 * @test
	 */
	public function show_when_no_items_found_should_throw()
	{
		self ::expectException( ItemNotFoundException::class );
		
		$this -> __sut -> show( 'users', 3 );
	}
	
	/**
	 * @test
	 */
	public function show_when_item_found_should_return_it_as_arr()
	{
		// Create users to test against
		$name = 'Kanyeze';
		$u = ( new User() )
			-> setName( $name )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		// Populate db to have something to return
		$uId = $this -> insertInTestDb( 'users', (array)$u );
		
		$match = $this -> __sut -> show( 'users', $uId );
		
		self ::assertInternalType( 'array', $match );
		
		self ::assertEquals( $name, $match[ 'name' ] );
	}
	
	
	// post() ===============================================================================================
	
	/**
	 * @test
	 */
	public function post_when_table_doesnt_exist_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$this -> __sut -> post( 'IDONTEXISTHOMEY', [ 'some' => 'data' ] );
	}
	
	/**
	 * @test
	 */
	public function post_when_no_data_provided_should_throw()
	{
		self ::expectException( NoDataProvidedForInsertException::class );
		
		$this -> __sut -> post( 'users', [] );
	}
	
	/**
	 * @test
	 */
	public function post_when_wrong_data_provided_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$this -> __sut -> post( 'users', [ 'LOLZ' => true ] );
	}
	
	/**
	 * @test
	 */
	public function post_when_correct_data_provided_should_return_newly_inserted_item_with_id()
	{
		// Create users to test against
		$name = 'Kanyeze';
		$u = ( new User() )
			-> setName( $name )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		$created = $this -> __sut -> post( 'users', (array)$u );
		
		self ::assertInternalType( 'array', $created );
		
		self ::assertEquals( $name, $created[ 'name' ] );
	}
	
	
	// delete() ====================================================================================================
	
	/**
	 * @test
	 */
	public function delete_when_table_doesnt_exist_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$this -> __sut -> delete( 'IDONTEXISTHOMEY', 3 );
	}
	
	/**
	 * @test
	 */
	public function delete_when_no_matching_item_found_should_throw()
	{
		self ::expectException( ItemNotFoundException::class );
		
		$this -> __sut -> delete( 'users', 3 );
	}
	
	/**
	 * @test
	 */
	public function delete_when_matching_item_found_should_return_true()
	{
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		// Populate db to have something to return
		$uId = $this -> insertInTestDb( 'users', (array)$u );
		
		self ::assertEquals( true, $this -> __sut -> delete( 'users', $uId ) );
	}
	
	
	// update() ====================================================================================================
	
	/**
	 * @test
	 */
	public function update_when_table_doesnt_exist_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$this -> __sut -> update( 'IDONTEXISTHOMEY', [ 'id' => 1 ] );
	}
	
	/**
	 * @test
	 */
	public function update_when_empty_data_provided_should_throw()
	{
		self ::expectException( NoDataProvidedForUpdateException::class );
		
		$this -> __sut -> update( 'IDONTEXISTHOMEY', [] );
	}
	
	/**
	 * @test
	 */
	public function update_when_no_id_provided_in_data_should_throw()
	{
		self ::expectException( NoIdProdividedForUpdateException::class );
		
		$this -> __sut -> update( 'IDONTEXISTHOMEY', [ 'some' => 'data' ] );
	}
	
	/**
	 * @test
	 */
	public function update_when_non_existing_id_should_throw()
	{
		self ::expectException( ItemNotFoundException::class );
		
		$this -> __sut -> update( 'users', [ 'id' => 3 ] );
	}
	
	/**
	 * @test
	 */
	public function update_when_existing_id_and_wrong_data_should_throw()
	{
		self ::expectException( PDOException::class );
		
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		// Populate db to have something to test against
		$uId = $this -> insertInTestDb( 'users', (array)$u );
		
		$this -> __sut -> update( 'users', [ 'id' => $uId, 'IDONT' => 'EXIST' ] );
	}
	
	/**
	 * @test
	 */
	public function update_when_existing_id_and_correct_data_should_return_updated_item_as_arr()
	{
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		// Populate db to have something to test against
		$uId = $this -> insertInTestDb( 'users', (array)$u );
		
		$updated = $this -> __sut -> update( 'users', [ 'id' => $uId, 'name' => 'Kanyeze' ] );
		
		self ::assertInternalType( 'array', $updated );
		
		self ::assertEquals( $uId, $updated[ 'id' ] );
		
		self ::assertEquals( 'Kanyeze', $updated[ 'name' ] );
	}
	
	// when same data
	
	/**
	 * @test
	 */
	public function update_when_existing_id_and_correct_but_exact_same_data_should_return_item_still()
	{
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		// Populate db to have something to test against
		$uId = $this -> insertInTestDb( 'users', (array)$u );
		
		$updated = $this -> __sut -> update( 'users', [ 'id' => $uId ] );
		
		self ::assertInternalType( 'array', $updated );
		
		self ::assertEquals( $uId, $updated[ 'id' ] );
		
		self ::assertEquals( 'Kanye', $updated[ 'name' ] );
	}
	
	// mapTo() ==========================================================================================
	
	/**
	 * @test
	 */
	public function mapTo_when_passed_empty_arr_should_return_empty_arr()
	{
		self ::assertSame( [], $this -> __sut -> mapTo( User::class, [] ) );
	}
	
	/**
	 * @test
	 */
	public function mapTo_when_passed_array_of_objects_should_return_arr_of_objects_of_type_specified()
	{
		
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		$u1 = ( new User() )
			-> setName( 'Waffles' )
			-> setPassword( 'Pancakes' )
			-> setAdmin( false );
		
		$data = [ (array)$u, (array)$u1 ];
		
		$res = $this -> __sut -> mapTo( User::class, $data );
		
		self ::assertInternalType( 'array', $res );
		
		// Make sure each item returned is indeed of type user
		foreach ( $res as $item )
			self ::assertEquals( true, $this -> isArrInstanceOf( User::class, (array)$item ) );
	}
	
	/**
	 * @test
	 */
	public function mapTo_when_passed_an_object_should_return_object_of_type_specified_inside_arr()
	{
		$u = ( new User() )
			-> setName( 'Kanye' )
			-> setPassword( 'West' )
			-> setAdmin( false );
		
		$res = $this -> __sut -> mapTo( User::class, (array)$u );
		
		self ::assertInternalType( 'array', $res );
		
		self ::assertEquals( true, $this -> isArrInstanceOf( User::class, (array)$res[0] ) );
	}
}
