<?php
use Stroker\Tado\Client\HttpClient;

require __DIR__ . '/../vendor/autoload.php';

/** @var HttpClient $client */
$client = require('ClientFactory.php');

$zone = $client->getHeatingZone();
$zone->setTemperature(22);