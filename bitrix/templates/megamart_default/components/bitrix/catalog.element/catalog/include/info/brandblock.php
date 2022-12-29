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

$APPLICATION->IncludeComponent(
	'bitrix:catalog.brandblock',
	'catalog',
	array(
		'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'ELEMENT_ID' => $arResult['ID'],
		'ELEMENT_CODE' => '',
		'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
		'WIDTH' => 65,
		'HEIGHT' => 65,
		'WIDTH_SMALL' => 65,
		'HEIGHT_SMALL' => 65,
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);
