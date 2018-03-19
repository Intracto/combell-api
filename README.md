# TomCan\combell-api
This is my take on the Combell shared-hosting API. The goal is to provide a set of classes that will allow you to easely interact with the API.

## Current status
All the supported calls at the time of writing have been implemented.  
Since the Combell API itself lacks quite some functionality, this library obviously lacks that too. I'll try to keep this up-to-date when new functionality is added.

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
The command will return an array containing 3 elements.

**status**

This contains the HTTP status code of the response. 200 -> 204 indicate success. Other codes typically mean failure of some sort.

**headers**

This contains an array of http headers of the response in a key/value manner, where value is always an array, even if only one value is returned.
 
**body**

If the response contained a body, this will be the json_decoded object of that response.

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
}
```