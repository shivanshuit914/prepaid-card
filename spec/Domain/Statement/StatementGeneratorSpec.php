<?php

namespace spec\Domain\Statement;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Statement\StatementGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatementGeneratorSpec extends ObjectBehavior
{
    function let(BalanceRepositoryInterface $balanceRepository)
    {
        $this->beConstructedWith($balanceRepository);
    }

    function it_generates_transactions_statement_for_card()
    {
        $cardDetails = [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
        ];
        $this->generate($cardDetails);
    }
}
