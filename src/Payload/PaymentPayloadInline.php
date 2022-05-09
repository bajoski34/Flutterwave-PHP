<?php

namespace Flutterwave\Payload;

use Flutterwave\Customer\Customer;
class PaymentPayloadInline extends AbstractPayload
{
    public function __construct(string $tx_ref,int $amount, string $currency, iterable $payment_method, Customer $customerData, string $redirect_url)
    {
        parent::__construct($tx_ref, $amount, $currency, $payment_method, $customerData, $redirect_url);
    }

    public function prepared_payload(): iterable
    {
        //for record puposes
        $payload = $this->getPayload();
        //add customization
        if($this->hasPaymentMethod()){
            if(\is_iterable($this->get_customization())){
                $payload['customization'] = $this->get_customization();
            }
        }

        //add metadata
        if(\is_iterable($this->get_metadata())){
            $payload['metadata'] = $this->get_metadata();
        }

        return $payload;
    }


    public function get_html_element($pubKey): string
    {
        $payload = $this->prepared_payload();
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
}