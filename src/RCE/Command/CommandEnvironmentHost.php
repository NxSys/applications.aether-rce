<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core\Execution;
use NxSys\Applications\Aether\RCE\Command\ExecutionRequest;
use NxSys\Applications\Aether\RCE\Command\CommandEnvironment;

class CommandEnvironmentHost extends Execution\Supervisor
{
	public function submitNewCommandEnvironment(CommandEnvironment $oCmdEnv)
	{
		$this->submit($oCmdEnv);
	}

	public function submitCommandEnvironment()
	{

	}

	public function addNewExecutionRequest(ExecutionRequest $oExReq)
	{
		$this->submitNewCommandEnvironment(new CommandEnvironment($oExReq->sCommandName, $oExReq));
	}
}
