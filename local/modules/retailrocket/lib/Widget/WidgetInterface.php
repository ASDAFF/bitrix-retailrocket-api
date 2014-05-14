<?php
namespace RetailRocket\Widget;


interface WidgetInterface
{
	const TYPE = '';
	const CACHE = true;

	/**
	 * Тип текущего виджета
	 * @return string
	 */
	public function getType();

	/**
	 * @return string
	 */
	public function getRequestUrl();

	/**
	 * Базовый путь
	 * @return string
	 */
	public function getBaseRequestUrl();

	/**
	 * Анонимизированный идентификатор пользователя
	 * @return string
	 */
	public function getUser();

	/**
	 * Запрос к серверу
	 * @return \RetailRocket\Product\ItemList|bool
	 */
	public function request();
}