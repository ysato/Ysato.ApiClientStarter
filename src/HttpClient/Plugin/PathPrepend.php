<?php

declare(strict_types=1);

namespace Ysato\ApiClientStarter\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

use function strpos;

class PathPrepend implements Plugin
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param callable(RequestInterface): Promise $next
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        unset($first);

        $currentPath = $request->getUri()->getPath();
        if (strpos($currentPath, $this->path) !== 0) {
            $uri = $request->getUri()->withPath($this->path . $currentPath);
            $request = $request->withUri($uri);
        }

        return $next($request);
    }
}
