<?php

namespace Flutterwave\Customer;

class Customer extends AbstractCustomer
{
    public function __construct(string $customer_id, string $customer_name, string $customer_email, string $customer_phone, $customer_address  = null)
    {
        parent::__construct($customer_id, $customer_name, $customer_email, $customer_phone, $customer_address);
    }

    public function return_customer_details():iterable
    {
        return [
            'id' => $this->customer_id,
            'name' => $this->customer_name,
            'email' => $this->customer_email,
            'phone' => $this->customer_phone,
            'address' => $this->customer_address ?? null
        ];
    }

}