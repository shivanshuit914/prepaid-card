<?php

namespace spec\Domain\Transaction;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\Transaction\TransactionAuthorizer;
use Domain\User\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionAuthorizerSpec extends ObjectBehavior
{
    public function let(BalanceRepositoryInterface $balanceRepository)
    {
        $this->beConstructedWith($balanceRepository);
    }

    public function it_throws_un_authorized_transations_when_balance_is_less_than_transaction_amount(BalanceRepositoryInterface $balanceRepository)
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];

        $balanceRepository->getTotalBalance(PrepaidCard::withDetails($cardDetails))->willReturn(10);

        $merchantDetails = ['name' => 'Coffee shop', ['sortcode' => 123456, 'account_number' => 1233454]];

        $this->shouldThrow(\Exception::class)->duringAuthorize($cardDetails, $merchantDetails, 100);
    }

    public function it_authorizes_transaction(BalanceRepositoryInterface $balanceRepository)
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];

        $card = PrepaidCard::withDetails($cardDetails);
        $balanceRepository->getTotalBalance($card)->willReturn(10000);
        $merchantDetails = ['name' => 'Coffee shop', 'account_details' => ['sortcode' => 123456, 'account_number' => 1233454]];
        $merchant = Merchant::withNameAndAccountDetails($merchantDetails['name'], $merchantDetails['account_details']);
        $balanceRepository->blockBalance($card, $merchant, 1000)->shouldBeCalled();

        $this->authorize($cardDetails, $merchantDetails, 1000);
    }
}
