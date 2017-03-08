<?php

namespace spec\Domain\User;

use Domain\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWithNameAndAddress('MR Boss', 'London, E12234');
    }

    function it_exposes_name()
    {
        $this->getName()->shouldReturn('MR Boss');
    }
}
