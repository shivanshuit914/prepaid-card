<?php

namespace Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\User\Merchant;

class TransactionCapturer
{
    /**
     * @var BalanceRepositoryInterface
     */
    private $balanceRepository;

    /**
     * TransactionCapturer constructor.
     * @param BalanceRepositoryInterface $balanceRepository
     */
    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * @param array $merchantDetails
     * @param array $cardDetails
     * @param int $amount
     * @throws \Exception
     */
    public function capture(array $merchantDetails, array $cardDetails, int $amount)
    {
        $merchant = Merchant::withNameAndAccountDetails($merchantDetails['name'], $merchantDetails['account_details']);
        $card = PrepaidCard::withDetails($cardDetails);
        $blockedBalance = $this->balanceRepository->getBlockedBalanceByMerchant($merchant, $card);

        if ($amount > $blockedBalance) {
            throw new \Exception('Unauthorized capture');
        }

        $this->balanceRepository->captureBalance($card, $amount, $merchant);
    }
}
