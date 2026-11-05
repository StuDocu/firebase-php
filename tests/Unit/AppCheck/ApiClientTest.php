<?php

declare(strict_types=1);

namespace Kreait\Firebase\Tests\Unit\AppCheck;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kreait\Firebase\AppCheck\ApiClient;
use Kreait\Firebase\Exception\AppCheckException;
use Kreait\Firebase\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * @internal
 */
final class ApiClientTest extends UnitTestCase
{
    #[Test]
    public function consumeTokenSendsTheTokenToTheVerifyEndpointOfTheProject(): void
    {
        $mock = new MockHandler([new Response(200, [], '{"alreadyConsumed": true}')]);

        $result = (new ApiClient($this->clientWith($mock), 'my-project'))->consumeToken('the-app-check-token');

        $this->assertSame(['alreadyConsumed' => true], $result);

        $request = $mock->getLastRequest();
        $this->assertNotNull($request);
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame(
            'https://firebaseappcheck.googleapis.com/v1beta/projects/my-project:verifyAppCheckToken',
            (string) $request->getUri(),
        );
        $this->assertSame(['appCheckToken' => 'the-app-check-token'], json_decode((string) $request->getBody(), true));
    }

    #[Test]
    public function consumeTokenReturnsAnEmptyResultForAFirstUse(): void
    {
        $mock = new MockHandler([new Response(200, [], '{}')]);

        $result = (new ApiClient($this->clientWith($mock), 'my-project'))->consumeToken('the-app-check-token');

        $this->assertSame([], $result);
    }

    #[Test]
    public function consumeTokenConvertsApiErrors(): void
    {
        $mock = new MockHandler([new Response(403, [], '{"error": {"message": "denied"}}')]);

        $this->expectException(AppCheckException::class);

        (new ApiClient($this->clientWith($mock), 'my-project'))->consumeToken('the-app-check-token');
    }

    private function clientWith(MockHandler $mock): Client
    {
        return new Client(['handler' => HandlerStack::create($mock)]);
    }
}
