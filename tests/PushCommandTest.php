<?php

namespace Ageras\LaravelOneSky\Tests;

use Ageras\LaravelOneSky\Commands\Push;
use Ageras\LaravelOneSky\Exceptions\NumberExpected;
use Dotenv\Dotenv;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;

class PushCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $baseDir = dirname(dirname(__FILE__));
        if (is_readable($baseDir . '/.env')) {
            (new Dotenv($baseDir))->load();
        }
    }

    public function test_that_exception_is_thrown_when_no_project_id_is_found()
    {
        $this->expectException(NumberExpected::class);

        $push = new Push();
        $push->setLaravel($this->app);

        $push->run(
            new ArgvInput([
                'onesky:push',
            ]),
            new NullOutput()
        );
    }

    public function test_that_files_get_uploaded_using_the_client()
    {
        $push = new Push();
        $push->setLaravel($this->app);

        $client = $this->app->make('onesky');

        $output = new BufferedOutput();

        $push->run(
            new ArgvInput([
                'onesky:push',
                '--project=1337',
            ]),
            $output
        );

        $this->assertEquals([
            'files',
            'upload',
            [
                'project_id'  => '1337',
                'file'        => __DIR__ . '/stubs/lang/en/test.php',
                'file_format' => 'PHP_SHORT_ARRAY',
                'locale'      => 'en',
            ],
        ], $client->lastCall());

        $this->assertEquals("Files were uploaded successfully!\n", $output->fetch());
    }
}
