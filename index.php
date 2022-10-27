<?php

require_once __DIR__ . '/vendor/autoload.php';

$jsonFile = __DIR__ . '/example.json';
//$jsonFile = __DIR__ . '/multiple-departure.json';
//$jsonFile = __DIR__ . '/invalid.json';
//$jsonFile = __DIR__ . '/empty.json';
$json = file_get_contents($jsonFile);

try {
    $trip = new \App\Service\Trip($json);
    echo $trip->run() . PHP_EOL;
} catch (\App\Exception\TripException $e) {
    printf('An error occurred: %s.%s', $e->getMessage(), PHP_EOL);
}

