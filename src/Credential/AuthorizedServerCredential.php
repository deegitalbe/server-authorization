<?php
namespace Deegitalbe\ServerAuthorization\Credential;

use Deegitalbe\ServerAuthorization\Facades\Package;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;

class AuthorizedServerCredential implements CredentialContract {
    /**
     * Preparing request.
     */
    public function prepare(RequestContract &$request)
    {
        $request->addHeaders([
            Package::header() => Package::authorization(),
            'X-Requested-With' => "XMLHttpRequest",
            'Accept' => "application/json"
        ]);
    }
}