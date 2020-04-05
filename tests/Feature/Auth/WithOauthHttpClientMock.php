<?php

namespace Thtg88\MmCms\Tests\Feature\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Mockery as m;
use Thtg88\MmCms\Repositories\UserRepository;

trait WithOauthHttpClientMock
{
    protected function mockOauthHttpClient(
        string $email,
        bool $skip_existence_check = false
    ): self {
        if ($skip_existence_check === true) {
            $user = app()->make(UserRepository::class)
                ->findByModelName(strtolower($email));

            if ($user === null) {
                throw new InvalidArgumentException(
                    'The email provided does not have a corresponding user'.
                    ' in the database. Please create one before continuing'
                );
            }
        }

        $app = Container::getInstance();

        // Mock OAuth Passport HTTP Client
        $mock = new MockHandler([
            new GuzzleResponse(200, ['Content-Type' => 'application/json'], json_encode([
                'token_type' => 'Bearer',
                'expires_in' => 31536000,
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
            ]))
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $app->instance('OauthHttpClient', $client);

        return $this;
    }

    protected function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }
}
