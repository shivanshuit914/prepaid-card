<?php

namespace Application\Repository;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\User\Merchant;

class BalanceMysqlRepository implements BalanceRepositoryInterface
{
    public function addBalance(PrepaidCard $card, $amount)
    {

    }

    public function blockBalance(PrepaidCard $card, $amount)
    {

    }

    public function captureBalance(PrepaidCard $card, $amount, Merchant $merchant)
    {

    }

    public function refundBalance(PrepaidCard $card, $amount)
    {

    }

    public function getBalance($cardNumber)
    {

    }
}