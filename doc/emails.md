## Emails
[Back to the navigation](index.md)

### Usage examples

#### Search for emails with a given search term
```php
$client = new Eloqua\Client();
$client->api('emails')->search('Never Gonna Give*');
```

#### View / manage e-mail groups
```php
$groups = $client->api('email')->groups();
```
For more details, see documentation on
[e-mail groups](emails/groups.md).

#### View / manage e-mail deployments
```php
$deployments = $client->api('email')->deployments();
```
For more details, see documentation on
[e-mail deployments](emails/deployments.md).

#### Return a single e-mail by a given ID
```php
$client->api('email')->show($email_id);
```

#### Return partial data on an e-mail
```php
$client->api('email')->show($email_id, 'partial');
```

#### Create an e-mail with a given name and array of options
```php
$client->api('email')->create('Elomentary Test', array(
  'folderId' => 123,
  'emailGroupId' => 123,
  'subject' => 'Elomentary Test Subject',
));
```

#### Update an e-mail with a given ID and array of e-mail data
```php
$client->api('email')->update(123, array(
  'folderId' => 123,
  'emailGroupId' => 123,
  'subject' => 'Elomentary Test Subject',
));
```

#### Remove a single e-mail by a given ID
```php
$client->api('email')->remove($email_id);
```

### Links
* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3083)
