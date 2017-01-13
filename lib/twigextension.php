<?php
namespace Wlbl\Tools;

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
		return [
			new \Twig_SimpleFunction('getSvg', ['\\Wlbl\\Tools\\Assets\\Svg', 'get'], ['code', 'class', 'dir']),
		];
	}
}