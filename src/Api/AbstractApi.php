<?php

declare(strict_types=1);

namespace Ysato\ApiClientStarter\Api;

use Http\Client\Exception as HttpClientException;
use Psr\Http\Message\ResponseInterface;
use Ysato\ApiClientStarter\ClientInterface;

use function count;
use function http_build_query;

use const PHP_QUERY_RFC3986;

abstract class AbstractApi
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    protected function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param mixed[]                        $parameters
     * @param array<string, string|string[]> $requestHeaders
     *
     * @return mixed
     *
     * @throws HttpClientException
     */
    protected function get(string $path, array $parameters = [], array $requestHeaders = [])
    {
        if (count($parameters) > 0) {
            $path .= '?' . http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        $response = $this->client->getHttpClient()->get($path, $requestHeaders);

        return $this->parse($response);
    }

    /**
     * @param mixed[]                 $parameters
     * @param array<string, string[]> $requestHeaders
     *
     * @return mixed
     *
     * @throws HttpClientException
     */
    protected function post(string $path, array $parameters = [], array $requestHeaders = [])
    {
        return $this->postRaw(
            $path,
            $this->prepare($parameters),
            $requestHeaders
        );
    }

    /**
     * @param mixed[] $requestHeaders
     *
     * @return mixed
     *
     * @throws HttpClientException
     */
    protected function postRaw(string $path, ?string $body, array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $requestHeaders,
            $body
        );

        return $this->parse($response);
    }

    /**
     * @param mixed[]                        $parameters
     * @param array<string, string|string[]> $requestHeaders
     *
     * @return mixed
     *
     * @throws HttpClientException
     */
    protected function patch(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $requestHeaders,
            $this->prepare($parameters)
        );

        return $this->parse($response);
    }

    /**
     * @param mixed[]                        $parameters
     * @param array<string, string|string[]> $requestHeaders
     *
     * @return mixed
     *
     * @throws HttpClientException
     */
    protected function put(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->put(
            $path,
            $requestHeaders,
            $this->prepare($parameters)
        );

        return $this->parse($response);
    }

    /**
     * @param mixed[]                        $parameters
     * @param array<string, string|string[]> $requestHeaders
     *
     * @return mixed
     *
     * @throws HttpClientException
     */
    protected function delete(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->delete(
            $path,
            $requestHeaders,
            $this->prepare($parameters)
        );

        return $this->parse($response);
    }

    /**
     * @return mixed
     */
    abstract protected function parse(ResponseInterface $response);

    /**
     * @param mixed[] $parameters
     */
    abstract protected function prepare(array $parameters): ?string;
}
