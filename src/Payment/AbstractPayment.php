<?php

namespace Flutterwave\Payment;

use Flutterwave\Customer\Customer;
use Flutterwave\Payload\PaymentPayloadStandard;
use Flutterwave\Traits\PaymentVerify;

abstract class AbstractPayment implements FlutterwaveInterface
{
    use PaymentVerify;
    
    const SUCCESS_STATUS = 'success';
    const FAILED_STATUS = 'failed';
    const PENDING_STATUS = 'pending';
    const CANCELLED_STATUS = 'cancelled';
    const PARTIAL_STATUS = 'partial';
    const CURRENCY_MISMATCH_STATUS = 'currency_mismatch';
    protected $tx_ref;
    protected $amount;
    protected $currency;
    protected $payment_method;
    protected $customerData; // this can also be an object
    protected $payment_url;
    public static $payment_status;
    protected $payment_details;
    protected $api_keys;

    public function __construct(iterable $keys, string $amount, string $currency, iterable $payment_method, Customer $customerData)
    {
        $this->set_tx_ref("PHP_SDK_" . time());
        $this->amount = $amount;
        $this->currency = $currency;
        $this->payment_method = $payment_method;
        $this->customerData = $customerData;
        $this->api_keys = $keys;
    }

    public static function confirm_payment(iterable $keys, string $tx_ref, $saved_transaction_details, $callback = null):string
    {
        if(!is_null($callback)){
            $callback(self::get_payment_status($keys, $tx_ref, $saved_transaction_details));
            return self::get_payment_status($keys, $tx_ref, $saved_transaction_details);
        }else{
            return self::get_payment_status($keys, $tx_ref, $saved_transaction_details);
        }
    }
    
    public static function get_payment_status(iterable $keys, string $tx_ref, iterable $saved_transaction_details):string
    {
       self::set_payment_status('Pending');
        $retured_payment_data = self::verify_payment($keys['SECRET_KEY'], $tx_ref);

        //confirm customer object
        if($retured_payment_data['customer'] instanceof Customer){
            
            if($retured_payment_data['status'] == 'successful' && $retured_payment_data['amount'] == $saved_transaction_details['amount'] && $retured_payment_data['currency'] == $saved_transaction_details['currency']){
                return self::set_payment_status(self::SUCCESS_STATUS);
            }
    
            if($retured_payment_data['status'] == 'successful' && $retured_payment_data['amount'] != $saved_transaction_details['amount'] && $retured_payment_data['currency'] == $saved_transaction_details['currency']){
                return self::set_payment_status(self::PARTIAL_STATUS);
            }
    
            if($retured_payment_data['status'] == 'successful' && $retured_payment_data['amount'] != $saved_transaction_details['amount'] && $retured_payment_data['currency'] != $saved_transaction_details['currency']){
                //work on automatic refund feature
                return self::set_payment_status(self::CURRENCY_MISMATCH_STATUS);
            }
    
            if($retured_payment_data['status'] == 'failed'){
                return self::set_payment_status(self::FAILED_STATUS);
            }
        }
    }

    public function set_api_keys(iterable $keys)
    {
        $this->api_keys = $keys;
    }
    
    protected function get_secret_key():string
    {
        return $this->api_keys['SECRET_KEY'];
    }
    
    public function get_public_key():string
    {
        return $this->api_keys['PUBLIC_KEY'];
    }
    
    public function get_payment_details():iterable
    {
        return $this->payment_details;
    }
    
    public function get_tx_ref():string
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
        return $this->customerData;
    }
    
    public function set_tx_ref(string $tx_ref)
    {
        $this->tx_ref = $tx_ref;
    }

    public static function set_payment_status(string $payment_status)
    {
        self::$payment_status = $payment_status;
        return self::$payment_status;
    }
    
    abstract public function get_payment_url(string $secKey, PaymentPayloadStandard $payload, $callback = null):string;
}