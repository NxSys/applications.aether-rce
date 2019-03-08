<?php

namespace NxSys\Applications\Aether\RCE\Command;


use Threaded;
use DateTime;

/**
 * Struct
 *
 * @author
 * @api
 */
class ExecutionRequest extends Threaded
{
	// IDs (FKs)
	public $iExecuitionId;



	//Name
	/** @var string $sCommandName Local Cononical Command Name */
	public $sCommandName;

	/** @var string $sPackageId Id describing the package containg this command */
	public $sPackageId;


	//Unique Data
	/** @var string $sACNOwner ACN That owns this execution */
	public $sACNOwner;

	/** @var DataeTime $oCreationTime Moment at which this XR was created */
	public $oCreationTime;

	/** @var DateTime $oInstanceTime[] moment at which this XR spawned a command */
	public $oInstanceTime=[];

	/** @var DateTime $oExitTime Time the XR was no longer running */
	protected $oExitTime = null;

	/** @var int $iExecutionState int of current execution status */
	public $iExecutionState = self::EXECUTIONSTATE_UNDEFINED;
	const EXECUTIONSTATE_UNDEFINED    =	0;
	const EXECUTIONSTATE_SUBMITTED    =	1;
	const EXECUTIONSTATE_ACN_ACCEPTED =	2;
	const EXECUTIONSTATE_RCE_ACCEPTED =	3;
	const EXECUTIONSTATE_STARTED	  =	4;
	const EXECUTIONSTATE_INTERRUPTED  =	5;
	const EXECUTIONSTATE_TERMINATED   =	6;
	const EXECUTIONSTATE_FINISHED 	  =	7;




	//Child Datasets
	/* @var StdClass Parameters */
	public $oParameterSet;
	/** @var StdClass $oCurrentEnvironment Object representing the current state of the system */
	public $oCurrentEnvironment;
	/** @var Type $oCommandTelemetry Volitle telemeetry data object */
	public $oCommandTelemetry;

}