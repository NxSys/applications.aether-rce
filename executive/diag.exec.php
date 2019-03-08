<?php
namespace NxSys\Applications\Aether\RCE\Exec;

$sOldDir=chdir(dirname(__FILE__)); //jump out from elsewhere
require_once '../src/Common.php';

use NxSys\Applications\Aether,
	NxSys\Toolkits\Aether\SDK\Core;

use NxSys\Core\ExtensibleSystemClasses as CoreEsc;

use Zend\Soap\Client as ZfClient;

use DOMDocument,
	SoapClient;

$sRceLocator='http://127.0.0.1:8335';
$iExecutionId=random_int(10001, 99999);

$sCmd='ver';

$ops=
[
	'uri' 				=> 'http://stds.aether.sh/soap',
	'connection_timeout'=> 3,
	'compression'		=> SOAP_COMPRESSION_ACCEPT,
	'trace' 			=> 1,	//do not use with ZS

	// 'proxy_host'	=> '127.0.0.1',
	// 'proxy_port'	=> 8888,

	'location'	=> $sRceLocator
];



// $rce=new ZfClient(null, $ops);
$rce=new SoapClient(null, $ops);
try
{
	$ret=$rce->addEvent(
		'INVALID!INVALID!INVALID!INVALID!', //session key
		'rce.submissions',					// channel
		'newCommand',						// event
			// data
		['iExecutionId' => $iExecutionId,
		'command' => $sCmd]);
		printf("\n====Result====\n");
		print_r($ret);
}
finally
{
	printf("\n====Finally====\n");
	printf("\n-----------\n--Request--\n-----------\n");
	print_r(fx($rce->__getLastRequest()));
	printf("\n------------\n--Response--\n------------\n");
	print_r(fx($rce->__getLastResponse()));
}


//=============================================================================
// FUNCTIONS

function fx($Xml)
{
	$doc = new DomDocument('1.0');
	$doc->preserveWhiteSpace = false;
	$doc->formatOutput = true;
	@$doc->loadXML($Xml);
	return $doc->saveXML();
}