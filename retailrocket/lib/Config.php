<?php

namespace RetailRocket;

use Bitrix\Main\Config\Option;

final class Config
{
	const MODULE_ID = 'retailrocket';
	const API_REQUEST_URL = 'http://api.retailrocket.ru/api/1.0/Recomendation/';
	const API_FORMAT = 'json';

	const WIDGET_HOME = 'ItemsToMain';
	const WIDGET_PERSONAL = 'PersonalRecommendation';
	const WIDGET_CATEGORY = 'CategoryToItems';
	const WIDGET_PRODUCT = 'ItemToItems';
	const WIDGET_PRODUCT_NOT_AVAILABLE = 'UpSellItemToItems';
	const WIDGET_BASKET = 'CrossSellItemToItems';
	const WIDGET_SEARCH = 'SearchToItems';

	/**
	 * Список всех типов виджетов
	 * @return array
	 */
	public static function getListWidgetType()
	{
		return [
			self::WIDGET_HOME => GetMessage('RR_WIDGET_HOME'),
			self::WIDGET_PERSONAL => GetMessage('RR_WIDGET_PERSONAL'),
			self::WIDGET_CATEGORY => GetMessage('RR_WIDGET_CATEGORY'),
			self::WIDGET_PRODUCT => GetMessage('RR_WIDGET_PRODUCT'),
			self::WIDGET_PRODUCT_NOT_AVAILABLE => GetMessage('RR_WIDGET_PRODUCT_NOT_AVAILABLE'),
			self::WIDGET_BASKET => GetMessage('RR_WIDGET_BASKET'),
			self::WIDGET_SEARCH => GetMessage('RR_WIDGET_SEARCH'),
		];
	}

	/**
	 * @return string
	 */
	public static function getPartnerId()
	{
		return Option::get(self::MODULE_ID, 'partner_id', '');
	}

	/**
	 * @param string $partner_id
	 */
	public static function setPartnerId($partner_id)
	{
		Option::set(self::MODULE_ID, 'partner_id', $partner_id);
	}
} 