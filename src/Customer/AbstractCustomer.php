<?php

namespace Flutterwave\Customer;

abstract class AbstractCustomer
{
    protected $customer_id;
    protected $customer_name;
    protected $customer_email;
    protected $customer_phone;
    protected $customer_address  = null;

    public function __construct(string $customer_id, string $customer_name, string $customer_email, string $customer_phone, $customer_address  = null)
    {
        $this->customer_id = $customer_id;
        $this->customer_name = $customer_name;
        $this->customer_email = $customer_email;
        $this->customer_phone = $customer_phone;
        $this->customer_address = $customer_address;
    }

    public function return_customer_details():iterable
    {
        return [
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address
        ];
    }
}