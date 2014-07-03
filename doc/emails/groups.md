## E-mail groups
[Back to E-mails](../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail groups
```php
$client = new Eloqua\Client();
$client->api('email')->groups()->search('*');
```

#### Search e-mail groups by name
```php
$client = new Eloqua\Client();
$client->api('email')->groups()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->groups()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail group
```php
$client->api('email')->groups()->show($group_id);
```

#### Return partial data on an e-mail group
```php
$client->api('email')->groups()->show($group_id, 'partial');
```

#### Update an e-mail group
```php
$client->api('email')->groups()->update($group_id, $data);
```
Note that `$data` must include [all Minimal EmailGroup keys](); partial data
will not suffice.

#### Delete an e-mail group
```php
$client->api('email')->groups()->delete($group_id);
```

#### Create an e-mail group
```php
$client->api('email')->groups()->create($data);
```

#### Return an e-mail group's dependencies
```php
$client->api('email')->groups()->dependencies($group_id);
```

[all Minimal EmailGroup keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#EmailGroup
