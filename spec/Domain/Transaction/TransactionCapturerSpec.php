<?php

namespace spec\Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\Transaction\TransactionCapturer;
use Domain\User\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionCapturerSpec extends ObjectBehavior
{
    function let(BalanceRepositoryInterface $balanceRepository)
    {
        $this->beConstructedWith($balanceRepository);
    }

    function it_not_allows_to_capture_more_than_bloacked_amount()
    {
        $cardDetails = [
        'number' => 1234323423424232,
        'issue' => '05-16',
        'expiry' => '05-19',
        'security' => '123'
        ];
        $merchantDetails = ['name' => 'Coffee shop', 'account_details' => ['sortcode' => 123456, 'account_number' => 1233454]];

        $this->shouldThrow(\Exception::class)->duringCapture($merchantDetails, $cardDetails, 10000);
    }

    function it_captures_blocked_transaction_amount(BalanceRepositoryInterface $balanceRepository)
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];
        $merchantDetails = ['name' => 'Coffee shop', 'account_details' => ['sortcode' => 123456, 'account_number' => 1233454]];
        $merchant = Merchant::withNameAndAccountDetails($merchantDetails['name'], $merchantDetails['account_details']);
        $balanceRepository->getBlockedBalanceByMerchant($merchant, PrepaidCard::withDetails($cardDetails))->willReturn(100);
        $balanceRepository->captureBalance(PrepaidCard::withDetails($cardDetails), 100, $merchant)->shouldBeCalled();;
        $this->capture($merchantDetails, $cardDetails, 100);
    }
}
