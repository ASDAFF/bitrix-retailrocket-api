<?php
namespace RetailRocket\Widget;

use RetailRocket\Config;
use RetailRocket\User\User;

class PersonalWidget extends WidgetAbstract
{
	const TYPE = Config::WIDGET_PERSONAL;
	const CACHE = false;

	/**
	 * Базовый путь
	 * @return string
	 */
	public function getBaseRequestUrl()
	{
		return parent::getBaseRequestUrl() . '?rrUserId=' . User::getRrUserId();
	}
}