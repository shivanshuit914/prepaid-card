<?php

namespace Domain\Card;

class CardMoneyLoader
{
    /**
     * @var BalanceRepositoryInterface
     */
    private $balanceRepository;

    /**
     * CardMoneyLoader constructor.
     * @param BalanceRepositoryInterface $balanceRepository
     */
    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function loadMoney(array $cardDetails, int $amount)
    {
        $this->balanceRepository->addBalance(PrepaidCard::withDetails($cardDetails), $amount);
    }
}
