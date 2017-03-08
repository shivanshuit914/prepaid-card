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

    const TOP_UP = 'topup';
    const BLOCK = 'block';
    const REFUND = 'refund';
    const CAPTURE = 'capture';

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function addBalance(PrepaidCard $card, $amount)
    {
        $sql = "INSERT INTO balance (card_number, amount, reference, status) 
                VALUES (:card_number, :amount, :reference, :status)";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindParam("amount", $amount);
        $sth->bindValue("reference", 'money added by user');
        $sth->bindValue("status", static::TOP_UP);
        $sth->execute();
    }

    public function blockBalance(PrepaidCard $card, Merchant $merchant, $amount)
    {
        $sql = "INSERT INTO balance (card_number, amount, reference, status, merchant_account, merchant_reference) 
                VALUES (:card_number, :amount, :reference, :status, :merchant_account, :merchant_reference)";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindValue("amount", -1 * $amount);
        $sth->bindValue("reference", 'blocked by merchant');
        $sth->bindValue("status", static::BLOCK);
        $sth->bindValue("merchant_account", $merchant->getAcountNumber());
        $sth->bindValue("merchant_reference", static::BLOCK . $merchant->getName());
        $sth->execute();
    }

    public function captureBalance(PrepaidCard $card, $amount, Merchant $merchant)
    {
        $sql = "INSERT INTO balance (card_number, amount, reference, status, merchant_account, merchant_reference) 
                VALUES (:card_number, :amount, :reference, :status, :merchant_account, :merchant_reference)";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindValue("amount", -1 * $amount);
        $sth->bindValue("reference", 'captured added by merchant');
        $sth->bindValue("status", static::CAPTURE);
        $sth->bindValue("merchant_account", $merchant->getAcountNumber());
        $sth->bindValue("merchant_reference", static::BLOCK . $merchant->getName());
        $sth->execute();
    }

    public function refundBalance(Merchant $merchant, PrepaidCard $card, $amount)
    {
        $sql = "INSERT INTO balance (card_number, amount, reference, status, merchant_account, merchant_reference) 
                VALUES (:card_number, :amount, :reference, :status, :merchant_account, :merchant_reference)";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindValue("amount", $amount);
        $sth->bindValue("reference", 'refunded by merchant');
        $sth->bindValue("status", static::REFUND);
        $sth->bindValue("merchant_account", $merchant->getAcountNumber());
        $sth->bindValue("merchant_reference", static::BLOCK . $merchant->getName());
        $sth->execute();
    }

    public function getTotalBalance(PrepaidCard $card)
    {
        $sql = "SELECT sum(amount) as totalBalance FROM balance WHERE card_number = :card_number";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->execute();
        return $sth->fetchColumn();
    }

    public function getBlockedBalanceByMerchant(Merchant $merchant,PrepaidCard $card)
    {
        $sql = "SELECT sum(amount) as totalBalance FROM balance 
                WHERE card_number = :card_number AND status = :status AND merchant_account = :merchant_account";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindValue("merchant_account", $merchant->getAcountNumber());
        $sth->bindValue("status", static::BLOCK);
        $sth->execute();
        return abs($sth->fetchColumn());
    }

    public function getCapturedBalanceByMerchant(Merchant $merchant, PrepaidCard $card)
    {
        $sql = "SELECT sum(amount) as totalBalance FROM balance 
                WHERE card_number = :card_number AND status = :status AND merchant_account = :merchant_account";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindValue("status", static::CAPTURE);
        $sth->bindValue("merchant_account", $merchant->getAcountNumber());
        $sth->execute();
        return abs($sth->fetchColumn());
    }

    public function getTransactions(PrepaidCard $card)
    {
        $sql = "SELECT * FROM balance WHERE card_number = :card_number";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->execute();
        return $sth->fetchAll();
    }
}