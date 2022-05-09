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
}