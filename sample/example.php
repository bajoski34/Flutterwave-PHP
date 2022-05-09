<?php

require __DIR__ . '/../vendor/autoload.php';

use Flutterwave\Payment\Payment;
use Flutterwave\Customer\Customer;
use Flutterwave\Payload\PaymentPayloadStandard as Payload;


$keys = ['PUBLIC_KEY' => 'FLWPUBK_TEST-XXXXXXXXXXXXXXXXXXXX-X', 'SECRET_KEY' => 'FLWSECK_TEST-XXXXXXXXXXXXXXXXXXXXXX-X'];
//create a customer object
$customer = new Customer('123456789', 'Olaobaju Abraham', 'example@gmail.com', '08067985861');

//get customer details
// print_r($customer->return_customer_details());

//create a payment object
$payment = new Payment($keys,'100', 'NGN', ['card'], $customer);

//get the transaction reference
$tx_ref =  $payment->get_tx_ref();

//get payment link
$payload = new Payload($tx_ref, 100, 'NGN', ['card'], $customer, 'http://localhost:8086/callback.php');
$payload->add_customization(
    [
        'logo' => 'https://avatars.githubusercontent.com/u/39011309?v=4',
        'description' => 'software readily available',
        'title' => 'Bajoski34'
    ]
);
$payload->add_metadata([
    'isRecurring' => 'true',
    'payment' => $payment
]);

//to get a exact copy of the payload sent
// $payload->prepared_payload() or $payload->getPayload();
$payment_link = $payment->get_payment_url($keys['SECRET_KEY'], $payload, function($payment_link){
    header('Location: ' . $payment_link);
});

// header('Location: ' . $payment_link);