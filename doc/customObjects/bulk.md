## Custom Objects Bulk API
[Back to custom objects](../custom-objects.md) | [Back to the navigation](../index.md)

### Usage examples

#### Export custom object data out of Eloqua
```php
// Setup the Elomentary client
$client = new \Eloqua\Client();
$client->authenticate('CompanyIdentifier', 'MyUserName', 'MyPassPhrase', 'https://secure.p03.eloqua.com/API/Bulk');

// Setup mapping object, see section 2.2 of linked documentation at the end of this doc
$mapping = array(
  'name'                    => 'Elomentary export from Eloqua',
  'identifierFieldName'     => 'Internal_Field_Name1',
  'isSyncTriggeredOnImport' => 'false',
  'fields'                  => array (
    'Internal_Field_Name1'     => '{{CustomObject[25].Field[159]}}',
    'Internal_Field_Name_Two1' => '{{CustomObject[25].Field[160]}}',
  )
);

// Do the required steps for staging and downloading export file
$bulkApi = $client->api('customObject')->bulk(25); // Gets the bulk API connector for custom object with id=25
$bulkApi->exports();                               // Sets connector to 'export' mode.
$bulkApi->map($mapping);                           // Sends setup/mapping array to Eloqua
$bulkApi->sync();                                  // Stages file for download
$bulkApi->status();                                // Check status until processing is finished
$result = $bulkApi->download();                    // Download your file

print_r($result);
```

Custom object internal field names are generally the CustomObjectField 'name'
attribute followed by the number 1.  The 'name' attribute can be discovered
using the [Custom Object Asset](../custom-objects.md) `show()` API.

#### Import contacts into Eloqua
```php
// Setup the Elomentary client
$client = new \Eloqua\Client();
$client->authenticate('CompanyIdentifier', 'MyUserName', 'MyPassPhrase', 'https://secure.p03.eloqua.com/API/Bulk');

// Setup mapping object, see section 2.2 of linked documentation at the end of this doc
$mapping = array(
  'name'                    => 'Elomentary import into Eloqua',
  'identifierFieldName'     => 'Internal_Field_Name1',
  'isSyncTriggeredOnImport' => 'false',
  'fields'                  => array (
    'Internal_Field_Name1'     => '{{CustomObject[25].Field[159]}}',
    'Internal_Field_Name_Two1' => '{{CustomObject[25].Field[160]}}',
  )
);

// Some sample contacts
$customObjectData = array (
  array (
    'Internal_Field_Name1'     => 'Parris',
    'Internal_Field_Name_Two1' => 'Varney',
  ),
  array (
    'Internal_Field_Name1'     => 'Matt',
    'Internal_Field_Name_Two1' => 'Foley',
  ),
);

// Do the required steps for staging and downloading export file
$bulkApi = $client->api('customObjects')->bulk(25);  // Gets the bulk API connector for custom object with id=25
$bulkApi->imports();                                 // Sets connector to 'import' mode.
$bulkApi->map($mapping);                             // Sends setup/mapping array to Eloqua
$bulkApi->upload($customObjectData);                 // Upload content to Eloqua staging area
$bulkApi->sync();                                    // Sync uploaded files your custom data object
$bulkApi->status();                                  // Check status until processing is finished
$log = $bulkApi->log();                              // Retrieving processing log

print_r($log);
```

Custom object internal field names are generally the CustomObjectField 'name'
attribute followed by the number 1.  The 'name' attribute can be discovered
using the [Custom Object Asset](../custom-objects.md) `show()` API.

### Links

* [Bulk API documentation on Topliners](http://topliners.eloqua.com/docs/DOC-6918)

