<?php

declare(strict_types=1);

namespace Ysato\ApiClientStarter\HttpClient\Plugin;

use GuzzleHttp\Psr7\Request;
use Http\Promise\FulfilledPromise;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class PathPrependTest extends TestCase
{
    private PathPrepend $SUT;

    protected function setUp(): void
    {
        $this->SUT = new PathPrepend('/api');
    }

    public function testPrependPath(): void
    {
        $request = new Request('GET', 'https://example.com');
        $next = function (RequestInterface $request) {
            $this->assertSame('https://example.com/api', (string) $request->getUri());

            return new FulfilledPromise('success');
        };
        $first = static fn() => 'do nothing';

        $this->SUT->handleRequest($request, $next, $first);
    }

    public function testPrependPathAlreadyPrepended(): void
    {
        $request = new Request('GET', 'https://example.com/api');
        $next = function (RequestInterface $request) {
            $this->assertSame('https://example.com/api', (string) $request->getUri());

            return new FulfilledPromise('success');
        };
        $first = static fn() => 'do nothing';

        $this->SUT->handleRequest($request, $next, $first);
    }
}
