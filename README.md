# TomCan\combell-api
This is my take on the Combell shared-hosting API. The goal is to provide a set of classes that will allow you to easely interact with the API.

## Current status
Since the Combell API is still in development and new functionality is added regulary, this library might not implement every call yet. I do try to keep it up-to-date as much as possible. If there are calls missing, please let me know!

## Usage
You can install the library through composer
```
composer install tomcan/combell-api
```
Next, you need to include the composer autoloader. Instantiate the API object with your API key and secret, create the command objects and fire away!
```php
<?php  

require dirname(__DIR__) . '/vendor/autoload.php';

$key = "YOUR-API-KEY";  
$sec = "YOUR-API-SECRET";

$adapter = new \TomCan\CombellApi\Adapter\GuzzleAdapter();  
$api = new \TomCan\CombellApi\Common\Api($key, $sec, $adapter);  
$cmd = new \TomCan\CombellApi\Command\Accounts\ListAccounts();  
var_dump($api->ExecuteCommand($cmd));  

?>
```
The command will return an array containing 4 elements.

**status**

This contains the HTTP status code of the response. 200 -> 204 indicate success. Other codes typically mean failure of some sort.

**headers**

This contains an array of http headers of the response in a key/value manner, where value is always an array, even if only one value is returned.
 
**body**

If the response contained a body, this will be the json_decoded object of that response.

**response**

As of version 2.0.0, some responses will also have a "response" element containing the processed response of the command. This is typically a set of specific classes (see Structure namespace) for the command, like a list of DNS records where each type has it's own class. More and more commands will be transformed to this structure.

As of version 3.0.0, the entire response array will be replaced by it's own object instead of array and support for the body element will be dropped.

```
array(3) {
  ["status"]=>
  int(200)
  ["headers"]=>
  array(10) {
    ["X-RateLimit-Limit"]=>
    array(1) {
      [0]=>
      string(3) "100"
    }
    ...
  }
  ["body"]=>
  array(25) {
    [0]=>
    object(stdClass)#29 (2) {
      ["id"]=>
      int(12345)
      ["identifier"]=>
      string(12) "domain.tld"
    }
    [1]=>
    object(stdClass)#27 (2) {
      ["id"]=>
      int(12346)
      ["identifier"]=>
      string(12) "domain2.tld"
    }
    ...
  }
  ["response"]=>
  array(25) {
    [0]=>
    object(TomCan\CombellApi\Structure\Accounts\Account)#37 (2) {
      ["id":"TomCan\CombellApi\Structure\Accounts\Account":private]=>
      int(12345)
      ["identifier":"TomCan\CombellApi\Structure\Accounts\Account":private]=>
      string(12) "domain.tld"
    }
    [1]=>
    object(TomCan\CombellApi\Structure\Accounts\Account)#39 (2) {
      ["id":"TomCan\CombellApi\Structure\Accounts\Account":private]=>
      int(12346)
      ["identifier":"TomCan\CombellApi\Structure\Accounts\Account":private]=>
      string(12) "domain2.tld"
    }
    ...
  }
}
```

## Changelog

**21-01-2019 - v2.0.5**

- Added command to get Mysql database

**21-03-2018 - v2.0.4**

- Added structured representation to LinuxHostings namespace

**20-03-2018 - v2.0.3**

- Added structured representation to MysqlDatabases and Servicepacks namespace
- Added DNS AAAA Record Type

**20-03-2018 - v2.0.2**

- Added Structured representation to Domains and ProvisioningJobs namespace

**19-03-2018 - v2.0.0**

- We now have a changelog in this file
- Reorganised the namespaces to be able to differentiate between Commands and Structures.
- The Account and DNS commands now also return a Structured representation of the objects in the "response" element of the returned array, rather than only the json_decoded body.
- The DNS portion of the API has been redone using the new methods the API provides.
- Known issue: although implemented according to the specs, the UpdateRecord command yields an Internal Server error. Since no data is available regarding the details of the error, we can only assume this is a problem on Combells side.

**pre 19-03-2018**

- No changelog has been kept prior to this point. If you really need to know, please see the Git history to get an idead of what changed.
