## Contacts by segment
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all contacts in a given segment
```php
$client = new Eloqua\Client();
$client->api('contact')->segments($segment_id)->search('*');
```

#### Search for contacts in a given segment by e-mail domain
```php
$client->api('contact')->segments($segment_id)->search('*@example.com');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client->api('contact')->segments($segment_id)->search('*@example.com', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Search for contacts excluded from a given segment
```php
$client->api('contact')->segments($segment_id)->searchExcluded('*');
```

#### Search for contects included in a given segment
```php
$client->api('contact')->segments($segment_id)->searchIncluded('*');
```
