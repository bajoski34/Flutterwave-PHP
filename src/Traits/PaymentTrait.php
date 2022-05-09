<?php 

namespace Flutterwave\Traits;

require __DIR__ . '/../../vendor/autoload.php';
// External Dependencies
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
// Internal Dependencies
use Flutterwave\Payload\PaymentPayloadStandard;
use Flutterwave\Customer\Customer;

trait PaymentTrait
{
    public function get_payment_url(string $secKey, PaymentPayloadStandard $payload, $callback = null):string
    {
        //make a call to the payment gateway to get payment url
        $client = new Client();
        $token = 'Bearer '. $secKey;

        $data = $payload->prepared_payload();

        try {
            $response = $client->post('https://api.flutterwave.com/v3/payments', [
                'debug' => FALSE,
                'json' => $data,
                'headers' => [
                    'Authorization' => $token
                ]
            ]);

            $body = $response->getBody();
            $result = json_decode($body);
            if(!is_null($callback)){
                $callback($result->data->link);
            }
            return $result->data->link;

        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
            return 'Could not get payment url';
        }
    }

}