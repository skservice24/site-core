<?php

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if ($showSubscribe)
{
	$APPLICATION->IncludeComponent(
		'bitrix:catalog.product.subscribe',
		'',
		array(
			'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
			'PRODUCT_ID' => $arResult['ID'],
			'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
			'BUTTON_CLASS' => 'btn btn-outline-primary product-detail-buy-button mb-3',
			'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
			'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
			'USE_CAPTCHA' => 'Y',
		),
		$component,
		array('HIDE_ICONS' => 'Y')
	);
}