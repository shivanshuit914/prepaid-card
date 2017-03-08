<?php

namespace spec\Domain\User;

use Domain\User\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MerchantSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWithNameAndAccountDetails('Coffee shop', ['sortcode' => 123456, 'account_number' => 1233454]);
    }

    function it_exposes_merchant_name()
    {
        $this->getName()->shouldReturn('Coffee shop');
    }

    function it_exposes_account_details()
    {
        $this->getAccountDetails()->shouldReturn(['sortcode' => 123456, 'account_number' => 1233454]);
    }
}
