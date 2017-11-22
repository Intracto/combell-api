<?php

namespace TomCan\CombellApi\Adapter;

class GuzzleAdapter
{

    public function Call($method, $uri, $headers, $body) {

        $client = new \GuzzleHttp\Client();
        $request = new \GuzzleHttp\Psr7\Request(strtoupper($method), $uri, $headers, $body);

        try {
            $response = $client->send($request);

            switch ($response->getStatusCode()) {
                case 200:
                case 201:
                case 202:
                    // request ok
                    return array(
                        "status" => $response->getStatusCode(),
                        "headers" => $response->getHeaders(),
                        "body" => $response->getBody()->getContents(),
                    );
                    break;

                case 401:
                    throw new Exception("Not authorized", 401);
                case 403:
                    throw new Exception("Permission denied", 403);
                case 404:
                    throw new Exception("Not found", 404);
                case 429:
                    throw new Exception("Ratelimit exceeded", 429);
                default:
                    throw new Exception("Unspecified exception", $response->getStatusCode());

            }

        } catch (Exception $ex) {

            throw new Exception("Unspecified exception", $ex->getCode());

        }

    }

}