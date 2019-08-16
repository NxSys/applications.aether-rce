<?php

/**
 *
 *
 */

namespace NxSys\Applications\Aether\RCE\Handler;

/** Local Project Dependencies **/
use NxSys\Toolkits\Aether\SDK\Core\Boot\Container,
	NxSys\Toolkits\Aether\SDK\Core\Boot\Event\Event,
	NxSys\Applications\Aether\RCE\Command;
use NxSys\Core\ExtensibleSystemClasses\stdClass;




/**
 * @Channels rce.submissions
 */
class SubmissionsHandler
{
	public function handleEvent(Event $oEvent)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		$this->oEventMgr = Container::getDependency('aether.boot.eventmanager');
		//$oEventMgr->addEvent(new Event("terminal.command", "output", [1,1,'foooooooo']));

		//var_dump($oEvent);
		$aEvtData=$oEvent->getData();

		switch ($oEvent->getEvent())
		{
			case 'newCommand':
			{
				//validate and create ExecutionRequest
				$oXReq=new Command\ExecutionRequest;

				# @todo quickly refactor
				$oXReq->iExecutionId=$aEvtData["iExecutionId"];
				$oXReq->sCommandName =$aEvtData["command"];
				//$oXReq->iExecutionState=Command\ExecutionRequest::EXECUTIONSTATE_RCE_ACCEPTED;

				//check args
				// $oXReq->oParameterSet=new stdClass;
				//sleep(3);

				var_dump(serialize($oXReq));
				var_dump($oXReq);
				$this->oEventMgr->addEvent(new Event("command", "execute", ['ExecutionRequest' => $oXReq] ));
				printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);

				break;
			}
		}

	}
}