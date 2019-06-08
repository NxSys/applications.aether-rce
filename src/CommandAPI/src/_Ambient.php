<?php
/**
 * $BaseName$
 * $Header$
 *
 * DESCRIPTION
 *  A Core file for Aether.sh
 * 
 * This file is for functions and constants ONLY!!!1
 *
 * @link http://nxsys.org/spaces/aether
 * @link https://onx.zulipchat.com
 *
 * @package Aether
 * @subpackage System
 * @license http://nxsys.org/spaces/aether/wiki/license
 * Please see the license.txt file or the url above for full copyright and license information.
 * @copyright Copyright 2019 Nexus Systems, inc.
 *
 * @author Chris R. Feamster <cfeamster@f2developments.com>
 * @author $LastChangedBy$
 *
 * @version $Revision$
 */




namespace NxSys\Toolkits\Aether\API\RCE
{
	function aString()
	{
		echo "string";
	}

	function emit($sEventName, $sChannelName, $aData)
	{
		var_dump(func_get_args());
	}
}
