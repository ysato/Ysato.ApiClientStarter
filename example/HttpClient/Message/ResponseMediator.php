<?php

declare(strict_types=1);

namespace Acme\HttpClient\Message;

use JsonException;
use Psr\Http\Message\ResponseInterface;

use function json_decode;
use function strpos;

use const JSON_THROW_ON_ERROR;

class ResponseMediator
{
    /**
     * @return mixed[]|string
     *
     * @throws JsonException
     */
    public static function getContent(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        }

        return $body;
    }
}
