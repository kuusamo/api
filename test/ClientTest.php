<?php

namespace Kuusamo\Api\Test;

use Kuusamo\Api\Client;
use Kuusamo\Api\Exception\ResponseException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $requestMock = $this->createMock('Nyholm\Psr7\Request');

        $responseMock = $this->createMock('Nyholm\Psr7\Response');
        $responseMock->method('getStatusCode')->willReturn(200);

        $factoryMock = $this->createMock('Nyholm\Psr7\Factory\Psr17Factory');
        $factoryMock->method('createRequest')->willReturn($requestMock);

        $tokenMock = $this->createMock('Kuusamo\Api\Token');

        $networkClient = $this->createMock('Buzz\Client\FileGetContents');
        $networkClient->method('sendRequest')->willReturn($responseMock);

        $client = new Client($tokenMock, 'https://kussamo');
        $client->setPsr17Factory($factoryMock);
        $client->setNetworkClient($networkClient);

        $response = $client->get('/test');

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testError()
    {
        $this->expectException(ResponseException::class);

        $requestMock = $this->createMock('Nyholm\Psr7\Request');

        $streamMock = $this->createMock('Nyholm\Psr7\Stream');
        $streamMock->method('getContents')->willReturn('{"success":false,"message":"Broken"}');

        $responseMock = $this->createMock('Nyholm\Psr7\Response');
        $responseMock->method('getStatusCode')->willReturn(500);
        $responseMock->method('getBody')->willReturn($streamMock);

        $factoryMock = $this->createMock('Nyholm\Psr7\Factory\Psr17Factory');
        $factoryMock->method('createRequest')->willReturn($requestMock);

        $tokenMock = $this->createMock('Kuusamo\Api\Token');

        $networkClient = $this->createMock('Buzz\Client\FileGetContents');
        $networkClient->method('sendRequest')->willReturn($responseMock);

        $client = new Client($tokenMock, 'https://kussamo');
        $client->setPsr17Factory($factoryMock);
        $client->setNetworkClient($networkClient);

        $response = $client->get('/test');
    }
}
