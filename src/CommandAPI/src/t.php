<?php
require "_Ambient.php";
require "AetherAPI.php";

use NxSys\Toolkits\Aether\API\RCE as AetherAPI;

$x=new AetherAPI;
$x();
AetherAPI\x();

//CommandEnvironment::run()

// AetherAPI\_globalInit($sAuth\);


//
//------- EXECUTION
// Command()
AetherAPI\IO\Output::WriteLn('string');

$this->getAPI();






class systime extends Command
{
    public function thisIsMyMethod()
    {
        print time();
        $this->AetherAPI
        $this->SystemAPI->executeCommand("command string");
        $this->IOAPI
        $this->API->System->executeCommand();
        $this->API->IO->readInput();
        AetherAPI\IO\Output;
        AetherAPI\IO\Input;
        AetherAPI\Security\Authn\UserStores\SQL\SQLite;
        $this->API->Security->setUserStore(new AetherAPI\Security\Authn\UserStores\SQL\SQLite());

        $oInput=new AetherAPI\IO\Input;


        AetherAPI("IO")->;

    }

    public function _thisIsMyMethodToo()
    {
        print date();
    }

    public function secondMethod(DateTime $foo)
    {
        var_dump($foo);
    }
}
/*

} systime()
} systime(date)
} systime::_thisIsMyMethodToo()

RCE:MyNode\awss3:\\path
mylib} command1()


fs} cd()

RCE:MyNode\fs:\\path2
mylib} command2()
*/