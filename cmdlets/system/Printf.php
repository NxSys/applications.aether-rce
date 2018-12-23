<?php
/**
 * 
 */

 namespace NxSys\Applications\Aether\RCECommands\System;

 use NxSys\Applications\Aether\RCE\Command;

 /**
  * I am a line of text that tell the DEV what this class does
  *		
  * @AESH\Help I am a line of help
  *     I am a second line of help, but not very well formatted
  * @author Name <email@email.com>
  * @AESH\Cmd print
  * @AESH\Cmd echo
  * @AESH\Cmd printf
  * 
  */
 class Printf extends Command
 {
     public function foo(string $stringToPrintf)
     {

     }
 }