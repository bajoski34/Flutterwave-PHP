<?php

namespace Flutterwave\Payload;

use Flutterwave\Traits\CardTrait;

abstract class CardAbstract 
{
    use CardTrait;

    public function __construct(int $card_number, int $card_cvv, int $card_expiry_month, int $card_expiry_year, string $card_holder_name, string $email)
    {
        $this->card_number = $card_number;
        $this->card_cvv = $card_cvv;
        $this->card_expiry_month = $card_expiry_month;
        $this->card_expiry_year = $card_expiry_year;
        $this->card_holder_name = $card_holder_name;
        $this->email = $email;
    }

    protected function get_card_number():string
    {
        return $this->card_number;
    }

    protected function get_card_cvv():string
    {
        return $this->card_cvv;
    }

    protected function get_card_expiry_month():string
    {
        return $this->card_expiry_month;
    }

    protected function get_card_expiry_year():string
    {
        return $this->card_expiry_year;
    }

    protected function get_card_holder_name():string
    {
        return $this->card_holder_name;
    }

    protected function get_email():string
    {
        return $this->email;
    }
}