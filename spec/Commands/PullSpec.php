<?php

namespace spec\Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Commands\Pull;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PullSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Pull::class);
    }
}
