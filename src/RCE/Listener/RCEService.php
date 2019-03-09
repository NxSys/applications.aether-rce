<?php

namespace NxSys\Applications\Aether\RCE\Listener;

use NxSys\Toolkits\Aether\SDK\Core\Boot\Event\Event;

use Ratchet;
use Zend;

use GuzzleHttp\Psr7 as gPsr;
use GuzzleHttp\Psr7\Response;

use SoapFault;
use Exception;
use DateTime;
use SoapServer;
use Psr;

/**
 *  SOAP Server
 *
 */
class RCEService implements Ratchet\Http\HttpServerInterface
{
	public $aDefaultHeaders=['X-Powered-By' => APP_IDENT.' RCE/'.APP_VERSION];
	protected $oListener;

	public function onOpen(Ratchet\ConnectionInterface $conn, Psr\Http\Message\RequestInterface $request = null)
	{

		// $oSoapServer=new SoapServer();
		$oSoapServer=new Zend\Soap\Server(null, ['uri' => "http://stds.aether.sh/soap",
												 'parse_huge' => true,
												//  'send_errors' => false
												]);
		$oSoapServer->setObject($this);
		$oSoapServer->setReturnResponse(true);

		try
		{
			// var_dump($request->getBody());
			$sReqBody=(string) $request->getBody();
			// var_dump($sReqBody);

			/**
			 * Because of the way soap-ext (and thus ZS) in implemented,
			 * it is WHOLY possible for a client request to "fatal" this thread
			 * Mitigation (active thread recovery) will be inbound...
			 * @todo reimplement soap-ext in native php, or take over the ext...
			 */
			$sServiceResponse=$oSoapServer->handle($sReqBody);
			printf(">>>CHECKPOINT %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);

			//print_r($sServiceResponse);
			if ($sServiceResponse instanceof SoapFault)
			{
				printf(">>>CHECKPOINT{soap faulted) %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);
				var_dump('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>',(string)$sServiceResponse);die;
				$conn->send($this->setupHttpResponse($sServiceResponse->getMessage(), 500));
				$conn->close();
				return;
			}
			$conn->send($this->setupHttpResponse(($sServiceResponse)));
			$conn->close();
			// print "\nhandled without error...\n";
		}
		catch (\Throwable $th)
		{
			printf(">>>CHECKPOINT(soap failure) %s::%s:%s<<<", __CLASS__, __FUNCTION__, __LINE__);

			print_r((string) $th);
			print_r($th);
		}
		// print "request complete\n";
		return;
	}

	public function setupHttpResponse(string $body, int $code=200, array $sNewHeads=[]): string
	{
		$aCommonHeads=[
			'Content-Length' => strlen($body),
			'Connection'	 => 'close',
			'Date' => (new DateTime())->format(DateTime::RFC1123)
		];
		$aRealHead=array_merge($this->aDefaultHeaders, $aCommonHeads, $sNewHeads);
		return gPsr\str(new Response($code, $aRealHead, $body));
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
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
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
		$l=sprintf(">>>%s}CHECKPOINT %s::%s:%s<<<", time(), __CLASS__, __FUNCTION__, __LINE__);
		file_put_contents(APP_BASE_DIR.'\ev.log', $l, FILE_APPEND|LOCK_EX);
		$oEvent=new Event($sChannel, $sEventName, $aEventData);
		$this->oListener->getThreadContext()->addEvent($oEvent);
		return 'OK';
	}
}
