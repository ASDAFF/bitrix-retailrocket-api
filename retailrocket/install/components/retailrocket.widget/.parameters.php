<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	'GROUPS' => array(),
	'PARAMETERS' => array(
		'WIDGET_TYPE' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('RR_COMPONENT_WIDGET_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => \RetailRocket\Config::getListWidgetType(),
			'DEFAULT' => '',
		),
		'URL_PARAMETER' => array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('RR_COMPONENT_URL_PARAMETER'),
			'TYPE' => 'STRING',
		),
		'CACHE_TIME' => array('DEFAULT' => 86400),
	),
);
