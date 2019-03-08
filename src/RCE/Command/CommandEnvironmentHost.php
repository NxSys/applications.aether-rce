<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core\Execution;


class CommandEnvironmentHost extends Execution\Supervisor
{
	public function submitNewCommandEnvironemt(CommandEnvironment $oCmdEnv)
	{
		$this->submit($oCmdEnv);
	}

	public function submitCommandEnvironment()
	{

	}
}
