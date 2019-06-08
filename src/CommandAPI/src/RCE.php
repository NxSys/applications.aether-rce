<?php

use NxSys\Toolkits\Aether\API;

abstract class RCE
{
	protected $sEventPrefix;

	public function __invoke()
	{
		echo "string";
	}

	protected function setCallPrefix(string $sPrefix)
	{
		$this->sEventPrefix=$sPrefix.'.';
	}

	protected function getCallPrefix(): string
	{
		return $this->sEventPrefix;
	}

	protected function emit(string $sEventName, array $aData=[], string $sChannel=null)
	{
		emit($this->$sEventPrefix.$sEventName, $sChannel, $aData);
	}

	protected function call(string $sEndPointName, array $aParams)
	{
		$this->emit('rpc.'.$sEndPointName, ['params' => $aData]);
	}
	

}