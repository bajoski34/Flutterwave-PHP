<?php

namespace Flutterwave\Traits;

// External Dependencies
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

trait ServiceTrait
{
    public function get_request($secKey, $url, $query_args):iterable
    {
        $client = new Client();
        $token = 'Bearer '. $secKey;

        try {
            $response = $client->get('https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref=' . $tx_ref, [
                'debug' => FALSE,
                'headers' => [
                    'Authorization' => $token
                ]
            ]);

            $body = $response->getBody();
            $result = json_decode($body);
            return $result->data ?? $result['data'];

        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
            return 'Could not get payment url';
        }
    }

    public function post_request($secKey, $payload, $url):iterable
    {
        $token = 'Bearer '. $secKey;

        $data = $payload->prepared_payload();

        try {
            $response = $client->post($url, [
                'debug' => FALSE,
                'json' => $payload,
                'headers' => [
                    'Authorization' => $token
                ]
            ]);

            $body = $response->getBody();
            $result = json_decode($body);
            return $result->data ?? $result['data'];

        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
            return 'Could not get payment url';
        }
    }
}