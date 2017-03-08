<?php

namespace Domain\Card;

interface BalanceRepositoryInterface
{
    public function addBalance(PrepaidCard $card, $amount);
}