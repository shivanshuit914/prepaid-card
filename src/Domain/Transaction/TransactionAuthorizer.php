<?php

namespace Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\User\Merchant;
use PhpSpec\Exception\Exception;

class TransactionAuthorizer
{
    /**
     * @var BalanceRepositoryInterface
     */
    private $balanceRepository;

    /**
     * TransactionAuthorizer constructor.
     * @param BalanceRepositoryInterface $balanceRepository
     */
    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * @param array $cardDetails
     * @param array $merchantDetails
     * @param int $amount
     * @throws Exception
     */
    public function authorize(array $cardDetails, array $merchantDetails, int $amount)
    {
        $card = PrepaidCard::withDetails($cardDetails);
        $avialableBalance = $this->balanceRepository->getTotalBalance($card);
        if ($avialableBalance <= $amount) {
            throw new Exception('Unauthorized transaction.');
        }

        $merchant = Merchant::withNameAndAccountDetails(
            $merchantDetails['name'],
            $merchantDetails['account_details']
        );
        $this->balanceRepository->blockBalance($card, $merchant, $amount);
    }
}
