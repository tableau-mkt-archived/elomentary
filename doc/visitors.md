## Visitors
[Back to the navigation](index.md)

### Usage examples

#### Search for visitors by GUID
```php
$client = new Eloqua\Client();
$client->api('visitors')->search('externalId=123456-7890-abcdef-ghijklmn');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('visitors')->search('contactId=1337', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

### Links

* [API details on Topliners](http://topliners.eloqua.com/community/code_it/blog/2014/07/24/eloqua-rest-api--retrieving-visitor-profiles)
