<?php

declare(strict_types=1);

namespace Acme\ExampleApi;

use Acme\ExampleApi\Api\AbstractApi;
use BadMethodCallException;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Ysato\ApiClientStarter\ClientInterface;
use Ysato\ApiClientStarter\HttpClient\Builder;
use Ysato\ApiClientStarter\HttpClient\Plugin\PathPrepend;

use function sprintf;

/**
 * @method Api\Article article()
 */
class Client implements ClientInterface
{
    private Builder $httpClientBuilder;

    public function __construct(?Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(
            new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri('https://acme.example.com'))
        );
        $builder->addPlugin(new PathPrepend('/api'));
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    public function api(string $name): AbstractApi
    {
        switch ($name) {
            case 'article':
                return new Api\Article($this);
        }

        throw new InvalidArgumentException();
    }

    /**
     * @param mixed[] $args
     */
    public function __call(string $name, array $args): AbstractApi
    {
        unset($args);

        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}
