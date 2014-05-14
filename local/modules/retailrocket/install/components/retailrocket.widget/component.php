<?php
/**
 * @var array $arParams
 * @var \CBitrixComponent $this
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 */

use RetailRocket\Config;
use RetailRocket\Js\TrackingCode;
use RetailRocket\Widget\HomeWidget;
use RetailRocket\Widget\PersonalWidget;
use RetailRocket\Widget\ProductNotAvailableWidget;
use RetailRocket\Widget\ProductWidget;
use RetailRocket\Widget\SearchWidget;
use RetailRocket\Widget\BasketWidget;
use RetailRocket\Widget\CategoryWidget;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

if ($this->StartResultCache()) {

	if (!\Bitrix\Main\Loader::includeModule('retailrocket')) {
		ShowError(GetMessage('RR_ERROR_RR_NOT_INSTALLED'));
		return;
	}

	$arResult['SCRIPTS'] = '';

	switch ($arParams['WIDGET_TYPE']) {
		case Config::WIDGET_HOME:
			$widget = new HomeWidget();
			break;
		case Config::WIDGET_CATEGORY:
			$widget = new CategoryWidget($arParams['URL_PARAMETER']);
			$arResult['SCRIPTS'] .= TrackingCode::showCategoryCode($arParams['URL_PARAMETER']) . PHP_EOL;
			break;
		case Config::WIDGET_PERSONAL:
			$widget = new PersonalWidget();
			break;
		case Config::WIDGET_PRODUCT:
			$widget = new ProductWidget($arParams['URL_PARAMETER']);
			$arResult['SCRIPTS'] .= TrackingCode::showProductCode($arParams['URL_PARAMETER']) . PHP_EOL;
			break;
		case Config::WIDGET_PRODUCT_NOT_AVAILABLE:
			$widget = new ProductNotAvailableWidget($arParams['URL_PARAMETER']);
			$arResult['SCRIPTS'] .= TrackingCode::showProductCode($arParams['URL_PARAMETER']) . PHP_EOL;
			break;
		case Config::WIDGET_SEARCH:
			$widget = new SearchWidget($arParams['URL_PARAMETER']);
			break;
		case Config::WIDGET_BASKET:
			$widget = new BasketWidget($arParams['URL_PARAMETER']);
			break;
		default:
			ShowError(GetMessage('RR_ERROR_RR_UNKNOWN_WIDGET_TYPE'));
			return;
	}

	if (!$widget::CACHE) $this->AbortResultCache();

	if ($apiResponse = $widget->request()) {
		$arResult['SCRIPTS'] .= TrackingCode::showRecommendedTrackCode($widget, $apiResponse);

		foreach ($apiResponse->getList() as $item) {
			$item->loadItemInfo();
		}
	}
	$arResult['ITEMS'] = $apiResponse;
	$arResult['WIDGET'] = $widget;

	$this->SetResultCacheKeys(['WIDGET', 'ITEMS', 'SCRIPTS']);

	$this->IncludeComponentTemplate();
}
