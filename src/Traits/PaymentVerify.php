<?php

namespace Flutterwave\Traits;
// External Dependencies
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
// Internal Dependencies
use Flutterwave\Payload\PaymentPayloadStandard;
use Flutterwave\Customer\Customer;

trait PaymentVerify
{
    public static function verify_payment( string $secKey,string $tx_ref):iterable
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

            $customer = new Customer(
                $result->data->customer->id,
                $result->data->customer->name,
                $result->data->customer->email,
                $result->data->customer->phone_number,
            );
            return [
                'status' => $result->data->status,
                'currency' => $result->data->currency,
                'amount' => $result->data->amount,
                'customer' => $customer
            ];

        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
            return 'Could not get payment url';
        }

    }
}