## E-mail header folders
[Back to E-mail headers](../headers.md) | [Back to the navigation](../../index.md)

### Usage examples

#### List all e-mail header folders
```php
$client = new Eloqua\Client();
$client->api('email')->headers()->folders()->search('*');
```

#### Search header folders by name
```php
$client = new Eloqua\Client();
$client->api('email')->headers()->folders()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->headers()->folders()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual folder
```php
$client->api('email')->headers()->folders()->show($folder_id);
```

#### Return partial data on a folder
```php
$client->api('email')->headers()->folders()->show($folder_id, 'partial');
```

#### Update an e-mail header folder
```php
$client->api('email')->headers()->folders()->update($folder_id, $data);
```

#### Delete a folder
```php
$client->api('email')->headers()->folders()->delete($folder_id);
```

#### Create a folder
```php
$client->api('email')->headers()->folders()->create($data);
```

#### Return an e-mail header folder's dependencies
```php
$client->api('email')->headers()->folders()->dependencies($folder_id);
```

#### Return a folder's contents
```php
$client->api('email')->headers()->folders()->contents($folder_id);
```
This may include additional folders or headers.

#### Return the root e-mail header folder
```
$client->api('email')->headers()->folders()->root();
```
