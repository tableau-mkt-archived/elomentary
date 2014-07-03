## E-mail group subscriptions by contact
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

Return a list of all e-mail group subscriptions associated with a given contact.

```php
$client = new Eloqua\Client();
$client->api('contacts')->subscriptions($contact_id)->search('');
```

Search for a contact's subscription to an e-mail group with a specific name.

```php
$client = new Eloqua\Client();
$client->api('contacts')->subscriptions($contact_id)->search('Example Name');
```

Limit your search to pages of 10 results at "minimal" depth.

```php
$client = new Eloqua\Client();
$client->api('contacts')->subscriptions($contact_id)->search('*Example Name*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

Get a single e-mail group subscription for a given contact by a given group ID.

```php
$client->api('contact')->subscriptions($contact_id)->show($group_id);
```

Update a single e-mail group subscription for a given contact / group ID.
```php
$client->api('contact')->subscriptions($contact_id)->update($group_id, $data);
```
Note that `$data` must include [all Minimal ContactEmailSubscription keys];
partial data will not suffice.

[all Minimal ContactEmailSubscription keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#ContactEmailSubscription
