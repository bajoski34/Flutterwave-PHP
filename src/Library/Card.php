<?php

namespace Flutterwave\Library;

use Flutterwave\Customer\Customer;
use Flutterwave\Payload\PayloadInterface;
use Flutterwave\Payload\CardPayload as Payload;

class Card extends Flutterwave 
{
    protected $isEnabled;
    protected $endpoint;
    public function __construct(iterable $keys)
    {
        parent::__construct($keys);
        //API
        $this->set_payment_method('card');
        $this->$isEnabled = $this->checkIfMerchantIsEnabled();//PCI-DSS certificate needed to proceed with integration
        $this->$endpoint = Flutterwave::BASE_URL . 'charges?type=card';
    }

    public function initiate_payment()
    {
        $payload = new Payload($this->get_tx_ref(), $this->get_amount(), $this->get_currency(), $this->get_payment_method(), $this->get_customer_data(), $this->get_redirect_url());
        $result = $this->post_request($this->api_keys['SECRET_KEY'], $payload, $this->endpoint);
        return $this;
    }

    public function checkIfMerchantIsEnabled()
    {
        return true;
    }


}

/**
 * make a request to charge the car
 */