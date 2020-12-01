<?php

namespace Kuusamo\Api;

use Kuusamo\Api\Exception\VerificationException;
use Nyholm\Psr7\Request;

class Hmac
{
    private $token;

    /**
     * Constructor.
     *
     * @param Token $token Token.
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Sign a request object.
     *
     * @param Request $request PSR-7 request.
     * @return Request
     */
    public function signRequest(Request $request): Request
    {
        $signature = $this->hashRequest($request);
        $request = $request->withHeader('Kuusamo-Signature', $signature);
        return $request;
    }

    /**
     * Verify a request.
     *
     * @param Request $request PSR-7 request.
     * @param int     $grace   Seconds.
     * @return boolean
     */
    public function verifyRequest(Request $request, int $grace = 2): bool
    {
        if ($request->getHeaderLine('Kuusamo-Version') !== '1.0') {
            throw new VerificationException('Version mismatch');
        }

        if ($grace > 0 && $request->getHeaderLine('Kuusamo-Timestamp') < (time() - $grace)) {
            throw new VerificationException('Timestamp expired');
        }

        $hash = $this->hashRequest($request);

        if (hash_equals($hash, $request->getHeaderLine('Kuusamo-Signature')) === false) {
            throw new VerificationException('Invalid hash');
        }

        return true;
    }

    /**
     * Hash a request object.
     *
     * @param Request $request PSR-7 request.
     * @return string
     */
    private function hashRequest(Request $request): string
    {
        $header = [
            'key' => $request->getHeaderLine('Kuusamo-Key'),
            'version' => $request->getHeaderLine('Kuusamo-Version'),
            'timestamp' => $request->getHeaderLine('Kuusamo-Timestamp'),
            'method' => $request->getMethod(),
            'uri' => $request->getUri()
        ];

        $string = json_encode($header);

        if ($request->getBody() != '') {
            $string .= "\n\n" . $request->getBody();
        }

        return hash_hmac('sha256', $string, $this->token->getSecret());
    }
}
