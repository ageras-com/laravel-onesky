<?php

namespace spec\Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Commands\Push;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PushSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Push::class);
    }

    function it_prepares_the_upload_data()
    {
        $this->prepareUploadData(1337, 'en', [
            'resources/lang/mail.php',
            'resources/lang/actions.php',
            'resources/lang/validation.php',
        ])->shouldReturn([
            ['project_id' => 1337, 'file' => 'resources/lang/en/mail.php', 'file_format' => 'PHP', 'locale' => 'en'],
            ['project_id' => 1337, 'file' => 'resources/lang/en/actions.php', 'file_format' => 'PHP', 'locale' => 'en'],
            ['project_id' => 1337, 'file' => 'resources/lang/en/validation.php', 'file_format' => 'PHP', 'locale' => 'en'],
        ]);
    }

    function it_scans_the_path_for_files()
    {
        $this->scanDir(__DIR__ . '/../../src')->shouldReturn([
            'Commands',
            'Exceptions',
            'ServiceProvider.php',
        ]);

        $this->scanDir(__DIR__ . '/../../src', 1)->shouldReturn([
            'Commands',
            'Exceptions',
        ]);
    }
}
