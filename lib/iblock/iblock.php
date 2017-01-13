<?php
namespace Wlbl\Tools\Iblock;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Context;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\Loader;

class Iblock
{
	private static $ids = [];

	/**
	 * Возвращается id инфоблока по его коду, дополнительно может проверять тип и привязку к сайту
	 * @param string $code - код инфоблока
	 * @param null|string $type - код типа инфоблока
	 * @param null|string $sid - id сайта
	 * @return int id инфоблока
	 * @throws ArgumentNullException
	 */
	public static function getId($code, $type = null, $sid = null)
	{

		if (empty($code)) {
			throw new ArgumentNullException('code');
		}

		if (!empty(self::$ids[$sid][$type][$code])) {
			return self::$ids[$sid][$type][$code];
		}

		if (Loader::includeModule('iblock')) {
			$query = IblockTable::query();

			$query->setFilter([
				'ACTIVE' => 'Y',
				'CODE' => $code,
			])->registerRuntimeField(
				'LID',
				new ExpressionField('LID', 'LID')
			)->setSelect(['ID']);

			if (!empty($sid)) {
				$query->addFilter('LID', $sid);
			} else {
				$query->addFilter('LID', Context::getCurrent()->getSite());
			}

			if (!empty($type)) {
				$query->addFilter('IBLOCK_TYPE_ID', $type);
			}

			$arRes = $query->exec()->fetch();

			$id = intval($arRes['ID']);

			if ($id > 0) {
				self::$ids[$sid][$type][$code] = $id;
				return $id;
			}
		};

		return -1;
	}
}
