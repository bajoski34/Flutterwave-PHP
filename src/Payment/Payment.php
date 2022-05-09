<?php

namespace Flutterwave\Payment;

use Flutterwave\Traits\PaymentTrait;
class Payment extends AbstractPayment
{
    use PaymentTrait;
    public function __construct(iterable $keys, string $amount, string $currency, iterable $payment_method, $customerData)
    {
        parent::__construct($keys, $amount, $currency, $payment_method, $customerData);
    }

    public function get_html_element($pubKey, $prepared_payload = null): string
    {
        if(!is_null($prepared_payload)){
            $payload = $prepared_payload;
            $payload['public_key'] = $pubKey;
            $payload['payment_options'] = $payload['payment_method'];
            unset($payload['payment_method']);
            $json = json_encode($payload);
            $html_elements =  '
                <script src="https://checkout.flutterwave.com/v3.js"></script>
                <script>
                function makePayment() {
                    FlutterwaveCheckout('.$json.');
                  }
                </script>
            ';
    
            //TODO: Add integrity hash to these options
            return $html_elements;
        }

        return 'set a callback to get the prepared payload';
    }
}