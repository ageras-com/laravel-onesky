<?php

namespace Ageras\LaravelOneSky\Tests;

use Ageras\LaravelOneSky\Commands\Pull;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;

class PullCommandTest extends TestCase
{
    protected $testFilePath = __DIR__ . '/stubs/lang/da/test.php';

    public function tearDown()
    {
        parent::tearDown();
        file_put_contents($this->testFilePath, '<?php return [];');
    }

    /**
     * @expectedException \Ageras\LaravelOneSky\Exceptions\NumberExpected
     */
    public function test_that_exception_is_thrown_when_no_project_id_is_found()
    {
        $pull = new Pull();
        $pull->setLaravel($this->app);

        $pull->run(
            new ArgvInput([
                'onesky:pull',
            ]),
            new NullOutput()
        );
    }

    public function test_that_translations_are_downloaded_using_the_client()
    {
        $pull = new Pull();
        $pull->setLaravel($this->app);

        $client = $this->app->make('onesky');

        $output = new BufferedOutput();

        $this->assertEquals([], require($this->testFilePath));

        $pull->run(
            new ArgvInput([
                'onesky:pull',
                '--project=1337',
            ]),
            $output
        );

        $this->assertEquals([
            'translations',
            'export',
            [
                'project_id'       => '1337',
                'locale'           => 'da',
                'source_file_name' => 'test.php',
            ],
        ], $client->lastCall());

        $this->assertEquals(['welcome' => 'Velkommen'], require($this->testFilePath));
        $this->assertEquals("Translations were downloaded successfully!\n", $output->fetch());
    }

    public function test_that_error_is_shown_in_the_console_when_response_from_client_is_invalid()
    {
        $pull = new Pull();
        $pull->setLaravel($this->app);

        $client = $this->app->make('onesky');

        $output = new BufferedOutput();

        $this->assertEquals([], require($this->testFilePath));

        $pull->run(
            new ArgvInput([
                'onesky:pull',
                '--project=1338',
            ]),
            $output
        );

        $this->assertEquals([], require($this->testFilePath));
        $this->assertEquals(<<<EOT
Invalid response:
  File:      test.php
  Locale:    da
  Response:              {"meta":{"status":400,"message":"Invalid project id"}}
Something failed during the translation download. Please check the output.

EOT
            , $output->fetch());
    }
}
