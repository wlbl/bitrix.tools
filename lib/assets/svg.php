<?php
namespace Wlbl\Tools\Assets;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Configuration;
use Bitrix\Main\IO\File;

class Svg
{
	const DEFAULT_DIR = '/assets/icons/';

	public static function get($code, $class = '', $dir = '')
	{
		$svg = '';

		if (empty($code)) {
			return $svg;
		}

		if (empty($dir)) {
			$dir = self::getDefaultDir();
		}

		$file = new File(Application::getDocumentRoot() . $dir . $code . '.svg');

		if (!$file->isExists()) {
			return $svg;
		}

		$svg = $file->getContents();

		if (empty($class)) {
			$class = '';
		}

		$svg = str_replace('{{ className }}', $class, $svg);

		return $svg;
	}

	public static function getDefaultDir()
	{
		$dir = Configuration::getValue('wlbl.tools')['svgDefaultDir'];

		if (!empty($dir)) {
			return $dir;
		}

		return self::DEFAULT_DIR;
	}
}