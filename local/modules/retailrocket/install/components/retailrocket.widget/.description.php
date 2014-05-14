<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	'NAME' => GetMessage('RR_COMPONENT_WIDGET_NAME'),
	'DESCRIPTION' => GetMessage('RR_COMPONENT_WIDGET_DESCRIPTION'),
	'ICON' => '/images/icon.gif',
	'CACHE_PATH' => 'Y',
	'PATH' => array(
		'ID' => 'Retail Rocket'
	),
);