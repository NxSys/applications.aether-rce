<?php
/**
 * 
 */

namespace NxSys\Applications\Aether\RCE;

use ReflectionClass,
	ReflectionMethod;

/**
 * undocumented class
 */
class Command implements ICommand
{
    public function _getMetadata()
    {
        $oRefClass = new ReflectionClass($this);
        $sDocComment = $oRefClass->getDocComment();
    }

    public function _getInputSignatures()
    {
        $oRefClass = new ReflectionClass($this);
        $oPublicMethods = $oRefClass->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($oPublicMethods as $oMethod)
        {
            //Not internal method.
            if ($oMethod->getShortName()[0] != '_')
            {
                $sDocComment = $oMethod->getDocComment();
                $aParameters = $oMethod->getParameters();
                $oReturnType = $oMethod->getReturnType();
                $bIsVariadic = $oMethod->isVariadic();
            }
        }
    }
}
