<?php

declare(strict_types=1);

namespace Ysato\ApiClientStarter\Fake\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

class FakePlugin implements Plugin
{
    /**
     * @param callable(RequestInterface): Promise $next
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        unset($first);

        return $next($request);
    }
}
