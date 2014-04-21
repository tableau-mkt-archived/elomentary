## Result Pager
[Back to the navigation](index.md)

### Usage examples

Get all contacts for a given search.

```php
$client = new Eloqua\Client();

$contacts = $client->api('contacts');

$paginator  = new Eloqua\ResultPager($client);
$query = array('*@example.com');
$result = $paginator->fetchAll($contacts, 'search', $query);
```

Get the first page
```php
$client = new Eloqua\Client();

$contacts = $client->api('contacts');

$paginator  = new Eloqua\ResultPager( $client );
$query = array('*@example.com');
$result = $paginator->fetch($contacts, 'search', $query);
```

Check for a next page:
```php
$paginator->hasNext();
```

Get next page:
```php
$paginator->fetchNext();
```

Check for previous page:
```php
$paginator->hasPrevious();
```

Get previous page:
```php
$paginator->fetchPrevious();
```

If you want to retrieve the pagination links (available after the call to fetch):
```php
$paginator->getPagination();
```
