<?php

namespace NxSys\Applications\Aether\RCE\Command;

final class CommandLoader
{
	public static function getCommand(string $sCommandName): Command
	{
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandException("Can not reload command.");
		}
		$oLdr=new self;
	}

	private function __construct()
	{
		# code...
	}
}