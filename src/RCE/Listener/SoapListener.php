<?php

namespace NxSys\Applications\Aether\RCE\Listener;

use NxSys\Toolkits\Aether\SDK\Core;
use NxSys\Toolkits\Aether\SDK\Core\Boot\Event;
use NxSys\Toolkits\Aether\SDK\Core\Boot\Container;

use NxSys\Applications\Aether\RCE\Listener\RCEService;

use Ratchet;
use React;


use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;


/**
 * Actuall listener
 */
class SoapListener  extends Core\Comms\BaseListener
{
	static $hSockServer;
	/** @var string $sHost Hostheader */
	protected $sHost = null;
	/** @var string $sInterface Single IP interface to bind to */
	protected $sInterface = null;
	/** @var int $iPort Port to bind to */
	protected $iPort = null;
	/** @var string $sPath URI part part the WS server will respond to */
	protected $sPath = null;

	/** @var object $oRatchetSockLoop description */
	public $oRatchetSockLoop;

	public function listenLoop(): void
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
        $oHandler=new RCEService;
        $oHandler->setListener($this);

		$loop=React\EventLoop\Factory::create();
		// $loop->addPeriodicTimer(1, [$this,'loopMaintenance']);
		$loop->addPeriodicTimer(1, function() use ($loop) { $this->loopMaintenance($loop); });

		#@todo support mounting of multiple routes??
		$http = new HttpServer($oHandler);
		// $this->hSockServer=new Ratchet\App('10.100.0.6', 8355, '0.0.0.0', $loop);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		$hSock=new React\Socket\Server('0.0.0.0:8335', $loop);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		$hSockServer=new IoServer($http, $hSock, $loop);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);

		// $hSockServer->route('/', $oHandler);
		$hSockServer->run();
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
	}

	public function processEvents(): void
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
		while ($oEvent = $this->getThreadContext()->getInEvent())
		{
			var_dump($oEvent);
		}
	}

	public function setBinding(string $sHost, string $sInterface, int $iPort)
	{
		# code...
	}

	public function loopMaintenance(React\EventLoop\LoopInterface $loop)
	{
		//@todo is React\EventLoop\Timer\Timer useful here?

		// printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
		// var_dump("Loop Maintenance");
		$sStatus=$this->oThreadContext->fiberSignal();
		if($sStatus)
		{
			$loop->stop();
			//log("AHHHHHHHHHHHHHHHHHHHHHHHHH");
		}
	}


}
