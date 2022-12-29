<?php

use Bitrix\Main\ModuleManager;

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

if (ModuleManager::isModuleInstalled('sale'))
{
	$APPLICATION->IncludeComponent(
		"redsign:delivery.calculator",
		"catalog",
		array(
			"CURRENCY" => $arParams['DELIVERY_CURRENCY_ID'],
			"ELEMENT_ID" => $actualItem['ID'],
			"QUANTITY" => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : 1,
			"DELIVERY" => array(),
			"SHOW_DELIVERY_PAYMENT_INFO" => $arParams["DETAIL_DELIVERY_PAYMENT_INFO"],
			"DELIVERY_LINK" => $arParams['DETAIL_DELIVERY_LINK'],
			"PAYMENT_LINK" => $arParams['DETAIL_PAYMENT_LINK'],
		),
		$component,
		array('HIDE_ICONS' => 'Y')
	);
}