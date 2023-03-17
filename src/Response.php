<?php

namespace Kuusamo\Api;

use Nyholm\Psr7\Response as PsrResponse;

class Response
{
    private $psrResponse;
    private $jsonData;
    private $jsonArray;

    /**
     * Constructor.
     *
     * @param PsrResponse $psrResponse PSR-7 compatible response.
     */
    public function __construct(PsrResponse $psrResponse)
    {
        $this->psrResponse = $psrResponse;
    }

    /**
     * Get JSON data.
     *
     * @return object|array
     */
    public function getData()
    {
        if ($this->jsonData === null) {
            $this->jsonData = json_decode(
                $this->psrResponse->getBody()->getContents()
            );
        }

        return $this->jsonData;
    }

    /**
     * Get JSON data as associative array.
     *
     * @return array
     */
    public function getArray()
    {
        if ($this->jsonArray === null) {
            $this->jsonArray = json_decode(
                $this->psrResponse->getBody()->getContents(),
                true
            );
        }

        return $this->jsonArray;
    }

    /**
     * Get a raw response.
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->psrResponse->getBody()->getContents();
    }

    /**
     * Get the status code.
     *
     * @return int Status code.
     */
    public function getStatusCode(): int
    {
        return $this->psrResponse->getStatusCode();
    }
}
