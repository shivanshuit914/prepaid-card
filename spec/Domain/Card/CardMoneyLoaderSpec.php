<?php

namespace spec\Domain\Card;

use Domain\Card\BalanceRepositoryInterface;
use Domain\Card\CardMoneyLoader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CardMoneyLoaderSpec extends ObjectBehavior
{
    function let(BalanceRepositoryInterface $balanceRepository)
    {
        $this->beConstructedWith($balanceRepository);
    }

    function it_loads_money_in_to_card()
    {
        $this->loadMoney(
            [
            'number' => 1234323423424232,
            'issue' => '05-16',
            'expiry' => '05-19',
            'security' => '123'
            ],
            100
        );
    }
}
