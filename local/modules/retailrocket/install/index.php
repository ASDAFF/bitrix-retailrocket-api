<?
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang) - strlen("/install/index.php")) . '/install.php';
IncludeModuleLangFile($strPath2Lang);


class retailrocket extends \CModule
{
	var $MODULE_ID = "retailrocket";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function retailrocket()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path . "/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_NAME = GetMessage("RR_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("RR_INSTALL_DESCRIPTION");
	}

	function InstallDB($arParams = array())
	{
		RegisterModule("retailrocket");
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		$this->UnInstallTasks();
		COption::RemoveOption("retailrocket");

		UnRegisterModule("retailrocket");

		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles(__DIR__ . "/components", $_SERVER['DOCUMENT_ROOT'] . "/local/components");
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles(__DIR__ . "/components", $_SERVER['DOCUMENT_ROOT'] . "/local/components");
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallDB();
		$this->InstallFiles();
		$APPLICATION->IncludeAdminFile("Установить retailrocket", __DIR__ . "/step.php");
	}

	function DoUninstall()
	{
		global $APPLICATION;
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$APPLICATION->IncludeAdminFile("Удалить retailrocket", __DIR__ . "/unstep.php");
	}
}