<?php

namespace spec\Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Transaction\TransactionCapturer;
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

    function it_captures_blocked_transaction_amount()
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];
        $merchantDetails = ['name' => 'Coffee shop', 'account_details' => ['sortcode' => 123456, 'account_number' => 1233454]];
        $this->capture($merchantDetails, $cardDetails, 100);
    }
}
