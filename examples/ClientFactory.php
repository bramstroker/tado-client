<?php
use GuzzleHttp\Client;
use Stroker\Tado\Client\Credentials;

require __DIR__ . '/../vendor/autoload.php';

$username	= "bgerritsen@gmail.com"; // Your MyTado login name (email)
$password	= "&ly^7FMr7ud%KHA&"; // Your MyTado password
$client_secret	= "4HJGRffVR8xb3XdEUQpjgZ1VplJi6Xgw";
$client_id	= "public-api-preview";

$client = new Stroker\Tado\Client\HttpClient(
	new Credentials($username, $password, $client_id, $client_secret)
);

return $client;