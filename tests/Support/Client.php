<?php

namespace Ageras\LaravelOneSky\Tests\Support;

class Client
{
    protected $lastCall;

    public function setApiKey()
    {
        return $this;
    }

    public function setSecret()
    {
        return $this;
    }

    public function files()
    {
        $this->lastCall = array_merge(['files'], func_get_args());

        return <<<'EOT'
{"meta":{"status":201}}
EOT;
    }

    public function translations()
    {
        $this->lastCall = array_merge(['translations'], func_get_args());

        if ($this->lastCall[2]['project_id'] == '1338') {
            return <<<'EOT'
{"meta":{"status":400,"message":"Invalid project id"}}
EOT;
        }

        return <<<'EOT'
<?php

return [
    'welcome' => 'Velkommen',
];
EOT;
    }

    public function lastCall()
    {
        return $this->lastCall;
    }
}
