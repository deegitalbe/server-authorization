# Server authorization
This package is used to authenticate **NON CRITICAL** requests between our applications.
## Installation

    composer require deegitalbe/server-authorization

## Configuration

### Environment
You should define secret key in your `.env` file :

	TRUSTUP_SERVER_AUTHORIZATION=your_secret_key

### Publish configuration
 If you want to have more control about configuration, publish it :

    php artisan vendor:publish --provider="Deegitalbe\ServerAuthorization\Providers\ServerAuthorizationServiceProvider" --tag="config"

## Middleware authenticating incoming request
You can add this middleware to any route that should be protected :

    Deegitalbe\ServerAuthorization\Http\Middleware\AuthorizedServer

## Credential setting up outgoing request
if you use [my client](https://github.com/henrotaym/laravel-api-client) to make requests, you can use this Credential to automatically authenticate your request :

    Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential
### Customizing credential
If you need more control, extend credential this way :

    use Henrotaym\LaravelApiClient\Contracts\RequestContract;
	use Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential;
    
    class  MyCustomCredential  extends  AuthorizedServerCredential  {
    	/**
    	* Preparing request.
    	* 
    	* @param  RequestContract $request
    	* @return  void
    	*/
    	public  function  prepare(RequestContract  &$request)
    	{
    		parent::prepare($request);
    		// your custom code here...
    	}
    }

