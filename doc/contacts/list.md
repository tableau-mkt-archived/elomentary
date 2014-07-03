## Contacts by contact list
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all contacts in a given list
```php
$client = new Eloqua\Client();
$client->api('contact')->lists($list_id)->search('*');
```

#### Search for contacts in a given list by e-mail domain
```php
$client->api('contact')->lists($list_id)->search('*@example.com');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client->api('contact')->lists($list_id)->search('*@example.com', array(
  'count' => 10,
  'depth' => 'minimal'
));
```
