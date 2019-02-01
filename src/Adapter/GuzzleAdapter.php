<?php

namespace TomCan\CombellApi\Adapter;

use TomCan\CombellApi\Exception\ClientException;
use GuzzleHttp\Exception\ClientException as HttpClientException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class GuzzleAdapter implements AdapterInterface
{
    public function call(string $method, string $uri, array $headers, string $body): array
    {
        $client = new HttpClient();
        $request = new Request(strtoupper($method), $uri, $headers, $body);

        try {
            $response = $client->send($request);

            switch ($response->getStatusCode()) {
                case 200:
                case 201:
                case 202:
                case 204:
                    // request ok
                    return [
                        'status' => $response->getStatusCode(),
                        'headers' => $response->getHeaders(),
                        'body' => $response->getBody()->getContents(),
                    ];

                default:
                    $newEx = new ClientException(
                        'Unexpected status code',
                        $response->getStatusCode()
                    );
                    $newEx->setBody($response->getBody()->getContents());

                    throw $newEx;
            }
        } catch (HttpClientException $httpException) {
            switch ($httpException->getCode()) {
                case 401:
                case 403:
                case 404:
                case 429:
                    $clientException = new ClientException(
                        $httpException->getMessage(),
                        $httpException->getCode()
                    );
                    $response = $httpException->getResponse();
                    $body = '';
                    if ($response !== null) {
                        $body = $response->getBody()->getContents();
                    }
                    $clientException->setBody($body);

                    throw $clientException;

                default:
                    throw new ClientException(
                        $httpException->getMessage(),
                        $httpException->getCode()
                    );
            }
        } catch (\Exception $e) {
            throw new \RuntimeException('Unspecified exception', $e->getCode());
        }
    }
}
