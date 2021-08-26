<?php

namespace Kuusamo\Api;

use Nyholm\Psr7\Response as PsrResponse;

class Response
{
    private $psrResponse;

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
        return json_decode($this->psrResponse->getBody()->getContents());
    }
}
