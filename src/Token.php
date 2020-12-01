<?php

namespace Kuusamo\Api;

use InvalidArgumentException;

class Token
{
    private $key;
    private $secret;

    /**
     * Constructor. Validate the values and save.
     *
     * @param string $key    Pre-shared key.
     * @param string $secret Pre-shared secret.
     */
    public function __construct(string $key, string $secret)
    {
        if (strlen($key) < 1) {
            throw new InvalidArgumentException('Key cannot be empty');
        }

        if (strlen($secret) < 1) {
            throw new InvalidArgumentException('Secrey cannot be empty');
        }

        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * Get the key.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get the secret.
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}
