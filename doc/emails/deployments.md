## E-mail groups
[Back to E-mails](../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail deployments
```php
$client = new Eloqua\Client();
$client->api('email')->deployments()->search('*');
```

#### Search e-mail deployments by name
```php
$client = new Eloqua\Client();
$client->api('email')->deployments()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->deployments()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail deployment
```php
$client->api('email')->deployments()->show($deployment_id);
```

#### Create an e-mail deployment
```php
$client->api('email')->deployments()->create($data);
```

[all Minimal EmailDeployment keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#EmailDeployment
