<?php

namespace Flutterwave\Payload;

use Flutterwave\Customer\Customer;
interface PayloadInterface
{
    public function hasPaymentMethod():bool;
    public function getPayload(): iterable;
}

abstract class AbstractPayload implements PayloadInterface
{
    protected $tx_ref;
    protected $amount;
    protected $currency;
    protected $payment_method;
    protected $customerData; // this can also be an object
    public $redirect_url;
    protected $metadata;
    public $customization;
public function __construct(string $tx_ref, int $amount, string $currency, iterable $payment_method,Customer $customerData, string $redirect_url)
    {
        $this->tx_ref = $tx_ref;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->payment_method = $payment_method;
        $this->customerData = $customerData;
        $this->redirect_url = $redirect_url;
    }

    public function hasPaymentMethod():bool
    {
        if(!empty($this->payment_method)){
            return true;
        }
        
        return false;
    }

    protected function get_txref():string
    {
        return $this->tx_ref;
    }

    public function add_metadata(array $data):void
    {
        $this->metadata = $data;
    }

    public function get_metadata():array
    {
        return $this->metadata;
    }

    protected function get_customer_data():Customer
    {
        return $this->customerData;
    }

    public function add_customization(array $data):void
    {
        if(isset($data['logo']) && isset($data['title']) && isset($data['description'])){
            $this->customization = $data;
        }
        $this->customization = $data;
    }

    protected function get_customization():iterable
    {
        return $this->customization;
    }

    public function getPayload(): iterable
    {
        return [
            'tx_ref' => $this->get_txref(),
            'amount' => $this->amount,
            'redirect_url' => $this->redirect_url,
            'currency' => $this->currency,
            'payment_method' => $this->payment_method,
            'customer' => $this->get_customer_data()->return_customer_details(),
            'metadata' => $this->get_metadata(),
            'customization' => $this->get_customization()
        ];
    }

    abstract public function prepared_payload():iterable;
}