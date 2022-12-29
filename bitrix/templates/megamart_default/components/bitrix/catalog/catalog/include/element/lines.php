<?php

use Bitrix\Main\Web\Json;
use Redsign\DevFunc\Iblock\CustomProperty\CustomFilter;


if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

global $catalogElement;

if (isset($catalogElement['LINES_PROPERTIES']) && is_array($catalogElement))
{
	foreach ($catalogElement['LINES_PROPERTIES'] as $code => $property)
	{
		if ($property['PROPERTY_TYPE'] === 'E' || $property['USER_TYPE'] === CustomFilter::USER_TYPE)
		{
			$componentSectionParams = [
				'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
				'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
				'ELEMENT_SORT_FIELD' => 'shows',
				'ELEMENT_SORT_ORDER' => 'desc',
				'ELEMENT_SORT_FIELD2' => 'sort',
				'ELEMENT_SORT_ORDER2' => 'asc',
				'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
				'PROPERTY_CODE_MOBILE' => $arParams['LIST_PROPERTY_CODE_MOBILE'],
				'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
				'BASKET_URL' => $arParams['BASKET_URL'],
				'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
				'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
				'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
				'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'CACHE_TYPE' => $arParams['CACHE_TYPE'],
				'CACHE_TIME' => $arParams['CACHE_TIME'],
				'CACHE_FILTER' => $arParams['CACHE_FILTER'],
				'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
				'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
				'PRICE_CODE' => $arParams['PRICE_CODE'],
				'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
				'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
				'PAGE_ELEMENT_COUNT' => 5,
				'FILTER_IDS' => array($elementId),

				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_LAST_MODIFIED" => "N",
				"ADD_SECTIONS_CHAIN" => "N",

				'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
				'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
				'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
				'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
				'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],

				'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
				'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
				'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
				'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
				'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
				'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
				'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
				'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],

				'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
				'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
				'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],

				'LABEL_PROP' => $arParams['LABEL_PROP'],
				'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
				'LABEL_PROP_POSITION' => $arParams['LIST_LABEL_PROP_POSITION'],
				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
				'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
				'PRODUCT_ROW_VARIANTS' => "[{'VARIANT':'11','BIG_DATA':false}]",
				'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
				'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
				'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
				'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
				'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

				'DISPLAY_TOP_PAGER' => 'N',
				'DISPLAY_BOTTOM_PAGER' => 'N',
				'HIDE_SECTION_DESCRIPTION' => 'Y',

				'RCM_TYPE' => isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '',
				'RCM_PROD_ID' => $elementId,
				'SHOW_FROM_SECTION' => 'Y',

				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
				'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
				'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
				'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
				'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
				'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
				'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
				'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
				'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
				'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
				'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
				'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
				'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

				'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
				'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
				'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

				'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
				'ADD_TO_BASKET_ACTION' => (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : array()),
				'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
				'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
				'COMPARE_NAME' => $arParams['COMPARE_NAME'],
				'BACKGROUND_IMAGE' => '',
				'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

				'SITE_LOCATION_ID' => SITE_LOCATION_ID,
				"FILL_ITEM_ALL_PRICES" => (is_array($arParams['PRICE_CODE']) && count($arParams['PRICE_CODE']) > 1) ? 'Y' :  $arParams['FILL_ITEM_ALL_PRICES'],

				// "AJAX_ID" => $arParams['AJAX_ID'],
				"DISPLAY_PREVIEW_TEXT" => $arParams["LIST_DISPLAY_PREVIEW_TEXT"],
				"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
				'COMPOSITE_FRAME' => 'Y',

				'IS_USE_CART' => $arParams['IS_USE_CART'],
				'PRICE_PROP' => $arParams['PRICE_PROP'],
				'DISCOUNT_PROP' => $arParams['DISCOUNT_PROP'],
				'CURRENCY_PROP' => $arParams['CURRENCY_PROP'],
				'PRICE_DECIMALS' => $arParams['PRICE_DECIMALS'],
				'SHOW_PARENT_DESCR' => 'Y',

				'TEMPLATE_VIEW' => $arParams['TEMPLATE_VIEW'],
				'GRID_RESPONSIVE_SETTINGS' => $arParams['~GRID_RESPONSIVE_SETTINGS'],
				'USE_VOTE_RATING' => $arParams['LIST_USE_VOTE_RATING'],
				'VOTE_DISPLAY_AS_RATING' => $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'],
				'SHOW_RATING' => $arParams['SHOW_RATING'],

				'USE_GIFTS' => $arParams['USE_GIFTS'],
				'USE_FAVORITE' => $arParams['USE_FAVORITE'],
				'FAVORITE_COUNT_PROP' => $arParams['FAVORITE_COUNT_PROP'],
				'SHOW_ARTNUMBER' => $arParams['SHOW_ARTNUMBER'],
				'ARTNUMBER_PROP' => $arParams['ARTNUMBER_PROP'],
				'OFFER_ARTNUMBER_PROP' => $arParams['OFFER_ARTNUMBER_PROP'],
				'OFFER_TREE_DROPDOWN_PROPS' => $arParams['OFFER_TREE_DROPDOWN_PROPS'],
				'RS_LAZY_IMAGES_USE' => $arParams['RS_LAZY_IMAGES_USE'],
				'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
				'PRODUCT_PREVIEW' => $arParams['PRODUCT_PREVIEW'],
				'SLIDER_SLIDE_COUNT' => $arParams['LIST_SLIDER_SLIDE_COUNT'],

				'RS_LIST_SECTION' => 'l_section',
				'RS_LIST_SECTION_SHOW_TITLE' => 'Y',
				'RS_LIST_SECTION_TITLE' => $property['NAME'],
			];
			if ($property['PROPERTY_TYPE'] === 'E')
			{
				global $linkElementsFilter;
				$linkElementsFilter = ['=ID' => $property['VALUE']];

				$APPLICATION->IncludeComponent(
					'bitrix:catalog.section',
					'catalog',
					$componentSectionParams + [
						"IBLOCK_ID" => $property["LINK_IBLOCK_ID"],
						"FILTER_NAME" => 'linkElementsFilter',
					]
				);

				unset($linkElementsFilter);
			}
			elseif ($property['USER_TYPE'] === CustomFilter::USER_TYPE)
			{
				if (is_array($property['VALUE']) && $property['VALUE'])
				{
					$APPLICATION->IncludeComponent(
						'bitrix:catalog.section',
						'catalog',
						$componentSectionParams + [
						'IBLOCK_ID' => $arParams['IBLOCK_ID'],
						'FILTER_NAME' => $arParams['FILTER_NAME'],
						'CUSTOM_FILTER' => Json::encode($property['VALUE'])
						]
					);

				}
			}
		}
	}
}