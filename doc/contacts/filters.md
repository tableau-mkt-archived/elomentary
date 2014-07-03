## Contacts by contact filter
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all contacts that match a certain filter
```php
$client = new Eloqua\Client();
$client->api('contact')->filters($filter_id)->search('*');
```

#### Search for contacts that match a certain filter by e-mail domain
```php
$client->api('contact')->filters($filter_id)->search('*@example.com');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client->api('contact')->filters($filter_id)->search('*@example.com', array(
  'count' => 10,
  'depth' => 'minimal'
));
```
