<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/App/bootstrap.php';


echo 'wassup';

/**
//$req = new \App\Services\CurlHandler();

header('Content-Type: application/json');

$client = curl_init();

curl_setopt( $client, CURLOPT_URL, 'https://hacker-news.firebaseio.com/v0/topstories.json' );

curl_setopt( $client, CURLOPT_RETURNTRANSFER, true );

$res = curl_exec( $client );

$topStoriesIds = array_slice( json_decode( $res ), 0, 5 ); // Keep first 5


$stories = [];
foreach ( $topStoriesIds as $id ) {

curl_setopt( $client, CURLOPT_URL, 'https://hacker-news.firebaseio.com/v0/item/' . $id . '.json' );
$res = curl_exec( $client );

if ( curl_getinfo( $client )[ 'http_code' ] === 200 ) {
$story = json_decode( $res );
$stories[] = [
'title' => $story->title,
'by' => $story->by,
'url' => $story->url ?? null,
'type' => $story->type
];
}
}


//echo '<pre>';
echo json_encode($stories);
//echo '<br>';
 */

?>



</body>
</html>

