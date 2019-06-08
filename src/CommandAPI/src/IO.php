<?php


use NxSys\Toolkits\Aether\API;


/**
 * undocumented class
 */
class IO extends RCE
{
    public function __construct()
    {
        $this->setCallPrefix('rce.io');
    }

    public function getOutputStream()
    {
        
    }

    public function getInput()
    {
        # code...
    }

    public function write(string $sOutputString);
    {
        $this->call('write', [$sOutputString]);
    }

    public function writeLn(string $sOutputLine)
    {
        $this->write($sOutputLine.PHP_EOL);
    }
}
