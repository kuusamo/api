Kuusamo API
===========

This library is designed to integrate into your existing application to allow you to talk to your Kuusamo instance.

Install it:

    composer require kuusamo/api

Use it:

    $client = Kuusamo\Api\ClientFactory::create(
        'example-key',
        'example-secret',
        'https://example.com/api'
    );

    $response = $client->get('/test');

Enjoy!
