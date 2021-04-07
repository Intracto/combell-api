<?php

namespace TomCan\CombellApi\Adapter;

use TomCan\CombellApi\Exception\ClientException;

class CurlAdapter implements AdapterInterface
{
    public function call(string $method, string $uri, array $headers, string $body): array
    {
        // prepare headers
        $requestHeaders = [];
        foreach ($headers as $key => $value) {
            $requestHeaders[] = $key.': '.$value;
        }

        // prepare request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($curl, CURLOPT_HEADER, 1);

        // execute and get output
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);

        if (false === $output) {
            throw new \RuntimeException('Curl call failed: '.curl_error($curl));
        }

        // split headers and body
        $split = explode("\r\n\r\n", (string) $output, 2);
        $responseBody = $split[1];

        // process headers
        $headerArray = explode("\r\n", $split[0]);
        $responseHeaders = [];
        foreach ($headerArray as $header) {
            $s = explode(':', $header, 2);
            if (\count($s) > 1) {
                $responseHeaders[$s[0]] = trim($s[1]);
            }
        }

        // get status code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // clean up
        curl_close($curl);

        // process response
        switch ($statusCode) {
            case 200:
            case 201:
            case 202:
            case 204:
                // request ok
                return [
                    'status' => $statusCode,
                    'headers' => $responseHeaders,
                    'body' => $responseBody,
                ];

            default:
                if ($statusCode >= 400 && $statusCode <= 499) {
                    // client error, we did something wrong
                    $clientException = new ClientException('Unexpected status code: (statuscode '.$statusCode.')', $statusCode);
                    $clientException->setBody((string) $output);

                    throw $clientException;
                }

                if ($statusCode >= 200 && $statusCode <= 299) {
                    // not an error, just unexpected success code
                    return [
                        'status' => $statusCode,
                        'headers' => $responseHeaders,
                        'body' => $responseBody,
                    ];
                }

                // some other error
                throw new \RuntimeException('Unspecified exception: (statuscode '.$statusCode.')', $statusCode);
        }
    }
}
