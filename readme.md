Kuusamo API
===========

[![Latest Stable Version](https://poser.pugx.org/kuusamo/api/v)](//packagist.org/packages/kuusamo/api)
[![Total Downloads](https://poser.pugx.org/kuusamo/api/downloads)](//packagist.org/packages/kuusamo/api)
[![License](https://poser.pugx.org/kuusamo/api/license)](//packagist.org/packages/kuusamo/api)
[![Build Status](https://app.travis-ci.com/kuusamo/api.svg?branch=master&status=passed)](https://app.travis-ci.com/github/kuusamo/api)

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
