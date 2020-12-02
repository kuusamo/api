<?php

namespace Kuusamo\Api\Test\Exception;

use Kuusamo\Api\Exception\VerificationException;
use PHPUnit\Framework\TestCase;

class VertificationExceptionTest extends TestCase
{
    public function testMessage()
    {
        $exception = new VerificationException('Invalid hash');
        $this->assertSame('Invalid hash', $exception->getMessage());
    }

    /**
     * @expectedException Kuusamo\Api\Exception\VerificationException
     */
    public function testThrow()
    {
        throw new VerificationException;
    }
}
