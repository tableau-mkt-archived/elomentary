## Authentication
[Back to the navigation](index.md)

All Eloqua services use HTTP basic authentication; before you run any requests
against the API, you will need to authenticate.

### Authenticate
```php
$client->authenticate($site, $login, $password, $baseUrl);
```

`$site` is the name of the Eloqua instance to which you are authenticating; it's
often a variation on the name of your company. `$login` and `$password` should
be self-explanatory.  `$baseUrl` is your Eloqua endpoint URL, it is optional.  If
`$baseUrl` is excluded, https://secure.eloqua.com will be used.

After executing the `$client->authenticate($site, $login, $password);` method
using correct credentials, all further requests are done as the given user.
