<?php

namespace Application\Repository;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\User\Merchant;
use PDO;

class BalanceMysqlRepository implements BalanceRepositoryInterface
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function addBalance(PrepaidCard $card, $amount)
    {

    }

    public function blockBalance(PrepaidCard $card, Merchant $merchant, $amount)
    {

    }

    public function captureBalance(PrepaidCard $card, $amount, Merchant $merchant)
    {

    }

    public function refundBalance(Merchant $merchant, PrepaidCard $card, $amount)
    {

    }

    public function getTotalBalance(PrepaidCard $cardNumber)
    {

    }

    public function getBlockedBalanceByMerchant(Merchant $merchant,PrepaidCard $card)
    {

    }

    public function getCapturedBalanceByMerchant(Merchant $merchant, PrepaidCard $card)
    {

    }

    public function getTransactions(PrepaidCard $card)
    {
    }
}