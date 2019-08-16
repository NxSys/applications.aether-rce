<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core\Execution;
use NxSys\Applications\Aether\RCE\Command\ExecutionRequest;
use NxSys\Applications\Aether\RCE\Command\CommandEnvironment;
use NxSys\Toolkits\Parallax\Agent\BaseAgent;

class CommandEnvironmentHost //extends Execution\Supervisor
{
	public function __construct()
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		$this->agent = new BaseAgent();
	}

	public function submitNewCommandEnvironment(CommandEnvironment $oCmdEnv)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		$oCmdEnv->preinitializeEnvironment();
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		// $this->submit($oCmdEnv);
		$this->agent->start($oCmdEnv);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
	}

	public function submitCommandEnvironment()
	{

	}

	public function addNewExecutionRequest($oExReq)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		var_dump($oExReq);
		$oNewCmdEnvironment = new CommandEnvironment($oExReq->sCommandName, $oExReq);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		$this->submitNewCommandEnvironment($oNewCmdEnvironment);

	}
}
