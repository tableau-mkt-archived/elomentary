## Custom Objects
[Back to the navigation](index.md)

### Usage examples

#### Search for custom objects by name
```php
$client = new Eloqua\Client();
$client->api('customObject')->search('Never Gonna Let*');
```

#### Return a single custom object by a given ID
```php
$client->api('customObject')->show(1337);
```

#### Create a custom object
```php
$client->api('customObject')->create(
    array (
        'type' => 'CustomObject',
        'depth' => 'complete',
        'description' => 'Description for custom object',
        'name' => 'Elomentary Test Custom Object', // Required field
        'fields' => array (
            (object) array (
                'type' => 'CustomObjectField',
                'depth' => 'complete',
                'name' => 'Test field one', // Required if defining fields
                'dataType' => 'text', // Required if defining fields
                'defaultValue' => '',
                'displayType' => 'text',
            ),
            (object) array (
                'type' => 'CustomObjectField',
                'depth' => 'complete',
                'name' => 'Test field two', // Required if defining fields
                'dataType' => 'text', // Required if defining fields
                'defaultValue' => '',
                'displayType' => 'text',
            ),
        ),
    )
);
```

The custom object, including the customObject and field ids, is included in the return array:

```php
array (
    'type' => 'CustomObject',
    'id' => 1337,
    'depth' => 'complete',
    'description' => 'Description for custom object',
    'name' => 'Elomentary Test Custom Object',
    'fields' => array (
        array (
            'type' => 'CustomObjectField',
            'id' => 1338,
            'depth' => 'complete',
            'name' => 'Test field one',
            'dataType' => 'text',
            'defaultValue' => '',
            'displayType' => 'text',
            'internalName' => 'Test_field_one1',
        ),
        array (
            'type' => 'CustomObjectField',
            'id' => 1339,
            'depth' => 'complete',
            'name' => 'Test field two',
            'dataType' => 'text',
            'defaultValue' => '',
            'displayType' => 'text',
            'internalName' => 'Test_field_two1',
        ),
)
```

#### Remove a single custom object by a given ID
```php
$client->api('customObject')->remove(1337);
```

### Links
* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3097)
