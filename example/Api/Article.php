<?php

declare(strict_types=1);

namespace Acme\Api;

use Acme\Api\Article\Comments;
use Http\Client\Exception;

class Article extends AbstractApi
{
    /**
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function all(): array
    {
        return $this->get('/products');
    }

    public function comments(): Comments
    {
        return new Comments($this->getClient());
    }
}
