<?php

namespace spec\Ageras\LaravelOneSky\Commands;

use Ageras\LaravelOneSky\Commands\Push;
use PhpSpec\ObjectBehavior;

class PushSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Push::class);
    }

    public function it_prepares_the_upload_data()
    {
        $this->prepareUploadData(1337, 'en', [
            '/path/to/resources/lang/en/mail.php',
            '/path/to/resources/lang/en/actions.php',
            '/path/to/resources/lang/en/validation.php',
        ])->shouldReturn([
            ['project_id' => 1337, 'file' => '/path/to/resources/lang/en/mail.php', 'file_format' => 'PHP_SHORT_ARRAY', 'locale' => 'en'],
            ['project_id' => 1337, 'file' => '/path/to/resources/lang/en/actions.php', 'file_format' => 'PHP_SHORT_ARRAY', 'locale' => 'en'],
            ['project_id' => 1337, 'file' => '/path/to/resources/lang/en/validation.php', 'file_format' => 'PHP_SHORT_ARRAY', 'locale' => 'en'],
        ]);
    }

    public function it_scans_the_path_for_files()
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
