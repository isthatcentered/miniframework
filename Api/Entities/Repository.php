<?php


namespace Api\Entities;


use PDO;

class Repository
{
	
	/**
	 * @param \PDO   $db
	 * @param string $table
	 * @param array  $args
	 *
	 * @return string
	 */
	public static function insert( \PDO $db, string $table, array $args )
	{
		$properties = self ::_implode( ', ', array_keys( $args ) );
		
		$placeholders = self ::_implode( ', ', array_keys( $args ), ':' );
		
		$q = $db -> prepare( "INSERT INTO `$table` ( " . $properties . ") VALUES ( " . $placeholders . " )" );
		
		$q -> execute( $args );
		
		return $db -> lastInsertId();
	}
	
	public static function delete( \PDO $db, string $table, int $id )
	{
		$q = $db -> prepare( "DELETE FROM `$table` WHERE id = :id" );
		
		$q -> execute( [ 'id' => $id ] );
		
		return $q -> rowCount() > 0 ? true : false;
	}
	
	public static function findBy( \PDO $db, string $table, array $args )
	{
		
		$query = "SELECT * FROM $table";
		
		foreach ( $args as $key => $val ) {
			$i = array_search( $key, array_keys( $args ) );
			$query .= $i > 0 ?
				" AND $key = :$key" :
				" WHERE $key = :$key";
		}
		
		$match = $db
			-> prepare( $query );
		
		$match -> execute( $args );
		
		return $match -> fetch( PDO::FETCH_ASSOC );
	}
	
	public static function update( \PDO $db, string $table, int $id, array $args )
	{
		// Turn keys into placeholders
		$placeholders = self ::_implode( ', ', array_map( function ( $key ) {
			return "`$key` = :$key";
		}, array_keys( $args ) ) ); // ['key'=>'value'] -> "`key` = :key"
		
		
		$q = $db -> prepare( "UPDATE `$table` SET " . $placeholders . " WHERE `id` = :id" );
		
		// execute will return true as long as there are no errors
		$q -> execute( $args );
		
		// So we use th row count to assert result of update
		return $q -> rowCount() > 0 ? true : false;
	}
	
	public static function findAll( \PDO $db, string $table )
	{
		return $db
			-> query( "SELECT * FROM " . $table )
			-> fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function emptyTable( \PDO $db, string $table )
	{
		$q = $db -> prepare( "TRUNCATE TABLE $table" );
		
		return $q -> execute();
	}
	
	public static function emptyAll( \PDO $db )
	{
		
		$tables = $db -> prepare( 'SHOW TABLES' );
		$tables -> execute();
		
		foreach ( $tables -> fetchAll( \PDO::FETCH_COLUMN ) as $table ) {
			$db -> query( 'TRUNCATE TABLE `' . $table . '`' ) -> execute();
		}
	}
	
	
	protected static function _implode( string $join, array $arr, string $prepend = '' ): string
	{
		$string = '';
		$lenght = ( count( $arr ) - 1 );
		
		for ( $i = 0; $i <= $lenght; $i++ )
			$string .= $i !== $lenght ?
				$prepend . $arr[ $i ] . $join :
				$prepend . $arr[ $i ];
		
		return $string;
	}
}