## Contacts
[Back to the navigation](index.md)

### Usage examples

#### Search for contacts ending with a given domain
```php
$client = new Eloqua\Client();
$client->api('contacts')->search('*@example.com');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('contacts')->search('*@example.com', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Get a single contact by a given ID
```php
$client->api('contact')->show($contact_id);
```

#### Update/replace a single contact of a given ID
```php
$client->api('contact')->update($contact_id, $contact_data);
```
Note that `$contact_data` must include [all Minimal Contact keys]; partial data
will not suffice.

#### Delete a single contact of a given ID
```php
$client->api('contact')->remove($contact_id);
```

#### Create a contact
```php
$contact_data = array(
  // At a minimum, must include the "emailAddress" key.
  'emailAddress' => 'foobar@example.com',
  'firstName' => 'Foo',
);
$client->api('contact')->create($contact_data);
```
This will throw an InvalidArgumentException if an e-mail address isn't provided.

#### View / manage e-mail group subscriptions for a specific contact
```php
$subscriptions = $client->api('contact')->subscriptions($contact_id);
```
Fore more details, see documentation on
[e-mail group subscriptions by contact](contacts/subscriptions.md).

### Links

* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3070)

[all Minimal Contact keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#Contact
