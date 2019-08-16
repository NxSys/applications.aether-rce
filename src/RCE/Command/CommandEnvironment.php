<?php

namespace NxSys\Applications\Aether\RCE\Command;

use NxSys\Toolkits\Aether\SDK\Core,
	NxSys\Toolkits\Aether\SDK\Core\Execution;

use NxSys\Applications\Aether\RCE\Command\Loader;
use NxSys\Applications\Aether\RCE\Command\ExecutionRequest;

use NxSys\Toolkits\Parallax\Job\BaseJob;

use Pimple;
use ErrorException;
use Throwable;
use Thread;

class CommandEnvironment extends BaseJob
{
	private $sTargetCommandName;
	private $oExecutionRequest;

	private $oCommandServiceContainer;

	public $oFinalException;
	public $sCmdsLocation;

	public function __construct(string $sCommandName,
								$oExecutionRequest)
	{
		/**
		 * name
		 * typedparmobject
		 * context\env\state tag\handles
		 * 	things that belong to this instance
		 */
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
		$this->sTargetCommandName=$sCommandName;
		//$this->oCommandServiceContainer=new Pimple\Container;
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
	}

	public function preinitializeEnvironment(...$aVars)
	{ //pre ::start

		// copy over into this space anything we need
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);

		//init service container
		//$this->oCommandServiceContainer['cmd.basedir']=
			//APP_BASE_DIR.DIRECTORY_SEPARATOR.Core\Boot\Container::getConfigParam('rce.cmd.basedir');
		//var_dump(APP_BASE_DIR,Core\Boot\Container::getConfigParam('rce.cmd.basedir'));
		$this->sCmdsLocation=APP_BASE_DIR.DIRECTORY_SEPARATOR.Core\Boot\Container::getConfigParam('rce.cmd.basedir');
		//$this->oCommandServiceContainer['api.version']=APP_VERSION;
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __FUNCTION__, __LINE__);
	}

	public function run()
	{
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);

		//freeze CE
		static $freeze=0;
		if($freeze++)
		{
			throw new CommandErrorException("Can not rerun used environments.");
		}
		printf(">>>CHECKPOINT %s::%s:%s<<<\n", __CLASS__, __METHOD__, __LINE__);
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
			//$oCmd=Loader::getCommand($this->sTargetCommandName);
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
			//$oCmd?:$oCmd->execute();
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




interface ICommandException{}
class CommandErrorException extends ErrorException implements ICommandException {}