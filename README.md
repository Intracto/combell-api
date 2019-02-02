# tomcan\combell-api

This is my take on the Combell shared-hosting API. The goal is to provide a client library that makes it easy for you to
interact with the Combell shared hosting public API.

## Current status

Since the Combell API is still in development and new functionality is added regularly, this library might not implement
every call yet. We do try to keep it up-to-date as much as possible. If there are calls missing, please open an issue
to tell us about it or even a pull request to add the call!

## Usage

You can install the library through composer:

```bash
composer install tomcan/combell-api
```

Next, you need to include the composer autoloader. Instantiate the API object with your API key and secret, create the
command objects and fire away!

```php
require __DIR__ . '/vendor/autoload.php';

$key = 'YOUR-API-KEY';  
$sec = 'YOUR-API-SECRET';

$adapter = new \TomCan\CombellApi\Adapter\GuzzleAdapter();  
$api = new \TomCan\CombellApi\Common\Api($key, $sec, $adapter);  
$cmd = new \TomCan\CombellApi\Command\Accounts\ListAccounts();
  
var_dump($api->executeCommand($cmd));  
```

The command will return the data of the call, in the example above that is an array with Account objects. See the test
directory for extensive examples of all the calls.

If you need information about the HTTP call, you can ask the api object about it:

```php
// return the HTTP status code. 200 -> 204 indicate success, other codes typically mean failure of some sort
$api->getStatusCode();

// rate limiting headers
$api->getRateLimitUsage();
$api->getRateLimitRemaining();
$api->getRateLimitReset();
$api->getRateLimitLimit();
```

If the command is pageable, you can get info about the paging from the command object:

```php
$cmd->getPagingSkipped();
$cmd->getPagingTake();
$cmd->getPagingTotalResults();
```
