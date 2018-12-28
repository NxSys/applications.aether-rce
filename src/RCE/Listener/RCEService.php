<?php

namespace NxSys\Applications\Aether\RCE\Listener;

use Exception;
use SoapServer;
use Psr;
use Ratchet;
use Zend;
use NxSys\Toolkits\Aether\SDK\Core\Boot\Event\Event;

/**
 *  SOAP Server
 * 
 */
class RCEService implements Ratchet\Http\HttpServerInterface
{
	protected $oListener;

	public function onOpen( Ratchet\ConnectionInterface $conn, Psr\Http\Message\RequestInterface $request = null )
	{

		// $oSoapServer=new SoapServer();
		$oSoapServer=new Zend\Soap\Server(null, ['uri' => "http://stds.aether.sh/soap"]);
		$oSoapServer->setObject($this);
		$oSoapServer->setReturnResponse(true);
		try
		{
			var_dump($request->getBody());
			$sReqBody=(string) $request->getBody();
			var_dump($sReqBody);
			$oSoapServer->handle($sReqBody);
		}
		catch (\Throwable $th)
		{
			print_r($th);
		}
		return;
	}
	public function onMessage(Ratchet\ConnectionInterface $from, $msg)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
	}

	public function onError(Ratchet\ConnectionInterface $conn, Exception $e)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
	}
	public function onClose(Ratchet\ConnectionInterface $conn)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
	}
	public function setListener($oListener)
	{
		return $this->oListener=$oListener;
	}

	public function sendEvent(string $sServiceAuthTicket, string $sChannel, string $sEventName, array $aEventData)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
		$oEvent=new Event($sChannel, $sEventName, $aEventData);
		$this->oListener->addEvent($oEvent);
		return;
	}
}
