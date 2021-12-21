<?php

declare(strict_types=1);

namespace Acme\Api;

use Acme\HttpClient\Message\ResponseMediator;
use JsonException;
use Psr\Http\Message\ResponseInterface;

use function json_encode;

use const JSON_THROW_ON_ERROR;

abstract class AbstractApi extends \Ysato\ApiClientStarter\Api\AbstractApi
{
    /**
     * @return mixed[]|string
     *
     * @throws JsonException
     */
    protected function parse(ResponseInterface $response)
    {
        return ResponseMediator::getContent($response);
    }

    /**
     * @param mixed[] $parameters
     *
     * @throws JsonException
     */
    protected function prepare(array $parameters): ?string
    {
        return empty($parameters) ? null : json_encode($parameters, JSON_THROW_ON_ERROR);
    }
}
