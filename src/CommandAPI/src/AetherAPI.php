<?php

use NxSys\Toolkits\Aether\API;

final class RCE
{
	public function __invoke()
	{
		echo "string";
	}
}