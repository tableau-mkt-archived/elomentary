## Camapaigns
[Back to the navigation](index.md)

### Usage examples

#### Search for campaigns with a given search term
```php
$client = new Eloqua\Client();
$client->api('campaigns')->search('Never Gonna Give*');
```

#### Return a single campaign by a given ID
```php
$client->api('campaign')->show($campaign_object_id);
```

#### Return partial data on a campaign
```php
$client->api('campaign')->show($campaign_object_id, 'partial');
```

#### Create a campaign
```php
$client->api('campaign')->create(array(
  'folderId' => 123,
  'runAsUserId' => 123,
  'name' => 'Elomentary Test Campaign',
  // More fields/properties as needed...
));
```

#### Update a campaign with a given ID and array of campaign data
```php
$client->api('campaign')->update(123, array(
  'folderId' => 123,
  'runAsUserId' => 456,
  'name' => 'Elomentary Test Campaign',
));
```

#### Delete a single campaign by a given ID
```php
$client->api('campaign')->remove($campaign_object_id);
```
