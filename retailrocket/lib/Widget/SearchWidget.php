<?php
namespace RetailRocket\Widget;

use RetailRocket\Config;
use RetailRocket\User\User;

class SearchWidget extends WidgetAbstract
{
	const TYPE = Config::WIDGET_SEARCH;
	const CACHE = false;

	/**
	 * Базовый путь
	 * @return string
	 */
	public function getBaseRequestUrl()
	{
		return parent::getBaseRequestUrl() . '?keyword=';
	}
}