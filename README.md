# TomCan\combell-api
This is my take on the Combell shared-hosting API. The goal is to provide a set of classes that will allow you to easely interact with the API.

## Goals
- Implement all calls exposed by the API (:duh:)

## Current status
Currently (after just a few hours of work), only a simple proof-of-concept has been developed. The API class has the bare essentials to make calls through an HTTP Adapter (currenlty only Guzzle). So far, only one command has been implemented (GET /accounts) and the results are not yet parsed/processed into usable objects.

Oh, and at least I do have a README ;)

## Usage
Since there is no composer package yet, you will have to integrate it into your project manually. Once you managed to do that, you should be able to run following example and see some json output.

`<?php  

$key = "YOUR-API-KEY";  
$sec = "YOUR-API-SECRET";

$adapter = new \TomCan\CombellApi\Adapter\GuzzleAdapter();  
$api = new \TomCan\CombellApi\Common\Api($key, $sec, $adapter);  
$cmd = new \TomCan\CombellApi\Accounts\ListAccounts();  
var_dump($api->ExecuteCommand($cmd));  

?>`
