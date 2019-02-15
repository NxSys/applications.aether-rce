<?php

namespace NxSys\Applications\Aether\RCE\Listener;

use Exception;
use SoapServer;
use SoapFault;
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
			$sServiceResponse=$oSoapServer->handle($sReqBody);
			//print_r($sServiceResponse);
			if ($sServiceResponse instanceof SoapFault)
			{
				var_dump($sServiceResponse);
				$conn->send('Error!'); //@todo xml error
				$conn->close();
				return;
			}
			$conn->send($sServiceResponse);
			$conn->close();
			print "handled without error...\n";
		}
		catch (\Throwable $th)
		{
			print_r((string) $th);
			print_r($th);
		}
		print "request complete\n";
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

	/**
	 * Accepts an event to "process"
	 *
	 * @param string $sServiceAuthTicket
	 * @param string $sChannel
	 * @param string $sEventName
	 * @param array $aEventData
	 * @return string
	 */
	public function addEvent(string $sServiceAuthTicket, string $sChannel, string $sEventName, array $aEventData)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
		$oEvent=new Event($sChannel, $sEventName, $aEventData);
		$this->oListener->getThreadContext()->addEvent($oEvent);
		return 'OK';
	}
}
