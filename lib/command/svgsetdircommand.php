<?php

namespace Wlbl\Tools\Command;

use Bitrix\Main\Config\Configuration;
use Notamedia\ConsoleJedi\Application\Command\BitrixCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SvgSetDirCommand extends BitrixCommand
{
	protected $module = 'wlbl.tools';

	protected function configure()
	{
		$this->setName($this->module . ':svg:set-dir')
			->setDescription('Set svg dir')
			->setHelp('Set svg dir for \Wlbl\Tools\Assets functionality')
			->addArgument('dir', InputArgument::REQUIRED, 'Dir from document root');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$dir = $input->getArgument('dir');
		if (mb_strpos($dir, '/') !== 0) {
			$dir = '/' . $dir;
		}
		if (mb_substr($dir, mb_strlen($dir) - 1) != '/') {
			$dir .= '/';
		}

		$value = Configuration::getValue($this->module);
		$value['svgDir'] = $dir;

		$config = Configuration::getInstance();
		$config->add(
			$this->module,
			$value
		);

		$config->saveConfiguration();

		$output->writeln('<info>Svg dir set to "' . $dir . '"</info>');
	}
}
