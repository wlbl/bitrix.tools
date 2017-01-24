<?php
namespace Wlbl\Tools\UserType;

use Bitrix\Main\Web\Uri;

class YouTube
{
	public static function getUserTypeDescription()
	{
		return [
			'PROPERTY_TYPE' => 'S',
			'USER_TYPE' => 'wlbl_youtube',
			'DESCRIPTION' => 'Видео с youtube',
			'GetPropertyFieldHtml' => [__CLASS__, 'getPropertyFieldHtml'],
			'ConvertToDB' => [__CLASS__, 'convertToDB'],
			'ConvertFromDB' => [__CLASS__, 'convertFromDB'],
			'GetPublicViewHTML' => [__CLASS__, 'getPublicViewHTML'],
		];
	}

	/**
	 * Выводится строка для ввода урла к видео, если значение уже есть, то iframe с видео.
	 * @param $arProperty
	 * @param $arValue
	 * @param $strHTMLControlName
	 * @return string
	 */
	public static function getPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName)
	{
		$value = '';
		if (!empty($arValue['VALUE'])) {
			$value = 'https://www.youtube.com/watch?v=' . $arValue['VALUE'];
		}

		ob_start();
		?>
		<input name="<?=$strHTMLControlName["VALUE"];?>" id="<?=$strHTMLControlName["VALUE"];?>" value="<?=$value;?>" size="60" type="text">
		<?php if (!empty($value)) { ?>
			<iframe style="display: block; height: 100%;" src="https://www.youtube.com/embed/<?=$arValue['VALUE'];?>?rel=0" frameborder="0" allowfullscreen=""></iframe>
		<?php } ?>
		<?php

		$strResult = ob_get_clean();

		return $strResult;
	}

	/**
	 * В БД сохраняется только код видео
	 * @param $arProperty
	 * @param $value
	 * @return mixed
	 */
	public static function convertToDB($arProperty, $value)
	{
		if (!empty($value['VALUE'])) {
			$uri = new Uri($value['VALUE']);

			if (strpos($uri->getQuery(), 'v=') !== false) {
				$videoQuery = [];
				parse_str($uri->getQuery(), $videoQuery);
				if (empty($videoQuery['v'])) {
					$videoQuery['v'] = $videoQuery['amp;v'];
				}
				$code = $videoQuery['v'];
			} else {
				$videoUrl = explode('/', $uri->getPath());
				$code = array_pop($videoUrl);
			}

			$value['VALUE'] = $code;
		}

		return $value;
	}

	public static function convertFromDB($arProperty, $value)
	{
		return $value;
	}

	/**
	 * Отображаемым значением является ссылка на всторенное видео (например для iframe).
	 * @param $arProperty
	 * @param $value
	 * @param $strHTMLControlName
	 * @return string
	 */
	public static function getPublicViewHTML($arProperty, $value, $strHTMLControlName)
	{
		if (empty($value['VALUE'])) {
			return '';
		}

		return 'https://www.youtube.com/embed/' . $value['VALUE'];
	}
}
