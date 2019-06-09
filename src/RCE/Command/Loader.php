<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK;

use Composer\Autoload;

final class Loader
{
	static $oComposerLoader;
	public static function loadExternalClassManager($sCmdsLocation): void
	{
		self::$oComposerLoader = require_once $sCmdsLocation
			.DIRECTORY_SEPARATOR
			.'libs'
			.DIRECTORY_SEPARATOR
			.'autoload.php';

	}
	public static function getCommand(string $sCommandName): SDK\Command
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandException("Can not reload command.");
		}
		$oLdr=new self;

		//access command registry
		#mmm..... @todo
		$oCmpLoader=self::$oComposerLoader;
		
		//resolve name of command to FQCN
		$sCommandClass=$oLdr->resolveClass($sCommandName);
		
		//load...? well, we do have CPM\COMPOSER
		$oCmpLoader->loadClass($sCommandClass);

		$oCmdObject=new $sCommandClass;
		// ....


		//profit!1
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		return $oCmdObject;
	}

	private function resolveClass($sCmdName): string
	{
		// @todo
		$a=[
			'hello' => 'feamsr10\testcmd\test',
			'ver' => 'NxSys\Applications\Aether\RCE\Command\JustATestClass',
		];
		return $a[$sCmdName];
	}

	private function __construct()
	{
		# code...
	}
}

class JustATestClass extends SDK\Command
{
	public function execution()
	{
		print '*********************************************************************************************************';
	}
}