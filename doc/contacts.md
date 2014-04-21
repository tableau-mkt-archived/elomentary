## Contacts
[Back to the navigation](index.md)

### Usage examples

Search for contacts ending with a given domain.

```php
$client = new Eloqua\Client();
$client->api('contacts')->search('*@example.com');
```

Limit your search to pages of 10 results at "minimal" depth.

```php
$client = new Eloqua\Client();
$client->api('contacts')->search('*@example.com', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

Get a single contact by a given ID.

```php
$client->api('contact')->show($contact_id);
```

Get a single contact's subscriptions.

```php
$client->api('contact')->subscriptions($contact_id);
```

### Links

* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3070)
