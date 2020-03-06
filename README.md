# tomcan\combell-api

This is a Combell shared-hosting API client implementation. The goal is to provide a client library that makes it
easy for you to interact with the Combell shared hosting public API.

[![Build Status](https://travis-ci.org/Intracto/combell-api.svg?branch=master)](https://travis-ci.org/Intracto/combell-api)

## Current status

Since the Combell API is still in development and new functionality is added regularly, this library might not implement
every call yet. We do try to keep it up-to-date as much as possible. We keep an eye on the 
[Combell API changelog](https://api.combell.com/v2/documentation/changelog) but if there are calls missing, do let us
know by opening an issue or even better a pull request ;)

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

$api = new \TomCan\CombellApi\Common\Api(
    new \TomCan\CombellApi\Adapter\GuzzleAdapter(),
    new \TomCan\CombellApi\Common\HmacGenerator($key, $sec)
);
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
