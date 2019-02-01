<?php

/**
 * 
 *
 */

namespace NxSys\Applications\Aether\RCE\Handlers;

use NxSys\Toolkits\Aether\SDK\Core\Boot\Event\Event;


/**
 * @Channels rce.submissions
 */
class SubmissionsHandler
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
			case 'newCommand':
			{
				//valid and new command
				
				break;
			}
		}

	}
}