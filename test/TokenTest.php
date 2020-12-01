<?php

namespace Kuusamo\Api\Test;

use Kuusamo\Api\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testAccessors()
    {
        $token = new Token('test-key', 'test-secret');

        $this->assertSame('test-key', $token->getKey());
        $this->assertSame('test-secret', $token->getSecret());
    }
}
