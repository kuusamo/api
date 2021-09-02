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

    /**
     * @expectedException Kuusamo\Api\Exception\ResponseException
     */
    public function testThrow()
    {
        throw new ResponseException;
    }
}
