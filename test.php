<?php

/**
 * Run this script from the command line to test your connection.
 *
 * `php test.php`
 */

require_once 'vendor/autoload.php';

use Kuusamo\Api\ClientFactory;

$client = ClientFactory::create('example-key', 'example-secret', 'http://kuusamo/api');

// test end-points
//$response = $client->get('/test');
//$response = $client->post('/test', ['some' => 'body']);

// user end-points
// $response = $client->post('/users', [
//     'email' => 'test@example.com',
//     'firstName' => 'Jane',
//     'surname' => 'Smith'
// ]);

// $response = $client->post('/users/5/courses', [
//     'id' => 1
// ]);

//$response = $client->get('/users/5/courses');

//echo $response->getRaw() . "\n";
echo json_encode($response->getData()) . "\n";
