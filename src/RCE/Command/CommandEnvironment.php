<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core,
	NxSys\Toolkits\Aether\SDK\Core\Execution;
	
use NxSys\Applications\Aether\RCE\Command\Loader;

use Pimple;
use ErrorException;
use Throwable;
use Thread;

class CommandEnvironment extends Core\Execution\Job\BaseJob
{
	private $sTargetCommandName;
	private $oExecutionRequest;

	private $oCommandServiceContainer;

	public $oFinalException;
	public $sCmdsLocation;

	public function __construct(string $sCommandName,
								ExecutionRequest $oExecutionRequest)
	{
		/**
		 * name
		 * typedparmobject
		 * context\env\state tag\handles
		 * 	things that belong to this instance
		 */
		$this->sTargetCommandName=$sCommandName;
		$this->oCommandServiceContainer=new Pimple\Container;
	}

	public function preinitializeEnvironment(...$aVars)
	{ //pre ::start

		// copy over into this space anything we need
		$this->setupConstants(Core\Boot\Container::getConfigParam('base.constants'));

		//init service container
		$this->oCommandServiceContainer['cmd.basedir']=
			APP_BASE_DIR.DIRECTORY_SEPARATOR.Core\Boot\Container::getConfigParam('rce.cmd.basedir');
		//var_dump(APP_BASE_DIR,Core\Boot\Container::getConfigParam('rce.cmd.basedir'));
		$this->sCmdsLocation=APP_BASE_DIR.DIRECTORY_SEPARATOR.Core\Boot\Container::getConfigParam('rce.cmd.basedir');
		$this->oCommandServiceContainer['api.version']=APP_VERSION;
	}

	public function run()
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		printf('>>THREAD %s^%s', Thread::getCurrentThread()->getCreatorId(), Thread::getCurrentThreadId());
		
		//freeze CE
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandException("Can not rerun used environments.");
		}
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);

		//var_dump($this->oCommandServiceContainer);

		$this->initConstants();
		require_once __DIR__.DIRECTORY_SEPARATOR.'Loader.php';
		// spl_autoload_register([new Loader, '']);
		require_once $this->sCmdsLocation
			.DIRECTORY_SEPARATOR
			.'libs'
			.DIRECTORY_SEPARATOR
			.'autoload.php';

		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		//setup error handling
		set_error_handler([$this, 'handleCommandError']);
		//set_exception_handler([$this, 'handleException']);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		//load cmd
		$oCmd=Loader::getCommand($this->sTargetCommandName);
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);

		//run cmd
		try
		{
			$oCmd->execute();
		}
		catch(CommandErrorException $oCmdX)
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

	public function handleCommandError($severity, $message, $file, $line): bool
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
	    if (!(error_reporting() & $severity))
	    {
    	    // This error code is not included in error_reporting
        	// but lets call it a quiet notice
        	//@todo emit notice
        	return true;
    	}
		throw new CommandErrorException($message, $severity, $file, $line);
		return true;
	}

	public function handleException($e)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		echo $this->showException($e);
	}

}

interface ICommandException{}
class CommandErrorException extends ErrorException implements ICommandException {}