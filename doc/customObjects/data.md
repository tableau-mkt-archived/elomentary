## Contact fields
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

The customObject data API is used for interacting with the data contained within
a named custom object.  The 2.0 REST API is not currently supported, version
1.0 must be used.

### Usage examples

#### List all custom object data
```php
$client = new Eloqua\Client();
$client->setOption('version', '1.0');
$customObjectRecords = $client->api('customObject')->data(1337)->search('');
```
The `data()` method takes a custom object id as a parameter.

#### Search custom object data by id
```php
$customObjectRecords = $client->api('customObject')->data(1337)->search('id=25');
```

#### Limit your search to pages of 10 results
```php
$customObjectRecords = $client->api('customObject')->data(1337)->search('', array(
  'count' => 10,
));
```

#### Return an individual custom object record
```php
$customObjectRecord = $client->api('customObject')->data(1337)->show(25);
```

#### Update a custom object record
This is not currently supported in the Eloqua REST API.  Using the bulk API
is required for updating or removing existing custom object records

#### Delete a custom object record
This is not currently supported in the Eloqua REST API.  Using the bulk API
is required for updating or removing existing custom object records

#### Create a custom object record
```php
$customObjectRecord = $client->api('customObject')->data(1337)->create(array (
  'contactId' => 1234,
  'fieldValues' => array (
    array ('id' => 1338, 'value' => 'Test value'),
    array ('id' => 1339, 'value' => 'Test value 2'),
  )
);
```
The response will include the custom object record id

### Links
* [API details on Topliners](http://topliners.eloqua.com/docs/DOC-3405)
