<?php

declare(strict_types=1);

namespace Acme\Api\Article;

use Acme\Api\AbstractApi;
use Http\Client\Exception;

class Comments extends AbstractApi
{
    /**
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function all(int $articleId): array
    {
        return $this->get("/articles/{$articleId}/comments");
    }

    /**
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function show(int $id): array
    {
        return $this->get("/comments/{$id}");
    }
}
