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
        $oHandler=new RCEService;
        $oHandler->setListener($this);

		$loop=React\EventLoop\Factory::create();
		// $this->hSockServer=new Ratchet\App('10.100.0.6', 8355, '0.0.0.0', $loop);

		#@todo support mounting of multiple routes??
		$http = new HttpServer($oHandler);
		$hSock=new React\Socket\Server('0.0.0.0:8335', $loop);
		$hSockServer=new IoServer($http, $hSock, $loop);

		// $hSockServer->route('/', $oHandler);
		$hSockServer->run();
	}

	public function processEvents(): void
	{
		while ($oEvent = $this->getThreadContext()->getInEvent())
		{
			$oEvent;
		}
	}

	public function setBinding(string $sHost, string $sInterface, int $iPort)
	{
		# code...
	}

	public function loopMaintenance()
	{
		var_dump("Loop Maintenance");
		$sStatus=$this->oThreadContext->fiberSignal();
		if($sStatus)
		{
			$this->oRatchetSockLoop->end();
			echo "AHHHHHHHHHHHHHHHHHHHHHHHHH";
		}
	}


}

