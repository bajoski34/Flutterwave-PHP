<?php

require __DIR__ . '/../vendor/autoload.php';

use Flutterwave\Payment\Payment;
use Flutterwave\Customer\Customer;

//after payment is made, you can verify the payment
$keys = [
    'PUBLIC_KEY' => 'FLWPUBK_TEST-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-X',
    'SECRET_KEY' => 'FLWSECK_TEST-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-X'
];

if(isset($_GET['status']) && isset($_GET['tx_ref']) && isset($_GET['transaction_id'])){
    $tx_ref = $_GET['tx_ref'];
    //query database for the transaction details using $tx_ref
    $saved_transaction_details = [
        'amount' => 100,
        'currency' => 'NGN',
    ];

    $result = Payment::confirm_payment($keys, $tx_ref, $saved_transaction_details, function($status){
        if($status == Payment::SUCCESS_STATUS){
            //redirect to success page
            echo 'Another action before redirecting to success page <br />';
        }
    });

    if($result == Payment::SUCCESS_STATUS){
        //redirect to success page
        echo 'Payment Successful';
    }

    if($result == Payment::FAILED_STATUS){
        //redirect to failed page
        echo 'Payment Failed';
    }

    if($result == Payment::PENDING_STATUS){
        //redirect to pending page
        echo 'Payment Pending';
    }

    if($result == Payment::PARTIAL_STATUS){
        //redirect to partial page. contact customer for more information
        echo 'Payment Partial';
    }

    if($result == Payment::CURRENCY_MISMATCH_STATUS){
        //redirect to currency mismatch page. initiate refund manually on flutterwave dashboard
        echo 'Payment Currency Mismatch';
    }
}else{
    $tx_ref = $_GET['tx_ref'];
    //query database for the transaction details using $tx_ref
    $saved_transaction_details = [
        'amount' => 100,
        'currency' => 'NGN',
    ];

    $result = Payment::confirm_payment($keys, $tx_ref, $saved_transaction_details);

}