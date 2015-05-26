## E-mail signature rules
[Back to E-mails](../../emails.md) | [Back to the navigation](../index.md)

### Usage examples

#### List all e-mail signature rules
```php
$client = new Eloqua\Client();
$client->api('email')->signatureRules()->search('*');
```

#### Search e-mail signature rules by name
```php
$client = new Eloqua\Client();
$client->api('email')->signatureRules()->search('Never gonna*');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client = new Eloqua\Client();
$client->api('email')->signatureRules()->search('Never gonna*', array(
  'count' => 10,
  'depth' => 'minimal'
));
```

#### Return an individual e-mail signature rule
```php
$client->api('email')->signatureRules()->show($rule_id);
```

#### Return partial data on an e-mail signature rule
```php
$client->api('email')->signatureRules()->show($rule_id, 'partial');
```

#### Update an e-mail signature rule
```php
$client->api('email')->signatureRules()->update($rule_id, $data);
```

#### Delete an e-mail signature rule
```php
$client->api('email')->signatureRules()->delete($rule_id);
```

#### Create an e-mail signature rule
```php
$client->api('email')->signatureRules()->create($data);
```
