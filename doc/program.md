## Programs
[Back to the navigation](index.md)

### Usage examples

#### Search for programs with a given name
```php
$client = new Eloqua\Client();
$client->api('programs')->search('Never Gonna Give*');
```

#### Return a single program by a given ID
```php
$client->api('program')->show($programID);
```
