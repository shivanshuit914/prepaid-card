<?php

namespace spec\Domain\Transaction;

use Domain\Transaction\TransactionAuthorizer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionAuthorizerSpec extends ObjectBehavior
{
    public function let()
    {

    }

    public function it_authorizes_transaction()
    {
        $this->authorize();
    }
}
