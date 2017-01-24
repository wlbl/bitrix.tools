<?php

Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

Class wlbl_tools extends CModule
{
	public $MODULE_ID = "wlbl.tools";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_CSS;
	public $MODULE_GROUP_RIGHTS = "Y";

	public function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path . "/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("WLBL_TOOLS_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("WLBL_TOOLS_MODULE_DESC");
		$this->PARTNER_NAME = GetMessage("WLBL_TOOLS_MODULE_PARTNER");
		$this->PARTNER_URI = GetMessage("WLBL_TOOLS_MODULE_URI");
	}

	public function InstallDB()
	{
		RegisterModule($this->MODULE_ID);

		return true;
	}

	public function UnInstallDB()
	{
		UnRegisterModule($this->MODULE_ID);

		return true;
	}

	public function InstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();

		$eventManager->registerEventHandler(
			'main',
			'OnPageStart',
			$this->MODULE_ID,
			'\Wlbl\Tools\EventHandlers',
			'onPageStart'
		);

		$eventManager->registerEventHandler(
			'wlbl.twigrix',
			'onAddExtensions',
			$this->MODULE_ID,
			'\Wlbl\Tools\EventHandlers',
			'twigCustomFunctions'
		);

		$eventManager->registerEventHandler(
			'iblock',
			'OnIBlockPropertyBuildList',
			$this->MODULE_ID,
			'\Wlbl\Tools\UserType\YouTube',
			'getUserTypeDescription'
		);

		return true;
	}

	public function UnInstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();

		$eventManager->unRegisterEventHandler(
			'main',
			'OnPageStart',
			$this->MODULE_ID,
			'\Wlbl\Tools\EventHandlers',
			'onPageStart'
		);

		$eventManager->unRegisterEventHandler(
			'wlbl.twigrix',
			'onAddExtensions',
			$this->MODULE_ID,
			'\Wlbl\Tools\EventHandlers',
			'twigCustomFunctions'
		);

		$eventManager->unRegisterEventHandler(
			'iblock',
			'OnIBlockPropertyBuildList',
			$this->MODULE_ID,
			'\Wlbl\Tools\UserType\YouTube',
			'getUserTypeDescription'
		);

		return true;
	}

	public function InstallFiles()
	{
		return true;
	}

	public function UnInstallFiles()
	{
		return true;
	}

	public function DoInstall()
	{
		if (!IsModuleInstalled($this->MODULE_ID)) {
			$this->InstallDB();
			$this->InstallEvents();
			$this->InstallFiles();
		}
	}

	public function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallEvents();
		$this->UnInstallFiles();
	}
}