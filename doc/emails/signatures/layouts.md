## E-mail signature layouts
[Back to E-mails](../../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail signature layouts
```php
$client = new Eloqua\Client();
$client->api('email')->signatureLayouts()->search('*');
```

#### Search e-mail signature layouts by name
```php
$client = new Eloqua\Client();
$client->api('email')->signatureLayouts()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->signatureLayouts()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail signature layout
```php
$client->api('email')->signatureLayouts()->show($layout_id);
```

#### Return partial data on an e-mail signature layout
```php
$client->api('email')->signatureLayouts()->show($layout_id, 'partial');
```

#### Update an e-mail signature layout
```php
$client->api('email')->signatureLayouts()->update($layout_id, $data);
```

#### Delete an e-mail signature layout
```php
$client->api('email')->signatureLayouts()->delete($layout_id);
```

#### Create an e-mail signature layout
```php
$client->api('email')->signatureLayouts()->create($data);
```
