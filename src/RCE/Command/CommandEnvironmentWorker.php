<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core\Execution;
use NxSys\Applications\Aether\RCE\Command\ExecutionRequest;
// use NxSys\Applications\Aether\RCE\Command\CommandEnvironment;

class CommandEnvironmentWorker extends Execution\Agent\BaseAgent
{
    public function start(int $iThreadMode=PTHREADS_INHERIT_NONE)
    {
        parent::start($iThreadMode);
    }
}
