<?php
/**
 * @global \CMain $APPLICATION
 */

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

if (!\Bitrix\Main\Loader::IncludeModule("iblock")) {
	$APPLICATION->ThrowException(GetMessage('RR_ERROR_IBLOCK_NOT_INSTALLED'));

	return false;
}

/** PSR-0 autoloader */
spl_autoload_register(
	function ($className) {
		$className = ltrim($className, '\\');
		if (!$className = preg_replace('/^RetailRocket\\\/', '', $className)) {
			return false;
		}

		$fileName = '';
		if ($lastNsPos = strrpos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);

			$className = substr($className, $lastNsPos + 1);
			$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		$fileName = __DIR__ . '/lib/' . $fileName;

		if (is_readable($fileName)) {
			require_once $fileName;

			return true;
		}

		return false;
	}
);