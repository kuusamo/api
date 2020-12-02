<?php

namespace Kuusamo\Api;

use Buzz\Client\FileGetContents;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;

class Client
{
    private $token;
    private $baseUri;

    /**
     * Constructor.
     *
     * @param Token  $token Token.
     * @param string $uri   URL of Kuusamo install.
     */
    public function __construct(Token $token, string $url)
    {
        $this->token = $token;
        $this->baseUri = $url;
    }

    /**
     * Send a request.
     *
     * @param string $method GET, POST, PUT, DELETE
     * @param string $path   URI
     * @param mixed  $data   JSON-encodable data
     * @return Response
     */
    private function request(string $method, string $path, $data = null): Response
    {
        $url = $this->baseUri . $path;

        $factory = new Psr17Factory;
        $request = $factory->createRequest($method, $url);
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withHeader('Kuusamo-Key', $this->token->getKey());
        $request = $request->withHeader('Kuusamo-Version', '1.0');
        $request = $request->withHeader('Kuusamo-Timestamp', time());

        if ($data) {
            $stream = $factory->createStream(json_encode($data));
            $request = $request->withBody($stream);
        }

        $hmac = new Hmac($this->token);
        $request = $hmac->signRequest($request);

        $client = new FileGetContents($factory);
        return $client->sendRequest($request);
    }

    /**
     * Make a GET request.
     *
     * @param string $path Path.
     * @return Response
     */
    public function get(string $path): Response
    {
        return $this->request('GET', $path);
    }

    /**
     * Make a POST request.
     *
     * @param string $path Path.
     * @param mixed  $data JSON-encodable data.
     * @return Response
     */
    public function post(string $path, $data): Response
    {
        return $this->request('POST', $path, $data);
    }
}
