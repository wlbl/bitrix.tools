<?php
namespace Wlbl\Tools\HighloadBlock;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

class HighloadBlock
{
	/**
	 * Получение класса для работы с HighloadBlock'ом
	 * По умолчанию выборка идет по ID инфоблока, но если вторым параметром передать любой другой ключ
	 * (NAME, TABLE_NAME) то выборка будет идти именно по этому полю.
	 * @param $value
	 * @param string $key
	 * @return \Bitrix\Main\Entity\DataManager|bool
	 */
	public static function getClass($value, $key = 'ID')
	{
		if (Loader::includeModule('highloadblock')) {
			if (empty($key)) {
				$key = 'ID';

				return HighloadBlockTable::compileEntity(HighloadBlockTable::getRow([
					'filter' => [$key => $value]
				]))->getDataClass();
			}
		}

		return false;
	}
}
