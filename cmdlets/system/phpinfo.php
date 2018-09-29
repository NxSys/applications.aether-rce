<?php
/**
 * phpinfo.php
 * $Id: phpinfo.php 103 2018-01-13 01:13:33Z nxs.cfeamster $
 *
 * DESCRIPTION
 *  PHPInfo Cmdlet for WACC
 *
 * @link https://nxsys.org/spaces/wacc
 * @package WACC\System
 * @copyright Copyright 2013-2015 Nexus Systems, Inc.
 * @license https://nxsys.org/spaces/wacc/wiki/License
 * Please see the license.txt file or the url above for full copyright and
 * license terms.
 *
 * @author Chris R. Feamster <cfeamster@f2developments.com>
 * @author $LastChangedBy: nxs.cfeamster $
 *
 * @version $Revision: 103 $
 */

namespace Wacc\System\Cmdlets;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

use \Wacc\System as WaccSystem;

$sWACC_VER=WaccSystem\WaccApp::APP_VERSION;
define('PHPINFO_HELP',<<<EOH
Phpinfo Utility V$sWACC_VER
Outputs information about PHP's configuration
See: <link>http://php.net/manual/en/function.phpinfo.php</link>
\t
EOH
	   );

/**
 * pingCmdlet
 *
 *
 */
class phpinfoCmdlet extends WaccSystem\Cmdlet
{
	public function configure()
	{
        $this
            ->setName('phpinfo')
            ->setDescription('PHPInfo Utility V'.WaccSystem\WaccApp::APP_VERSION)
            ->setHelp(PHPINFO_HELP)
			->setDefinition(array(
                new InputArgument('what', InputArgument::OPTIONAL, 'What info to show', 'INFO_ALL'),
				new InputOption('select','s',InputOption::VALUE_REQUIRED,
								'Select field (eg Core or "PHP Variables")'),
				new InputOption('break',null,InputOption::VALUE_NONE,'Break WACC\'s CSS')
            ));
	}

	public function execute(InputInterface $oIn, OutputInterface $oPut)
	{
		$iWhat=0;
		$sPhpInfoHtml='';
		$sSection='';
		$aPhpInfo=array();
		$aOutput=array();

		$sWhat=$oIn->getArgument('what');
		$sSection=$oIn->getOption('select');

		if(!defined($sWhat))
		{
			$oPut->writeln('<error>The constant you passed, is not defined.</error>');
			return -1;
		}

		if(php_sapi_name()=='cli')
		{
			phpinfo(constant($sWhat));
			return 0;
		}

		//yay web :-/
		ob_start();
		phpinfo(constant($sWhat));
		$sPhpInfoHtml=ob_get_clean();

		if($oIn->getOption('break')===true)
		{
			$oPut->writeln($sPhpInfoHtml);
			return;
		}

		$aPhpInfo=$this->textifyPhpinfo($sPhpInfoHtml);
		if(false!=$sSection)
		{
			if(!array_key_exists($sSection,$aPhpInfo))
			{
				$oPut->writeln("<error>That section does not exsist</error>\n");
				return -1;
			}
			$aOutput=$aPhpInfo[$sSection];
		}
		else
		{
			$aOutput=$aPhpInfo;
		}
		$oPut->writeln(print_r($aOutput,true));
		return 0;
	}



	private function textifyPhpinfo($sPhpinfoOutput)
	{
		//thanks to contribs on http://php.net/manual/en/function.phpinfo.php
		$info_arr = array();
		$info_lines = explode("\n", strip_tags($sPhpinfoOutput, "<tr><td><h2>"));
		$cat = "General";
		foreach($info_lines as $line)
		{
			// new cat?
			preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
			if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
			{
				$info_arr[$cat][trim($val[1])] = trim($val[2]);
			}
			elseif(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
			{
				$info_arr[$cat][trim($val[1])] = array("local" => $val[2], "master" => $val[3]);
			}
		}
		return $info_arr;
	}
}
