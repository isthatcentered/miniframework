<?php


namespace Core\Services\PDOFactory;


use PDO;

class PDOFactory
{
	
	public function make( string $env, array $config )
	{
		$c = [
			'db_driver'   => 'mysql',
			'db_host'     => '127.0.0.1',
			'db_port'     => '8889',
			'db_username' => 'root',
			'db_password' => 'root'
		
		];
		
		switch ( $env ) {
			case 'dev':
				
				// Override default dev config w+ passed one
				$c = array_merge( $c, $config );
				
				break;
			
			case 'test':
				
				// Override default dev config w+ passed one
				$c = array_merge( $c, $config );
				
				break;
			
			
			case 'prod':
				// Use full config & throw if lacking
				$c = $config;
				break;
		}
		
		// Dev only requires db name
		try {
			
			$driver = $c[ 'db_driver' ];
			$host = $c[ 'db_host' ];
			$port = $c[ 'db_port' ];
			$name = $c[ 'db_name' ];
			
			$pdo = new \PDO(
				"$driver:host=$host;port=$port;dbname=$name",
				$c[ 'db_username' ],
				$c[ 'db_password' ]
			
			);
			
			$pdo -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			return $pdo;
		} catch ( \Exception $e ) {
			throw new InvalidCredentialsForDbException( "Invalid credentials for db " . json_encode( $c ) . " " . $e -> getMessage() );
		}
	}
}