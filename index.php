<?php

require_once __DIR__ . '/vendor/autoload.php';

$jsonFile = 'example.json';
//$jsonFile = 'multiple-departure.json';
//$jsonFile = 'invalid.json';
//$jsonFile = 'empty.json';
$json = file_get_contents(__DIR__ . '/json/' . $jsonFile);

try {
    $trip = new \App\Service\Trip($json);
    echo $trip->run() . PHP_EOL;
} catch (\App\Exception\TripException $e) {
    printf('An error occurred: %s.%s', $e->getMessage(), PHP_EOL);
}

