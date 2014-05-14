<?php
namespace RetailRocket\User;


final class User {
	/**
	 * Анонимизированный идентификатор пользователя.
	 * Содержится в cookie rrpusid
	 * @return string
	 */
	public static function getRrUserId()
	{
		return $_COOKIE['rrpusid'] ? $_COOKIE['rrpusid'] : null;
	}

	/**
	 * Предшедствующая страница
	 * @return string
	 */
	public static function getReferrer()
	{
		return $_SERVER['HTTP_REFERER'];
	}
} 