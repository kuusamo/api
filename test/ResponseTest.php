<?php

namespace Kuusamo\Api\Test;

use Kuusamo\Api\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testSignRequest()
    {
        $streamMock = $this->createMock('Nyholm\Psr7\Stream');
        $streamMock->method('getContents')->willReturn('["hello","world"]');

        $responseMock = $this->createMock('Nyholm\Psr7\Response');
        $responseMock->method('getBody')->willReturn($streamMock);
        $responseMock->method('getStatusCode')->willReturn(200);

        $response = new Response($responseMock);

        $this->assertSame(['hello', 'world'], $response->getData());
        $this->assertSame(200, $response->getStatusCode());
    }
}
