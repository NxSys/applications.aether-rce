<?php
namespace t;
require_once 'C:\dev\projects\onx\aether\applications.aether-rce\vendor\autoload.php';
use Thread;
use Exception;

use NxSys\Core\ExtensibleSystemClasses as SysLib;
use SysLib\date as SysDate;


class myt extends Thread 
{
    public function run()
    {
        $i=0;
        do {
            sleep(1);
            $i++;
            echo "~$i~\n";
        } while ($i <= 5);
        throw new Exception("Uhohhhh");
        
    }
}

try
{
    ($t=(new myt))->start();
} 
catch (\Throwable $th)
{
    echo "what am i doing back here...?";
    var_dump($th->getMessage());
}

echo "i've started my thread\n";
sleep(2);
echo "and have gone on my merry way.\n";

sleep(1);
echo "maybe i'll wait and join now....\n";


try {
    $t->join();
    var_dump($t->isTerminated());

} catch (\Throwable $th) {
    echo "hummm this is sad, but sane.";
    var_dump($th->getMessage());
}

die();exit();return;
__halt_compiler();




use NxSys\Core\ExtensibleSystemClasses as SysLib;
use NxSys\Core\ExtensibleSystemClasses\date as SysDate;

use DateTime;

class myDt extends SysDate\DateTime
{
    public function setTime($hour, $minute, $second = null, $microsecond = null)
    {
        var_dump("Setting time");
        return parent::setTime($hour, $minute, $second, $microsecond);
    }
}

class myThread extends Thread
{
    public function run()
    {
        $oMyDt=new myDt;
        $oMyDt->setTime(1,2);
        $this->test($oMyDt);     
    }

    public function test(\DateTime $foo)
    {
        var_dump($foo);
    }
}

(new myThread())->start();


die();exit();return;
__halt_compiler();

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
AetherAPI\IO::WriteLn('string');

$this->getAPI();






class systime extends Command
{
    public function thisIsMyMethod()
    {
        print time();
        $this->AetherAPI;
        $this->SystemAPI->executeCommand("command string");
        $this->IOAPI;
        $this->API->Security->Kerberos->Tickets->getNewSelfTicket();
        $this->API->System->executeCommand();
        $this->API->IO->readInput();
        AetherAPI\IO\Output;
        AetherAPI\IO\Input;
        AetherAPI\Security\Authn\UserStores\SQL\SQLite;
        $this->API->Security->setUserStore(new AetherAPI\Security\Authn\UserStores\SQL\SQLite());

        $oInput=new AetherAPI\IO\Input;


        //// AetherAPI("IO")

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