<?php

namespace Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\User\Merchant;

class TransactionRefunder
{
    /**
     * @var BalanceRepositoryInterface
     */
    private $balanceRepository;

    /**
     * TransactionRefunder constructor.
     * @param BalanceRepositoryInterface $balanceRepository
     */
    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function refund(array $merchantDetails, array $cardDetails, $amount)
    {
        $merchant = Merchant::withNameAndAccountDetails($merchantDetails['name'], $merchantDetails['account_details']);
        $card = PrepaidCard::withDetails($cardDetails);
        $capturedBalance = $this->balanceRepository->getCapturedBalanceByMerchant($merchant, $card);
        if ($amount > $capturedBalance) {
            throw new \Exception('Refund not authorized');
        }
        $this->balanceRepository->refundBalance($merchant, $card, $amount);
    }
}
