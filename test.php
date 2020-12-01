<?php

/**
 * Run this script from the command line to test your connection.
 *
 * `php test.php`
 */

require_once 'vendor/autoload.php';

use Kuusamo\Api\ClientFactory;

$client = ClientFactory::create('example-key', 'example-secret', 'http://kuusamo/api');
$response = $client->get('/test');
//$response = $client->post('/test', ['some' => 'body']);

echo $response->getBody() . "\n";
