<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core,
	NxSys\Toolkits\Aether\SDK\Core\Execution;

use Pimple;

use Throwable;

class CommandEnvironment extends Core\Execution\Job\BaseJob
	implements Pimple\Container, Core\Boot\Event\EventHandlerInterface
{
	private string $sTargetCommandName;
	private $oExecutionRequest;

	private $oCommandServiceConainer;

	public $oFinalException;

	public function __construct(string $sCommandName,
								ExecutionRequest $oExecutionRequest)
	{
		$this->sTargetCommandName=$sCommandName;
		$this->oCommandServiceConainer=new Pimple\Container;
	}

	public function preinitializeEnvironment(...)
	{ //pre ::start

		// copy over into this space anything we need

		$this->setupConstants(Core\Boot\Container::getConfigParam('base.constants'));

		//init service container
		$this->oCommandServiceConainer['cmd.basedir']=
			APP_BASE_DIR.DIRECTORY_SEPARATOR.Core\Boot\Container::getConfigParam('rce.cmd.basedir');

		$this->oCommandServiceConainer['api.version']=APP_VERSION;

	}

	public function run()
	{
		//freeze CE
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandException("Can not rerun used environments.");
		}

		$this->initConstants();

		//setup error handling
		set_error_handler([$this, 'handleCommandError']);

		//load cmd
		$oCmd=CommandLoader::load($this->sTargetCommandName);


		//run cmd
		try
		{
			$oCmd->execute();
		}
		catch(iCommandException $oCmdx)
		{
			#code
		}
		catch(Throwable $xx)
		{
			#code
		}
		finally
		{
			//this would be wierd but... just in case *shrugs*

			//also check up on
			//error_get_last();
			// $this->oFinalException=new Excption;
			#code
		}

		return;
	}

	public function handleCommandError($severity, $message, $file, $line): void
	{
	    if (!(error_reporting() & $severity))
	    {
    	    // This error code is not included in error_reporting
        	// but lets call it a quiet notice
        	//@todo emit notice
        	return;
    	}
    	throw new CommandErrorException($message, $severity, $severity, $file, $line);
	}

}

interface iCommandException{}
class CommandErrorException extends ErrorException implements iCommandException {}