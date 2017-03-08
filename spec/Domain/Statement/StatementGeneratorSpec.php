<?php

namespace spec\Domain\Statement;

use Domain\Statement\StatementGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatementGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StatementGenerator::class);
    }
}
