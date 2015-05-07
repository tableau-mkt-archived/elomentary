## E-mail folders
[Back to E-mails](../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail folders
```php
$client = new Eloqua\Client();
$client->api('email')->folders()->search('*');
```

#### Search e-mail folders by name
```php
$client = new Eloqua\Client();
$client->api('email')->folders()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->folders()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail folder
```php
$client->api('email')->folders()->show($folder_id);
```

#### Return partial data on an e-mail folder
```php
$client->api('email')->folders()->show($folder_id, 'partial');
```

#### Update an e-mail folder
```php
$client->api('email')->folders()->update($folder_id, $data);
```

#### Delete an e-mail folder
```php
$client->api('email')->folders()->delete($folder_id);
```

#### Create an e-mail folder
```php
$client->api('email')->folders()->create($data);
```

#### Return an e-mail folder's dependencies
```php
$client->api('email')->folders()->dependencies($folder_id);
```

#### Return an e-mail folder's contents
```php
$client->api('email')->folders()->contents($folder_id);
```
This may include additional folders or e-mails.

#### Return the root e-mail folder
```
$client->api('email')->folders()->root();
```
