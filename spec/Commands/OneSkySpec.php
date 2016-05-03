<?php

namespace spec\Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Commands\OneSky;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OneSkySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OneSky::class);
    }
}
