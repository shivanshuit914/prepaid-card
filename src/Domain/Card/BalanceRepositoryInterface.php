<?php

namespace Domain\Card;

use Domain\User\Merchant;

interface BalanceRepositoryInterface
{
    public function addBalance(PrepaidCard $card, $amount);

    public function getTotalBalance(PrepaidCard $card);

    public function blockBalance(PrepaidCard $card, Merchant $merchant, $amount);

    public function getBlockedBalanceByMerchant(Merchant $merchant,PrepaidCard $card);

    public function captureBalance(PrepaidCard $card, $amount, Merchant $merchant);

    public function getCapturedBalanceByMerchant(Merchant $merchant, PrepaidCard $card);

    public function refundBalance(Merchant $merchant, PrepaidCard $card, $amount);

    public function getTransactions(PrepaidCard $card);
}