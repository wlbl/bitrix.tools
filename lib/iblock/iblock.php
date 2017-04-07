<?php
namespace Wlbl\Tools\Iblock;

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\IblockSiteTable;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Context;
use Bitrix\Main\Entity\ReferenceField;
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
			])->setSelect(['ID'])->setLimit(1);

			if (!empty($sid)) {
				$query->registerRuntimeField(
					'SITE',
					new ReferenceField(
						'SITE',
						IblockSiteTable::class,
						['=this.ID' => 'ref.IBLOCK_ID']
					)
				)->addFilter('SITE.SITE_ID', $sid);
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
