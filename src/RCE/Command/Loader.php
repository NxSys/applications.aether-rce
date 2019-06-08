<?php

namespace NxSys\Applications\Aether\RCE\Command;

final class Loader
{
	public static function getCommand(string $sCommandName): Command
	{
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandException("Can not reload command.");
		}
		$oLdr=new self;
		//access command registry

		//resolve name of command to FQCN
		#$sCommandClass=resolve($sCommandName);
		
		//load...? well, we do have CPM\COMPOSER

		#$oCmdObject=new $sCommandClass;
		// ....


		//profit!1
		#return $oCmdObject;
	}

	private function __construct()
	{
		# code...
	}
}