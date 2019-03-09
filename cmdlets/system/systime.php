<?php

namespace NxSys\Applications\Aether\Commands\System;

/** Framework Dependencies **/
use NxSys\Toolkits\Aether\SDK\Command;

/**
 * `systime`
 */
class systime extends Command\BaseCommand 
{
    /**
     * Displays the current system time
     *
     * super simple demo command
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function execute()
    {
        $oPut->write(sprintf("Current UNIX Time %d\n",
                            time());
        
        return;
    }    
}
