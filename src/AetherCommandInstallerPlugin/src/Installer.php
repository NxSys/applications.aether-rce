<?php

 /** @namespace Native Namespace */
namespace NxSys\Library\Bridges\AetherCommandInstallerPlugin;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class Installer extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return './user/'.$package->getPrettyName();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'nxsys-aeshcommand' === $packageType;
    }
}