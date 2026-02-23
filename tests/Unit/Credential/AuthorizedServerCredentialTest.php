<?php
namespace Deegitalbe\ServerAuthorization\Tests\Unit\Credential;

use PHPUnit\Framework\Attributes\Test;
use Deegitalbe\ServerAuthorization\Tests\TestCase;
use Deegitalbe\ServerAuthorization\Facades\Package;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential;

class AuthorizedServerCredentialTest extends TestCase
{
    #[Test]
    public function authorized_server_credential_preparing_request()
    {
        // Faking package values
        $authorization = ':test';
        $header = "X-TEST-HEADER";

        // Mocking package calls
        Package::shouldReceive('authorization')
                ->andReturn($authorization)
            ->shouldReceive('header')
                ->andReturn($header);

        // Mocking request
        $this->mockThis(RequestContract::class)
            ->shouldReceive('addHeaders')
            ->once()
            ->withArgs(function($headers) use ($authorization, $header) {
                return $headers === [
                    $header => $authorization,
                    'X-Requested-With' => "XMLHttpRequest",
                    'Accept' => "application/json"
                ];
            });

        $request = app()->make(RequestContract::class);
        (new AuthorizedServerCredential())->prepare($request);
    }
}
