<?php

namespace spec\Domain\Transaction;

use Domain\Card\PrepaidCard;
use Domain\Transaction\Transaction;
use Domain\User\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionSpec extends ObjectBehavior
{
    function let(PrepaidCard $prepaidCard, Merchant $merchant)
    {
        $this->beConstructedWithDetails(
            $prepaidCard,
            $merchant,
            10
        );
    }
}
