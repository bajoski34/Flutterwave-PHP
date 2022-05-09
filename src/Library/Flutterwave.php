<?php

namespace Flutterwave\Library;

use Flutterwave\Customer\Customer;
use Flutterwave\Traits\ServiceTrait;

abstract class Flutterwave
{
    use ServiceTrait;

    const BASE_URL = "https://api.flutterwave.com/v3/";
    protected $payment_method;
    protected $customer_data;
    protected $payment_details;
    protected $tx_ref;
    protected $amount;
    protected $currency;
    protected $api_keys;
    protected $payment_status;
    protected $redirect_url;

    public function __construct(iterable $api_keys)
    {
        $this->api_keys = $api_keys;
    }

    protected function set_payment_method(string $payment_method)
    {
        $this->payment_method = $payment_method;
    }

    protected function set_customer_data(Customer $customer_data)
    {
        $this->customer_data = $customer_data;
    }

    public function get_txref():string
    {
        return $this->tx_ref;
    }

    public function get_amount():int
    {
        return $this->amount;
    }

    public function get_currency():string
    {
        return $this->currency;
    }

    public function get_payment_method():string
    {
        return $this->payment_method;
    }

    public function get_customer_data():Customer
    {
        return $this->customer_data;
    }

    public function get_redirect_url():string
    {
        return $this->payment_details;
    }
    
    abstract protected function initiate_payment(string $payment_method);
}