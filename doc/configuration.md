## Configuration and testing
[Back to the navigation](index.md)

### Configure the http client

#### Change the HTTP client user-agent string
```php
$client->getHttpClient()->setOption('user_agent', 'My new User Agent');
```
Check `Eloqua/HttpClient/HttpClient.php` for a list of all available options.

#### Inject a new http client instance
By default, a curl-based implementation of a http client is used. If you want to
use your own http client implementation, inject it to the `Eloqua\Client`
instance:

```php
use Eloqua\HttpClient\HttpClient;

// Create a custom http client
class MyHttpClient extends HttpClient {
  public function request($url, array $parameters = array(), $httpMethod = 'GET', array $headers = array()) {
    // send the request and return the raw response
  }
}
```

> Your http client implementation may not extend `Eloqua\HttpClient\HttpClient`, but only implement `Eloqua\HttpClient\HttpClientInterface`.

You can now inject your http client through `Eloqua\Client:setHttpClient()`
method:

```php
$client = new Eloqua\Client();
$client->setHttpClient(new MyHttpClient());
```

#### Run test suite
The code is unit tested. To run tests on your machine, from a CLI, run...

```bash
$ phpunit
```
