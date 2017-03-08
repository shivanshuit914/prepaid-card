<?php

namespace spec\Domain\Card;

use Domain\Card\CardCreater;
use Domain\Card\CardRepositoryInterface;
use Domain\Card\PrepaidCard;
use Domain\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CardCreaterSpec extends ObjectBehavior
{
    function let(CardRepositoryInterface $cardRepository)
    {
        $this->beConstructedWith($cardRepository);
    }

    function it_throws_error_if_deetails_are_not_present()
    {
        $this->shouldThrow(\Exception::class)->duringCreateCard([]);
    }

    function it_creates_new_card_for_user(CardRepositoryInterface $cardRepository)
    {
//        $cardRepository->save(PrepaidCard::withNameAndDetails(
//            User::withNameAndAddress('MR Boss', 'London, E12234'),
//            []
//        ))->shouldBeCalled();
        $this->createCard(['name' => 'MR Boss', 'address' => 'London, E12234']);
    }
}
