## E-mail group subscriptions by contact
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail group subscriptions for a given contact
```php
$client = new Eloqua\Client();
$client->api('contacts')->subscriptions($contact_id)->search('');
```

#### Search a contact's e-mail group subscriptions
```php
$client = new Eloqua\Client();
$client->api('contacts')->subscriptions($contact_id)->search('Example Name');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('contacts')->subscriptions($contact_id)->search('*Example Name*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Get an e-mail group subscription for a given contact / group
```php
$client->api('contact')->subscriptions($contact_id)->show($group_id);
```

#### Update an e-amil group subscription for a given contact / group
```php
$client->api('contact')->subscriptions($contact_id)->update($group_id, $data);
```
Note that `$data` must include [all Minimal ContactEmailSubscription keys];
partial data will not suffice.

[all Minimal ContactEmailSubscription keys]: http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#ContactEmailSubscription
