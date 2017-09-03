<?php
// These are now globally available for all templates
$BASE_URL = 'http://' . $_SERVER[ 'HTTP_HOST' ] . str_replace( $_SERVER[ 'PATH_INFO' ], '', $_SERVER[ 'REQUEST_URI' ] );
$API_URL = $BASE_URL . '/api/';

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<style>
		label {
			display: block;
		}
	</style>
</head>
<body class="container">
