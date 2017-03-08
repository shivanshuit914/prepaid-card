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

    }
}