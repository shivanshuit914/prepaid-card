<?php

namespace spec\Domain\Card;

use Domain\Card\PrepaidCard;
use Domain\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PrepaidCardSpec extends ObjectBehavior
{
    function let(User $user)
    {
        $this->beConstructedWithNameAndDetails(
            $user,
            [
                'number' => 1234323423424232,
                'issue' => '05-16',
                'expiry' => '05-19',
                'security' => '123'
            ]
        );
    }

    function it_exposes_card_details()
    {
        $this->getCardDetails()->shouldReturn(
            [
                'number' => 1234323423424232,
                'issue' => '05-16',
                'expiry' => '05-19',
                'security' => '123'
            ]
        );
    }
}
