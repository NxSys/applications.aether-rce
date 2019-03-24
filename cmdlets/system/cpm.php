https://packagist.org/packages/kabachello/ComposerAPI
https://packagist.org/packages/mindplay/composer-locator
<?php

use \kabachello\ComposerAPI\ComposerAPI;

/**
 * undocumented class
 */
class cpm extends Command 
{
    const CONFIGFILENAME='cpm.json';


    /**
     * main command function
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function FunctionName(Type $var = null)
    {
        # code...
    }

    /**
     * installs new aether command package
     *
     * It does this using composer
     *
     * @param string $sFullPackageName name of command
     * @return string of outpout
     * @throws on error
     **/
    public function installPackage(string $sFullPackageName): string
    {
        $oComposer=new ComposerAPI(self::CONFIGFILENAME);

        //go!
        $oPut=$oComposer->update([$sFullPackageName]);

        return $oPut;
    }
}
