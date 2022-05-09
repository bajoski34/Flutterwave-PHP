<?php

namespace Flutterwave\Payload;

use Flutterwave\Customer\Customer;
use Flutterwave\Payment\Card;
// $details = array(
//     "card_number":"5531886652142950",
//     "cvv":"564",
//     "expiry_month":"09",
//     "expiry_year":"32",
//     "currency":"NGN",
//     "amount":"100",
//     "fullname":"Flutterwave Developers",
//     "email":"developers@flutterwavego.com",
//     "tx_ref":"MC-3243e",
//     "redirect_url":"https://www.flutterwave.ng"
// );

class CardPayload extends AbstractPayload
{
    private $card_number;
    private $card_cvv;
    private $card_expiry_month;
    private $card_expiry_year;
    private $card_holder_name;
    private $email;
    public function __construct(Card $cards, string $tx_ref, int $amount, string $currency, iterable $payment_method, Customer $customerData, string $redirect_url)
    {
        $this->$card_number = $cards->get_card_number();
        $this->$card_cvv = $cards->get_card_cvv();
        $this->$card_expiry_month = $cards->get_card_expiry_month();
        $this->$card_expiry_year = $cards->get_card_expiry_year();
        $this->$card_holder_name = $cards->get_card_holder_name();
        $this->$email = $cards->get_email();
        parent::__construct($tx_ref, $amount, $currency, $payment_method, $customerData, $redirect_url);
    }

    public function set_card_number(string $card_number):void
    {
        $this->card_number = $card_number;
    }

    public function getPayload(): iterable
    {
        $existing_data = parent::getPayload();
        $existing_data['card_number'] = $this->card_number;
        $existing_data['cvv'] = $this->card_cvv;
        $existing_data['expiry_month'] = $this->card_expiry_month;
        $existing_data['expiry_year'] = $this->card_expiry_year;
        $existing_data['fullname'] = $this->card_holder_name;
        $existing_data['email'] = $this->email;
        //remove useless data
        unset($existing_data['customer']);
        unset($existing_data['metadata']);
        unset($existing_data['customization']);

        print_r($existing_data);
        exit();
        return $existing_data;
    }


}