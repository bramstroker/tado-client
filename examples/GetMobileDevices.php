<?php
use Stroker\Tado\Client\HttpClient;

require __DIR__ . '/../vendor/autoload.php';

/** @var HttpClient $client */
$client = require('ClientFactory.php');

$devices = $client->getMobileDevices();
foreach ($devices as $device) {
    echo $device->getName() . PHP_EOL;
}