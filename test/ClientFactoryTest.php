<?php

namespace Kuusamo\Api\Test;

use Kuusamo\Api\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientFactoryTest extends TestCase
{
    public function testCreate()
    {
        $client = ClientFactory::create('test-key', 'test-secret', 'url');
        $this->assertInstanceOf('Kuusamo\Api\Client', $client);
    }
}
