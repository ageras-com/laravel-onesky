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
        return <<<EOT
{"meta":{"status":201}}
EOT;
    }

    public function translations()
    {
        $this->lastCall = array_merge(['translations'], func_get_args());
        return <<<EOT
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
