<?php

namespace NxSys\Applications\Aether\RCE\Command;


// use Threaded;
use DateTime;


const EXECUTIONSTATE_UNDEFINED    =	0;
const EXECUTIONSTATE_SUBMITTED    =	1;
const EXECUTIONSTATE_ACN_ACCEPTED =	2;
const EXECUTIONSTATE_RCE_ACCEPTED =	3;
const EXECUTIONSTATE_STARTED	  =	4;
const EXECUTIONSTATE_INTERRUPTED  =	5;
const EXECUTIONSTATE_TERMINATED   =	6;
const EXECUTIONSTATE_FINISHED 	  =	7;

const SCHEDULERPRIOITY_LOWEST	=  0;
const SCHEDULERPRIOITY_LOW		=  3;
const SCHEDULERPRIOITY_NORMAL	=  5;
const SCHEDULERPRIOITY_HIGH		=  7;
const SCHEDULERPRIOITY_HIGHEST	=  9;

/**
 * Struct
 *
 * @author
 * @api
 */
class ExecutionRequest
{
	// IDs (FKs)
	public $iExecutionId;
	public $iOwnerId;
	public $iParentExecutionId;


	//Name
	/** @var string $sCommandName Local Cononical Command Name */
	public $sCommandName;

	/** @var string $sPackageId Id describing the package containg this command */
	public $sPackageId;


	//Unique Data
	public $sCommandString;

	/** @var string $sACNOwner ACN That owns this execution */
	public $sACNOwner;

	/** @var DateTime $oCreationTime Moment at which this XR was created */
	public $oCreationTime;

	/** @var string[] $aAssignedRCESet list RCE ids this execution is assigned to */
	public $aAssignedRCESet=[];

	/** @var DateTime[] $oInstanceTime moment at which this XR spawned a command */
	public $oInstanceTime=[];

	/** @var DateTime $oExitTime Time the XR was no longer running */
	protected $oExitTime = null;

	const EXECUTIONSTATE_UNDEFINED    =	EXECUTIONSTATE_UNDEFINED;
	const EXECUTIONSTATE_SUBMITTED    =	EXECUTIONSTATE_SUBMITTED;
	const EXECUTIONSTATE_ACN_ACCEPTED =	EXECUTIONSTATE_ACN_ACCEPTED;
	const EXECUTIONSTATE_RCE_ACCEPTED =	EXECUTIONSTATE_RCE_ACCEPTED;
	const EXECUTIONSTATE_STARTED	  =	EXECUTIONSTATE_STARTED;
	const EXECUTIONSTATE_INTERRUPTED  =	EXECUTIONSTATE_INTERRUPTED;
	const EXECUTIONSTATE_TERMINATED   =	EXECUTIONSTATE_TERMINATED;
	const EXECUTIONSTATE_FINISHED 	  =	EXECUTIONSTATE_FINISHED;
	/** @var int $iExecutionState int of current execution status */
	public $iExecutionState = self::EXECUTIONSTATE_UNDEFINED;

	const SCHEDULERPRIOITY_LOWEST	= SCHEDULERPRIOITY_LOWEST;
	const SCHEDULERPRIOITY_LOW		= SCHEDULERPRIOITY_LOW;
	const SCHEDULERPRIOITY_NORMAL	= SCHEDULERPRIOITY_NORMAL;
	const SCHEDULERPRIOITY_HIGH		= SCHEDULERPRIOITY_HIGH;
	const SCHEDULERPRIOITY_HIGHEST	= SCHEDULERPRIOITY_HIGHEST;
	/** @var int $iSchedulerPriority current *intended* priority */
	public $iSchedulerPriority = self::SCHEDULERPRIOITY_NORMAL;

	//Child Datasets
	/* @var StdClass Parameters */
	public $oParameterSet;
	/** @var StdClass $oCurrentEnvironment Object representing the current state of the system */
	public $oCurrentEnvironment;
	/** @var Type $oCommandTelemetry Volitle telemeetry data object */
	public $oCommandTelemetry;

}