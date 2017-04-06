<?php
namespace Wlbl\Tools;

use Symfony\Component\VarDumper\VarDumper;

class TwigExtension extends \Twig_Extension
{
	public function getName()
	{
		return 'wlbl_tools';
	}

	/**
	 * Возвращает список функций, которые будут доступны в шаблоне после добавления данного расширения
	 * @return array
	 */
	public function getFunctions()
	{
		$functions = [
			new \Twig_SimpleFunction('getSvg', ['\\Wlbl\\Tools\\Assets\\Svg', 'get']),
			new \Twig_SimpleFunction(
				'dump',
				[self::class, 'dump'],
				array(
					'needs_environment' => true
				)
			),
		];

		return $functions;
	}

	public static function dump(\Twig_Environment $env, $var)
	{
		if (!$env->isDebug()) {
			return null;
		}

		ob_start();

		VarDumper::dump($var);

		return ob_get_clean();
	}
}