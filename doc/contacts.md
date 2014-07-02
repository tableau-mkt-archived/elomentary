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

Update/replace a single contact of a given ID.
```php
$client->api('contact')->update($contact_id, $contact_data);
```
Note that `$contact_data` must include [all Minimal Contact keys]; partial data
will not suffice.

Delete a single contact of a given ID.
```php
$client->api('contact')->remove($contact_id);
```

Get a single contact's subscriptions.

```php
$client->api('contact')->subscriptions($contact_id);
```

### Links

* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3070)

[all Minimal Contact keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#Contact
