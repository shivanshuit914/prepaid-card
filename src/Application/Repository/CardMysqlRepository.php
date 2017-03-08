<?php

namespace Application\Repository;

use Domain\Card\CardRepositoryInterface;
use Domain\Card\PrepaidCard;
use PDO;

class CardMysqlRepository implements CardRepositoryInterface
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(PrepaidCard $card)
    {
        $sql = "INSERT INTO prepaid_card (card_number, issue, expiry, security) 
                VALUES (:card_number, :issue, :expiry, :security)";
        $sth = $this->connection->prepare($sql);
        $cardDetails = $card->getCardDetails();
        $sth->bindParam("card_number", $cardDetails['number']);
        $sth->bindParam("issue", $cardDetails['issue']);
        $sth->bindParam("expiry", $cardDetails['expiry']);
        $sth->bindParam("security", $cardDetails['security']);
        $sth->execute();
    }
}