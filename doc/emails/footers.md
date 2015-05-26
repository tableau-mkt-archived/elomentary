## E-mail footers
[Back to E-mails](../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail footers
```php
$client = new Eloqua\Client();
$client->api('email')->footers()->search('*');
```

#### Search e-mail footers by name
```php
$client = new Eloqua\Client();
$client->api('email')->footers()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->footers()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail footer
```php
$client->api('email')->footers()->show($footer_id);
```

#### Return partial data on an e-mail footer
```php
$client->api('email')->footers()->show($footer_id, 'partial');
```

#### Update an e-mail footer
```php
$client->api('email')->footers()->update($footer_id, $data);
```

#### Delete an e-mail footer
```php
$client->api('email')->footers()->delete($footer_id);
```

#### Create an e-mail footers
```php
$client->api('email')->footers()->create($data);
```

#### Return an e-mail footer's dependencies
```php
$client->api('email')->footers()->dependencies($footer_id);
```

#### Copy and return an e-mail footer
```php
$client->api('email')->footers()->copy($footer_id);
```

#### Show an e-mail footer's security grants
```php
$client->api('email')->footers()->showGrants($footer_id);
```

#### Update an e-mail footer's security grants
```php
$client->api('email')->footers()->updateGrants($footer_id, $grant_data);
```
