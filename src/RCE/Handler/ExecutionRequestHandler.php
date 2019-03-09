<?php
/**
 * $BaseName$
 * $Id$
 *
 * DESCRIPTION
 *  A Core file for Aether.sh
 *
 * @link http://nxsys.org/spaces/aether
 * @link https://onx.zulipchat.com
 *
 * @package Aether
 * @subpackage System
 * @license http://nxsys.org/spaces/aether/wiki/license
 * Please see the license.txt file or the url above for full copyright and license information.
 * @copyright Copyright 2018 Nexus Systems, inc.
 *
 * @author Chris R. Feamster <cfeamster@f2developments.com>
 * @author $LastChangedBy$
 *
 * @version $Revision$
 */

/** @namespace Native Namespace */
namespace NxSys\Applications\Aether\RCE\Handler;

/** Local Project Dependencies **/
use
	NxSys\Applications\Aether\RCE\Command;

/** Framework Dependencies **/
use NxSys\Toolkits\Aether\SDK\Core;
use NxSys\Toolkits\Aether\SDK\Core\Boot\Event\Event;
use NxSys\Toolkits\Aether\SDK\Core\Boot\Container;

/** Library Dependencies **/
use NxSys\Core\ExtensibleSystemClasses as CoreEsc;

/**
 * Event sink for command execution events
 *
 * This takes events
 *
 * @throws NxSys\Toolkits\Aether\SDK\Core\IException Well, does it?
 * @author Chris R. Feamster <cfeamster@f2developments.com>
 */
class ExecutionRequestHandler
{
	public $oCmdEnvHost;
	// ctor deps
		//$this->oEventMgr= aether.boot.eventmanager
		// rce.cmdldr
		// rce.svc.CmdEnvHost

	/**
	 *
	 */
	public function handleEvent(Event $oEvent)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __METHOD__, __LINE__);
		$this->oEventMgr = Container::getDependency('aether.boot.eventmanager');
		//$oEventMgr->addEvent(new Event("terminal.command", "output", [1,1,'foooooooo']));

		// var_dump($oEvent);
		// output
		$aEvtData=$oEvent->getData();
		$aEvtData['args']=[];
		// var_dump($aEvtData);
		switch ($oEvent->getEvent())
		{
			//housekeeping
			case 'tick':
			{
				//every x ticks?

			}

			//requests
			case 'execute':
			{
				$oCmdEnvHost=Container::getDependency('rce.svc.CmdEnvHost');

				//execute new command job
				$oXReq=$aEvtData['ExecutionRequest'];
				printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
				$oCmdEnvHost->addNewExecutionRequest($oXReq);
				printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
				break;
			}
			case 'status':
			{
				//check and report on the status of running command

				break;
			}
		}
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		return;
	}

	public function __destruct()
	{
		//host->shutdown();
	}

}