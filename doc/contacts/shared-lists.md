## Shared Lists
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all shared lists
```php
$client = new Eloqua\Client();
$client->api('contact')->sharedLists()->search('*');
```

#### Search shared lists by name
```php
$client->api('contact')->sharedLists()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "complete" depth
```php
$client->api('contact')->sharedLists()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'complete'
));
```

#### Return an individual shared list
```php
$client->api('contact')->sharedLists()->show($list_id);
```

#### Return partial data for a shared list
```php
$client->api('contact')->sharedLists()->show($list_id, 'partial');
```

#### Update a shared list
```php
$client->api('contact')->sharedLists()->update($list_id, $data);
```

#### Delete a shared list
```php
$client->api('contact')->sharedLists()->delete($list_id);
```

#### Create a shared list
```php
$client->api('contact')->sharedLists()->create($data);
```

#### Return a shared list's dependencies
```php
$client->api('contact')->sharedLists()->dependencies($list_id);
```
