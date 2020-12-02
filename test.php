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
$response = $client->post('/users', [
    'email' => 'test@example.com',
    'firstName' => 'Jane',
    'surname' => 'Smith'
]);

echo $response->getBody() . "\n";
