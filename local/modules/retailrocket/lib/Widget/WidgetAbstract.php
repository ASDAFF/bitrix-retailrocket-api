<?php
namespace RetailRocket\Widget;

use RetailRocket\Config;
use RetailRocket\Product\Item;
use RetailRocket\Product\ItemList;
use RetailRocket\User\User;

abstract class WidgetAbstract implements WidgetInterface
{
	private $requestUrl;
	private $urlParam;

	/**
	 * Тип текущего виджета
	 * @return string
	 */
	public function getType()
	{
		return $this::TYPE;
	}

	/**
	 * Анонимизированный идентификатор пользователя
	 * @return string
	 */
	public function getUser()
	{
		$user = new \CUser;
		return User::getRrUserId() ? User::getRrUserId() : $user->GetID();
	}

	/**
	 * Ссылка на API
	 * @return string
	 */
	public function getRequestUrl()
	{
		return $this->requestUrl;
	}

	/**
	 * Базовый путь
	 * @return string
	 */
	public function getBaseRequestUrl()
	{
		return Config::API_REQUEST_URL . $this->getType() . '/' . Config::getPartnerId() . '/';
	}

	/**
	 * Запрос к серверу
	 * @return ItemList|bool
	 */
	public function request()
	{
		$this->requestUrl .= ((strpos($this->requestUrl, '?') === false) ? '?' : '&') . 'format=' . Config::API_FORMAT;

		$curl = curl_init($this->requestUrl);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 250);
		$response = curl_exec($curl);
		curl_close($curl);

		if (!$arId = json_decode($response, true)) return false;

		$products = new ItemList;
		foreach ($arId as $id) {
			$item = new Item;
			$item->setId($id);
			$products->add($item);
		}

		return $products;
	}

	/**
	 * @param string $urlParam
	 */
	public function __construct($urlParam = null)
	{
		$this->requestUrl = $this->getBaseRequestUrl();
		if ($urlParam) {
			$this->urlParam = $urlParam;
			$this->requestUrl .= (string)$urlParam;
		}
	}
}