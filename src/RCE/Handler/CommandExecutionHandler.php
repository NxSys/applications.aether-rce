<?php

namespace NxSys\Applications\Aether\RCE\Handler;

class CommandExecutionHandler
{
	public function handleEvent(Event $oEvent)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __METHOD__, __LINE__);
		$this->oEventMgr = Container::getDependency('aether.boot.eventmanager');
		//$oEventMgr->addEvent(new Event("terminal.command", "output", [1,1,'foooooooo']));

		//var_dump($oEvent);
		// output
		switch ($oEvent->getEvent())
		{
			case 'execute':
			{
				//validate and execute new command job

				break;
			}
			case 'status':
			{
				//check and report on the status of running command
				
				break;
			}
		}

	}

}