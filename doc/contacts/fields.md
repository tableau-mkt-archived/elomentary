## Contact fields
[Back to E-mails](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all contact fields
```php
$client = new Eloqua\Client();
$client->api('contact')->fields()->search('*');
```

#### Search contact fields by name
```php
$client = new Eloqua\Client();
$client->api('contact')->fields()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "complete" depth
```php
$client = new Eloqua\Client();
$client->api('contact')->fields()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'complete'
));
```

#### Return an individual contact field
```php
$client->api('contact')->fields()->show($field_id);
```

#### Return partial data on a contact field
```php
$client->api('contact')->fields()->show($field_id, 'partial');
```

#### Update a contact field
```php
$client->api('contact')->fields()->update($field_id, $data);
```
Note that `$data` must include [all Minimal ContactField keys](); partial data
will not suffice.

#### Delete a contact field
```php
$client->api('contact')->fields()->delete($field_id);
```

#### Create a contact field
```php
$client->api('contact')->fields()->create($data);
```

#### Return a contact field's dependencies
```php
$client->api('contact')->fields()->dependencies($field_id);
```

[all Minimal ContactField keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#ContactField
