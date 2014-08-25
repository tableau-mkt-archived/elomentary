## Contacts Bulk API
[Back to the navigation](index.md)

### Usage examples

#### Export contacts out of Eloqua
```php
// Setup the Elomentary client
$client = new \Eloqua\Client();
$client->authenticate('CompanyIdentifier', 'MyUserName', 'MyPassPhrase', 'https://secure.p03.eloqua.com/API/Bulk');

// Setup mapping object, see section 2.2 of linked documentation at the end of this doc
$mapping = array(
  'name'                    => 'Elomentary export from Eloqua',
  'identifierFieldName'     => 'ContactIDExt',
  'isSyncTriggeredOnImport' => 'false',
  'fields'                  => array (
    'ContactIDExt'   => '{{Contact.Id}}',
    'C_FirstName'    => '{{Contact.Field(C_FirstName)}}',
    'C_LastName'     => '{{Contact.Field(C_LastName)}}',
    'C_Title'        => '{{Contact.Field(C_Title)}}',
    'C_BusPhone'     => '{{Contact.Field(C_BusPhone)}}',
    'C_EmailAddress' => '{{Contact.Field(C_EmailAddress)}}',
  )
);

// Do the required steps for staging and downloading export file
$bulkApi = $client->api('contacts')->bulk(); // Gets the bulk API connector
$bulkApi->exports();                         // Sets connector to 'export' mode.
$bulkApi->map($mapping);                     // Sends setup/mapping array to Eloqua
$bulkApi->sync();                            // Stages file for download
$bulkApi->status();                          // Check status until processing is finished
$result = $bulkApi->download();              // Download your file

print_r($result);
```

#### Import contacts into Eloqua
```php
// Setup the Elomentary client
$client = new \Eloqua\Client();
$client->authenticate('CompanyIdentifier', 'MyUserName', 'MyPassPhrase', 'https://secure.p03.eloqua.com/API/Bulk');

// Setup mapping object, see section 2.2 of linked documentation at the end of this doc
$mapping = array(
  'name'                    => 'Elomentary export from Eloqua',
  'identifierFieldName'     => 'C_EmailAddress',
  'isSyncTriggeredOnImport' => 'false',
  'fields'                  => array (
    'C_FirstName'    => '{{Contact.Field(C_FirstName)}}',
    'C_LastName'     => '{{Contact.Field(C_LastName)}}',
    'C_Title'        => '{{Contact.Field(C_Title)}}',
    'C_BusPhone'     => '{{Contact.Field(C_BusPhone)}}',
    'C_EmailAddress' => '{{Contact.Field(C_EmailAddress)}}',
  )
);

// Some sample contacts
$contacts = array ( // todo will be input parameter
  array (
    'C_FirstName'    => 'Parris',
    'C_LastName'     => 'Varney',
    'C_Title'        => 'Señior Developer',
    'C_BusPhone'     => null,
    'C_EmailAddress' => 'pvarney@npxconnect.com',
  ),
  array (
    'C_FirstName'    => 'Matt',
    'C_LastName'     => 'Foley',
    'C_Title'        => 'Motivational Speaker',
    'C_BusPhone'     => null,
    'C_EmailAddress' => 'matt@inavandownbytheriver.com',
  ),
);

// Do the required steps for staging and downloading export file
$bulkApi = $client->api('contacts')->bulk();  // Gets the bulk API connector
$bulkApi->imports();                          // Sets connector to 'import' mode.
$bulkApi->map($mapping);                      // Sends setup/mapping array to Eloqua
$bulkApi->upload($contacts);                  // Upload content to Eloqua staging area
$bulkApi->sync();                             // Sync uploaded files your contacts
$bulkApi->status();                           // Check status until processing is finished
$log = $bulkApi->log();                       // Retrieving processing log

print_r($log);
```

### Links

* [Bulk API documentation on Topliners](http://topliners.eloqua.com/docs/DOC-6918)

