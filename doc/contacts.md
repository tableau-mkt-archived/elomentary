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

#### Get a single, partial contact by a given ID
```php
$client->api('contact')->show($contact_id, 'partial');
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
For more details, see documentation on
[e-mail group subscriptions by contact](contacts/subscriptions.md).

#### Search / export contacts in a given contact list
```php
$list = $client->api('contact')->lists($list_id);
```
For more details, see documentation on [contact lists](contacts/list.md).

#### Search / export contacts in a given segment
```php
$segment = $client->api('contact')->segments($segment_id);
```
For more details, see documentation on [contact segments](contacts/segment.md)

#### Search / export contacts that match a given contact filter
```php
$filter = $client->api('contact')->filters($filter_id);
```
For more details, see documentation on [contact filters](contacts/filters.md).

#### Search and load contact view data
```php
$view = $client->api('contact')->views($view_id);
```
For more details, see documentation on [contact views](contacts/views.md).

#### Search / manage contact fields
```php
$fields = $client->api('contact')->fields();
```
For more details, see documentation on [contact fields](contacts/fields.md).

#### Search / manage shared lists
```php
$lists = $client->api('contact')->sharedLists();
```
For more details, see documentation on [shared lists](contacts/shared-lists.md).

#### Bulk operations on Contacts
```php
$bulk_client = $client->api('contact')->bulk();
```
For more details on interacting with Eloqua contacts in bulk, see documentation
on [bulk contacts](contacts/bulk.md).

### Links

* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3070)

[all Minimal Contact keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#Contact
