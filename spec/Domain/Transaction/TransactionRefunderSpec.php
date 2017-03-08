<?php

namespace spec\Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\Transaction\TransactionRefunder;
use Domain\User\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionRefunderSpec extends ObjectBehavior
{
    function let(BalanceRepositoryInterface $balanceRepository)
    {
        $this->beConstructedWith($balanceRepository);
    }

    function it_refunds_the_amount_captured_by_merchant(BalanceRepositoryInterface $balanceRepository)
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];
        $merchantDetails = ['name' => 'Coffee shop', 'account_details' => ['sortcode' => 123456, 'account_number' => 1233454]];
        $merchant = Merchant::withNameAndAccountDetails($merchantDetails['name'], $merchantDetails['account_details']);
        $card = PrepaidCard::withDetails($cardDetails);
        $balanceRepository->getCapturedBalanceByMerchant(
            $merchant, $card)
            ->willReturn(100);
        $balanceRepository->refundBalance($merchant, $card, 100)->shouldBeCalled();
        $this->refund($merchantDetails, $cardDetails, 100);
    }

    function it_gives_error_when_merchant_tries_to_refund_more_than_captured_amount(BalanceRepositoryInterface $balanceRepository)
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];
        $merchantDetails = ['name' => 'Coffee shop', 'account_details' => ['sortcode' => 123456, 'account_number' => 1233454]];

        $balanceRepository->getCapturedBalanceByMerchant(
            Merchant::withNameAndAccountDetails($merchantDetails['name'], $merchantDetails['account_details']), PrepaidCard::withDetails($cardDetails))
            ->willReturn(100);
        $this->shouldThrow(\Exception::class)->duringRefund($merchantDetails, $cardDetails, 10000);
    }
}
