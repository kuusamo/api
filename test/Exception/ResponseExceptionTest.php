<?php

namespace Kuusamo\Api\Test\Exception;

use Kuusamo\Api\Exception\ResponseException;
use PHPUnit\Framework\TestCase;

class ResponseExceptionTest extends TestCase
{
    public function testMessage()
    {
        $exception = new ResponseException('Invalid hash');
        $this->assertSame('Invalid hash', $exception->getMessage());
    }

    public function testThrow()
    {
        $this->expectException(ResponseException::class);

        throw new ResponseException;
    }
}
