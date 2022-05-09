<?php

namespace Flutterwave\Payment;

use Flutterwave\Customer\Customer;
use Flutterwave\Payload\PaymentPayloadStandard;

interface FlutterwaveInterface
{
    public function get_payment_url(string $secKey, PaymentPayloadStandard $payload, $callback = null):string;
    public static function get_payment_status(iterable $keys,string $tx_ref, iterable $saved_transaction_details):string;
    public function get_payment_details():iterable;
    public function get_tx_ref():string;
    public function get_amount():int;
    public function get_currency():string;
    public function get_payment_method():string;
    public function get_customer_data():Customer;
}