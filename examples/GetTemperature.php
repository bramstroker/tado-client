<?php
use Stroker\Tado\Client\HttpClient;

require __DIR__ . '/../vendor/autoload.php';

/** @var HttpClient $client */
$client = require('ClientFactory.php');

$zone = $client->getHeatingZone();

echo 'temperature = ' . $zone->getState()->getInsideTemperature() . PHP_EOL;
echo 'humidity = ' . $zone->getState()->getHumidity() . PHP_EOL;