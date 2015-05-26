## E-mail headers
[Back to E-mails](../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail headers
```php
$client = new Eloqua\Client();
$client->api('email')->headers()->search('*');
```

#### Search e-mail headers by name
```php
$client = new Eloqua\Client();
$client->api('email')->headers()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->headers()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail header
```php
$client->api('email')->headers()->show($header_id);
```

#### Return partial data on an e-mail header
```php
$client->api('email')->headers()->show($header_id, 'partial');
```

#### Update an e-mail header
```php
$client->api('email')->headers()->update($header_id, $data);
```

#### Delete an e-mail header
```php
$client->api('email')->headers()->delete($header_id);
```

#### Create an e-mail header
```php
$client->api('email')->headers()->create($data);
```

#### Return an e-mail header's dependencies
```php
$client->api('email')->headers()->dependencies($header_id);
```

#### Copy and return an e-mail header
```php
$client->api('email')->headers()->copy($header_id);
```

#### Show an e-mail header's security grants
```php
$client->api('email')->headers()->showGrants($header_id);
```

#### Update an e-mail header's security grants
```php
$client->api('email')->headers()->updateGrants($header_id, $grant_data);
```
