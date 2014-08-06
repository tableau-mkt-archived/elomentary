## Option Lists
OptionLists provide an API into the drop-down lists associated with Eloqua
contacts
[Back to the navigation](index.md)

### Usage examples

#### Search for OptionLists with a given name
```php
$client = new Eloqua\Client();
$client->api('optionList')->search('Never Gonna Give*');
```

#### Return a single OptionList by a given ID
```php
$client->api('optionList')->show($optionList_id);
```

#### Create a new OptionList
```php
$client->api('optionList')->create(array(
  'name' => 'Elomentary Test',
  'elements' => array (
    array ('displayName' => '1 - 2 million', 'value' => '1M-2M'),
    array ('displayName' => '2 - 3 million', 'value' => '2M-3M'),
  )
));
```

#### Update an OptionList with a given ID and new OptionList array
```php
$client->api('optionList')->update(1337, array(
  'id' => 1337,
  'name' => 'Elomentary Test v2',
  'elements' => array (
    array ('displayName' => '1 - 2 billion', 'value' => '1B-2B'),
    array ('displayName' => '2 - 3 billion', 'value' => '2B-3B'),
  )
));
```

#### Remove an OptioniList by a given ID
```php
$client->api('optionList')->remove($optionList_id);
```

### Links
* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3588)
