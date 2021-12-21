<?php

declare(strict_types=1);

namespace Ysato\ApiClientStarter;

use Http\Client\Common\HttpMethodsClientInterface;

interface ClientInterface
{
    public function getHttpClient(): HttpMethodsClientInterface;
}
