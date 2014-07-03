## Contacts View Data
[Back to Contacts](../contacts.md) | [Back to the navigation](../index.md)

### Usage examples

#### List Contacts through a contact view
```php
$client = new Eloqua\Client();
$client->api('contact')->views($view_id)->search('*');
```

#### Search for contacts through a view by e-mail domain
```php
$client->api('contact')->views($view_id)->search('*@example.com');
```

#### Limit your search to pages of 10 results at "minimal" depth
```php
$client->api('contact')->views($view_id)->search('*@example.com', array(
  'count' => 10,
  'depth' => 'minimal'
));
```
#### Get an individual contact view record for a contact
```php
$client->api('contact')->views($view_id)->show($contact_id);
```
