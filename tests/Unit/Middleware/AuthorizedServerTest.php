<?php
namespace Deegitalbe\ServerAuthorization\Tests\Unit\Middleware;

use Mockery\MockInterface;
use Illuminate\Http\Request;
use Illuminate\Testing\TestResponse;
use Deegitalbe\ServerAuthorization\Tests\TestCase;
use Deegitalbe\ServerAuthorization\Facades\Package;
use Deegitalbe\ServerAuthorization\Http\Middleware\AuthorizedServer;

class AuthorizedServerTest extends TestCase
{
    /**
     * @test
     */
    public function authorized_server_middleware_stopping_if_no_authorization_key_and_request_not_having_header()
    {
        $response = $this->getResponse($this->requestWithoutHeader());

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function authorized_server_middleware_stopping_if_request_not_having_header_but_having_authorization_key()
    {
        $this->withAuthorizationValue();
        $response = $this->getResponse($this->requestWithoutHeader());

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function authorized_server_middleware_stopping_if_request_having_header_but_no_authorization_key()
    {
        $response = $this->getResponse($this->requestWithHeader());

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function authorized_server_middleware_stopping_if_request_having_null_header_value_and_authorization_key_having_null_value()
    {
        $this->withAuthorizationValue(null);
        $response = $this->getResponse($this->requestWithHeader(null));

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function authorized_server_middleware_letting_through_if_request_having_header_value_and_authorization_key_having_same_value()
    {
        $this->withAuthorizationValue();
        $response = $this->getResponse($this->requestWithHeader());

        $response->assertOk();
    }

    /**
     * Setting up authorization value to given value.
     * 
     * @param null|string $secret
     * @return self
     */
    protected function withAuthorizationValue(?string $secret = ":test"): self
    {
        $this->getPackageMock()
            ->shouldReceive('authorization')
            ->andReturn($secret);

        return $this;
    }

    /**
     * Mocked package facade.
     * 
     * @return null|MockInterface
     */
    protected $package_mock;

    /**
     * Getting mocked package facade.
     * 
     * @return MockInterface
     */
    protected function getPackageMock(): MockInterface
    {
        if (!$this->package_mock):
            return $this->package_mock = Package::partialMock();
        endif;

        return $this->package_mock;
    }

    /**
     * Setting up a request with authorization header.
     * 
     * @param string|null $header_value
     * @return Request
     */
    protected function requestWithHeader(?string $header_value = ":test"): Request
    {
        $this->getPackageMock()
            ->shouldReceive('header')
            ->andReturn("X-TEST-HEADER");

        $request = new Request;
        $request->headers->set(Package::header(), $header_value);
        
        return $request;
    }

    /**
     * Setting up a request without authorization header.
     * 
     * @return Request
     */
    protected function requestWithoutHeader(): Request
    {
        return new Request;
    }

    /**
     * Getting middleware response for given request.
     * 
     * @param Request $request
     * @return TestResponse
     */
    protected function getResponse(Request $request): TestResponse
    {
        return new TestResponse(
            app()->make(AuthorizedServer::class)
                ->handle($request, function() { return response('ok', 200); })
        );
    }
}