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

### Links

* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3083)
