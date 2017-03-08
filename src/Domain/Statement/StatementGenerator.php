<?php

namespace Domain\Statement;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;

class StatementGenerator
{
    /**
     * @var BalanceRepositoryInterface
     */
    private $balanceRepository;

    /**
     * StatementGenerator constructor.
     * @param BalanceRepositoryInterface $balanceRepository
     */
    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * @param array $cardDetails
     * @return mixed
     * @throws \Exception
     */
    public function generate(array $cardDetails)
    {
        $card = PrepaidCard::withDetails($cardDetails);

        $transactions = $this->balanceRepository->getTransactions($card);

        if (empty($transactions)) {
            throw new \Exception('No record found.');
        }

        return $transactions;
    }
}
