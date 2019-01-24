<?php

namespace TomCan\CombellApi\Adapter;

use GuzzleHttp\Exception\ClientException;

class GuzzleAdapter
{
    public function Call($method, $uri, $headers, $body)
    {

        $client = new \GuzzleHttp\Client();
        $request = new \GuzzleHttp\Psr7\Request(strtoupper($method), $uri, $headers, $body);

        try {
            $response = $client->send($request);

            switch ($response->getStatusCode()) {
                case 200:
                case 201:
                case 202:
                case 204:
                    // request ok
                    return array(
                        'status' => $response->getStatusCode(),
                        'headers' => $response->getHeaders(),
                        'body' => $response->getBody()->getContents(),
                    );
                    break;

                default:
                    $newEx = new \TomCan\CombellApi\Exception\ClientException(
                        'Unexpected statuscode',
                        $response->getStatusCode()
                    );
                    $newEx->setBody($response->getBody()->getContents());
                    throw $newEx;
            }
        } catch (ClientException $ex) {
            switch ($ex->getCode()) {
                case 401:
                case 403:
                case 404:
                case 429:
                    $newEx = new \TomCan\CombellApi\Exception\ClientException(
                        $ex->getMessage(),
                        $ex->getCode()
                    );
                    $newEx->setBody($ex->getResponse()->getBody()->getContents());
                    throw $newEx;
                    break;

                default:
                    throw new \TomCan\CombellApi\Exception\ClientException(
                        $ex->getMessage(),
                        $ex->getCode()
                    );
            }
        } catch (\Exception $ex) {
            throw new \RuntimeException('Unspecified exception', $ex->getCode());
        }
    }
}
