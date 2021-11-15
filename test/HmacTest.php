<?php

namespace Kuusamo\Api\Test;

use Kuusamo\Api\Hmac;
use PHPUnit\Framework\TestCase;
use DG\BypassFinals;

class HmacTest extends TestCase
{
    public function setUp(): void
    {
        BypassFinals::enable();
    }

    public function testSignRequest()
    {
        $tokenMock = $this->createMock('Kuusamo\Api\Token');
        $requestMock = $this->createMock('Nyholm\Psr7\Request');

        $requestMock->expects($this->once())->method('withHeader')->with('Kuusamo-Signature');

        $hmac = new Hmac($tokenMock);
        $request = $hmac->signRequest($requestMock);
    }

    public function testVerifyRequest()
    {
        $tokenMock = $this->createMock('Kuusamo\Api\Token');

        $requestMock = $this->createMock('Nyholm\Psr7\Request');
        $requestMock->method('getHeaderLine')->will($this->onConsecutiveCalls(
            '1.0',
            'test-key',
            '1.0',
            '1262304000',
            '5f67542c540e00d58da4ea6f664c6f9dadb9cef93287b76f440f4afe8883549b'
        ));

        $hmac = new Hmac($tokenMock);
        $result = $hmac->verifyRequest($requestMock, 0);
        $this->assertSame(true, $result);
    }
}
