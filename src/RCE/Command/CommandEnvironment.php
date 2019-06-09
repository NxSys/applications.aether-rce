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
		error_reporting(E_ALL); //configure?
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		printf('>>THREAD %s^%s', Thread::getCurrentThread()->getCreatorId(), Thread::getCurrentThreadId());
		
		//freeze CE
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandErrorException("Can not rerun used environments.");
		}
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		
		$this->initConstants();
		//var_dump($this->oCommandServiceContainer);
		//setup error handling
		// set_error_handler([$this, 'handleCommandError']);
		//set_exception_handler([$this, 'handleException']);

		require_once __DIR__.DIRECTORY_SEPARATOR.'Loader.php';
		Loader::LoadExternalClassManager($this->sCmdsLocation);

		
		
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		
		//load cmd
		try
		{
			printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
			$oCmd=Loader::getCommand($this->sTargetCommandName);
		}
		catch (Loader_RuntimeException $LdrRtEx)
		{
			throw $th;
		}
		catch(Throwable $Ex)
		{
			#the requested command encountered an exception while loading
			var_dump($Ex);
			print $this->showException($Ex);
			printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		}
		
		
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);

		//run cmd
		try
		{
			$oCmd?:$oCmd->execute();
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
			#the requested command encountered an exception while executing

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
		// var_dump((error_reporting() & $severity));
	    if(!(error_reporting() & $severity))
	    {
    	    // This error code is not included in error_reporting
        	// but lets call it a quiet notice
        	//@todo emit notice
			printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
        	return true;
    	}
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		$ex=new ErrorException($message, $severity, $file, $line);
		print $this->showException($ex);
		return true;
	}

	public function handleException($e)
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
		echo $this->showException($e);
	}

}

function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler('exception_error_handler');


interface ICommandException{}
class CommandErrorException extends ErrorException implements ICommandException {}