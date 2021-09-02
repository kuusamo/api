<?php

namespace Kuusamo\Api;

use Kuusamo\Api\Exception\ResponseException;
use Buzz\Client\FileGetContents;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;

class Client
{
    private $token;
    private $baseUri;
    private $psr17Factory;
    private $networkClient;

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
     * Set the PSR-17 factory to use.
     *
     * @param Psr17Factory $factory Factory.
     * @return void
     */
    public function setPsr17Factory(Psr17Factory $factory)
    {
        $this->psr17Factory = $factory;
    }

    /**
     * Set the network client to use.
     *
     * @param ClientInterface $client Client.
     * @return void
     */
    public function setNetworkClient(ClientInterface $client)
    {
        $this->networkClient = $client;
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

        $factory = $this->psr17Factory ?: new Psr17Factory;
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

        $client = $this->networkClient ?: new FileGetContents($factory);
        $networkResponse = $client->sendRequest($request);
        $response = new Response($networkResponse);

        if ($response->getStatusCode() >= 400) {
            throw new ResponseException($response->getData()->message);
        }

        return $response;
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
