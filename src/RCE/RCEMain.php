<?php
/**
 * $BaseName$
 * $Id$
 *
 * DESCRIPTION
 *  Application Entrypoint for ACN
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
namespace NxSys\Applications\Aether\RCE;

//Domestic Namespaces
use NxSys\Applications\Aether;
use NxSys\Toolkits\Aether\SDK\Core;
use NxSys\Toolkits\Aether\SDK\Core\Boot\Container;

//Framework Namespaces
use Symfony\Component\Console as sfConsole;
use NxSys\Core\ExtensibleSystemClasses as CoreEsc;


class RCEMain extends Core\Boot\Main
{
	public $sShortName='rce';

	public function __contruct(Type $var = null)
	{
		# code...
	}

	public function getShortName(): string
	{
		return $this->sShortName;
	}

	public function getRunMode(): string
	{
		//or maintenance
		return 'default';
	}

	public function maintenanceRun()
	{
		echo "maintenanceRun";
	}

	public function start(): int
	{
		$this->log("Starting RCE...");
		$this->log("//init Event Manager");
		$oEventMgr = Container::getDependency('Aether.boot.eventmanager');
		$oEventMgr->addEvent(new Core\Boot\Event\Event("rce.sys", "starting"));

		$this->log("//init acn</>rce listeners");
		$hAcnCommsFiber=Container::getDependency('rce.svc.fiber.AcnComms');
		$oListener = Container::getDependency('rce.svc.AcnComms.listener');

		$hAcnCommsFiber->setupConstants(Container::getConfigParam('base.constants'));
		$hAcnCommsFiber->start(PTHREADS_INHERIT_NONE);
		$hAcnCommsFiber->setListener($oListener);


		$this->log("//init handler");
		$this->log("//start listener threads (rce[1])");

		$hAcnCommsFiber->setEventQueue($oEventMgr->getQueue());
		$oEventMgr->addHandler($hAcnCommsFiber);
		$oEventMgr->addEvent(new Core\Boot\Event\Event("rce.sys", "loopStarted"));
		$a=0;
		do
		{
			//---housekeeping---
			//are threads up? & healthy

				// $hTermCommsFiber->

			//---message passing---
			//internal?

			//error handling/recovery
			if ($iPendEventCount=count($oEventMgr->getQueue()))
			{
				$this->log(sprintf('Main event queue is %s deep.', $iPendEventCount));
			}
			$oEventMgr->processEvent();
			sleep(1);
			$a++;
			# code...
		}
		while ($a <= 999999 );
		$oEventMgr->addEvent(new Core\Boot\Event\Event("rce.sys", "shutdownRequested"));
		$oEventMgr->addEvent(new Core\Boot\Event\Event("rce.sys", "loopStoped"));
		//clean up
		$this->log("//Clean up");
		$this->log("Stopping services...");
		$hAcnCommsFiber->halt();
		$hAcnCommsFiber->join();

		// sleep(2);
		$this->log("RCE exiting...");
		$oEventMgr->addEvent(new Core\Boot\Event\Event("rce.sys", "exited"));
		return 0;
	}


	public function handleEvent(Core\Boot\Event\Event $oEv)
	{
		$this->log(sprintf("Observed %s:%s", $oEv->getChannel(), $oEv->getEvent()), (array) $oEv->getData());
	}

	public function getChannels(): array
	{
		return [];
	}

	public function getEvents(): array
	{
		return [];
	}

	public function getPriority(): int
	{
		return -1;
	}
}

