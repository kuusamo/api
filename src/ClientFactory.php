<?php

namespace Kuusamo\Api;

class ClientFactory
{
    /**
     * Create a client.
     *
     * @param string $key    Pre-shared key.
     * @param string $secret Pre-shared secret.
     * @param string $uri    URL of Kuusamo install.
     * @return Client
     */
    public static function create(string $key, string $secret, string $url): Client
    {
        $token = new Token($key, $secret);
        return new Client($token, $url);
    }
}
