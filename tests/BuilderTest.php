<?php

declare(strict_types=1);

namespace Ysato\ApiClientStarter;

use PHPUnit\Framework\TestCase;
use Ysato\ApiClientStarter\Fake\HttpClient\Plugin\FakePlugin;
use Ysato\ApiClientStarter\HttpClient\Builder;

class BuilderTest extends TestCase
{
    private Builder $SUT;

    protected function setUp(): void
    {
        $this->SUT = new Builder();
    }

    public function testGetHttpClientCallTwice(): void
    {
        $expected = $this->SUT->getHttpClient();

        $this->assertSame($expected, $this->SUT->getHttpClient());
    }

    public function testGetHttpClientAfterAddPlugin(): void
    {
        $expected = $this->SUT->getHttpClient();
        $this->SUT->addPlugin(new FakePlugin());

        $this->assertNotSame($expected, $this->SUT->getHttpClient());
    }

    public function testGetHttpClientAfterRemovePlugin(): void
    {
        $this->SUT->addPlugin(new FakePlugin());
        $expected = $this->SUT->getHttpClient();
        $this->SUT->removePlugin(FakePlugin::class);

        $this->assertNotSame($expected, $this->SUT->getHttpClient());
    }

    public function testGetHttpClientAfterAddHeaderValue(): void
    {
        $expected = $this->SUT->getHttpClient();
        $this->SUT->addHeaderValue('Accept', 'application/json');

        $this->assertNotSame($expected, $this->SUT->getHttpClient());
    }

    public function testGetHttpClientAfterAddHeaders(): void
    {
        $expected = $this->SUT->getHttpClient();
        $this->SUT->addHeaders([
            'Accept' => 'application/json',
            'User-Agent' => 'Mozilla/5.0',
        ]);

        $this->assertNotSame($expected, $this->SUT->getHttpClient());
    }

    public function testGetHttpClientAfterClearHeaders(): void
    {
        $this->SUT->addHeaders([
            'Accept' => 'application/json',
            'User-Agent' => 'Mozilla/5.0',
        ]);
        $expected = $this->SUT->getHttpClient();
        $this->SUT->clearHeaders();

        $this->assertNotSame($expected, $this->SUT->getHttpClient());
    }
}
