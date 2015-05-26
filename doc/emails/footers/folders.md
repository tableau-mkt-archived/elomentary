## E-mail footer folders
[Back to E-mail footers](../footers.md) | [Back to the navigation](../../index.md)

### Usage examples

#### List all e-mail footer folders
```php
$client = new Eloqua\Client();
$client->api('email')->footers()->folders()->search('*');
```

#### Search footer folders by name
```php
$client = new Eloqua\Client();
$client->api('email')->footers()->folders()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->footers()->folders()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual folder
```php
$client->api('email')->footers()->folders()->show($folder_id);
```

#### Return partial data on a folder
```php
$client->api('email')->footers()->folders()->show($folder_id, 'partial');
```

#### Update an e-mail footer folder
```php
$client->api('email')->footers()->folders()->update($folder_id, $data);
```

#### Delete a folder
```php
$client->api('email')->footers()->folders()->delete($folder_id);
```

#### Create a folder
```php
$client->api('email')->footers()->folders()->create($data);
```

#### Return an e-mail footer folder's dependencies
```php
$client->api('email')->footers()->folders()->dependencies($folder_id);
```

#### Return a folder's contents
```php
$client->api('email')->footers()->folders()->contents($folder_id);
```
This may include additional folders or footers.

#### Return the root e-mail footer folder
```
$client->api('email')->footers()->folders()->root();
```
