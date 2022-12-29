<?php

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if ($arParams['RS_LAZY_IMAGES_USE'] == 'FROM_MODULE')
{
	$arParams['RS_LAZY_IMAGES_USE'] = \Bitrix\Main\Config\Option::get('redsign.megamart', 'global_lazyload_images');
}
$arParams['RS_LAZY_IMAGES_USE'] = isset($arParams['RS_LAZY_IMAGES_USE']) && $arParams['RS_LAZY_IMAGES_USE'] === 'N' ? 'N' : 'Y';

if ($arResult['ELEMENT']['DETAIL_PICTURE'] || $arResult['ELEMENT']['PREVIEW_PICTURE'])
{
	$arFileTmp = CFile::ResizeImageGet(
		$arResult['ELEMENT']['DETAIL_PICTURE'] ? $arResult['ELEMENT']['DETAIL_PICTURE'] : $arResult['ELEMENT']['PREVIEW_PICTURE'],
		array('width' => '150', 'height' => '180'),
		BX_RESIZE_IMAGE_PROPORTIONAL,
		true
	);
	$arResult['ELEMENT']['DETAIL_PICTURE'] = $arFileTmp;
}

$arDefaultSetIDs = array($arResult['ELEMENT']['ID']);
foreach (array('DEFAULT', 'OTHER') as $type)
{
	foreach ($arResult['SET_ITEMS'][$type] as $key=>$arItem)
	{
		$arElement = array(
			'ID'=>$arItem['ID'],
			'NAME' =>$arItem['NAME'],
			'DETAIL_PAGE_URL'=>$arItem['DETAIL_PAGE_URL'],
			'DETAIL_PICTURE'=>$arItem['DETAIL_PICTURE'],
			'PREVIEW_PICTURE'=> $arItem['PREVIEW_PICTURE'],
			'PRICE_CURRENCY' => $arItem['PRICE_CURRENCY'],
			'PRICE_DISCOUNT_VALUE' => $arItem['PRICE_DISCOUNT_VALUE'],
			'PRICE_PRINT_DISCOUNT_VALUE' => $arItem['PRICE_PRINT_DISCOUNT_VALUE'],
			'PRICE_VALUE' => $arItem['PRICE_VALUE'],
			'PRICE_PRINT_VALUE' => $arItem['PRICE_PRINT_VALUE'],
			'PRICE_DISCOUNT_DIFFERENCE_VALUE' => $arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE'],
			'PRICE_DISCOUNT_DIFFERENCE' => $arItem['PRICE_DISCOUNT_DIFFERENCE'],
			'CAN_BUY' => $arItem['CAN_BUY'],
			'SET_QUANTITY' => $arItem['SET_QUANTITY'],
			'MEASURE_RATIO' => $arItem['MEASURE_RATIO'],
			'BASKET_QUANTITY' => $arItem['BASKET_QUANTITY'],
			'MEASURE' => $arItem['MEASURE']
		);
		if ($arItem['PRICE_CONVERT_DISCOUNT_VALUE'])
			$arElement['PRICE_CONVERT_DISCOUNT_VALUE'] = $arItem['PRICE_CONVERT_DISCOUNT_VALUE'];
		if ($arItem['PRICE_CONVERT_VALUE'])
			$arElement['PRICE_CONVERT_VALUE'] = $arItem['PRICE_CONVERT_VALUE'];
		if ($arItem['PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE'])
			$arElement['PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE'] = $arItem['PRICE_CONVERT_DISCOUNT_DIFFERENCE_VALUE'];

		if ($type == 'DEFAULT')
			$arDefaultSetIDs[] = $arItem['ID'];
		if ($arItem['DETAIL_PICTURE'] || $arItem['PREVIEW_PICTURE'])
		{
			$arFileTmp = CFile::ResizeImageGet(
				$arItem['DETAIL_PICTURE'] ? $arItem['DETAIL_PICTURE'] : $arItem['PREVIEW_PICTURE'],
				array('width' => '150', 'height' => '180'),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);
			$arElement['DETAIL_PICTURE'] = $arFileTmp;
		}

		$arResult['SET_ITEMS'][$type][$key] = $arElement;
	}
}

$arResult['DEFAULT_SET_IDS'] = $arDefaultSetIDs;
