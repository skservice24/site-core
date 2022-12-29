<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;
use Redsign\MegaMart\ElementListUtils;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

Loc::loadMessages(__FILE__);
$bMegamartInclude = Loader::includeModule('redsign.megamart');

$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$isFilter = ($arParams['USE_FILTER'] == 'Y');

// $obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($this->randString()));
if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
	$basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}

if (
	$arParams['CATALOG_VIEW_MODE'] == 'VIEW_SECTIONS'
)
{
	$arParams['SIDEBAR_INNER_SECTIONS_SHOW'] = (isset($arParams['SIDEBAR_INNER_SECTIONS_SHOW']) && $arParams['SIDEBAR_INNER_SECTIONS_SHOW'] == 'Y' ? 'Y' : 'N');
	$arParams['SIDEBAR_OUTER_SECTIONS_SHOW'] = (isset($arParams['SIDEBAR_OUTER_SECTIONS_SHOW']) && $arParams['SIDEBAR_OUTER_SECTIONS_SHOW'] == 'Y' ? 'Y' : 'N');

	$bSidebarInner = false; // ($arParams["SIDEBAR_INNER_SECTIONS_SHOW"] == "Y");
	$bSidebarOuter = false; // ($arParams["SIDEBAR_OUTER_SECTIONS_SHOW"] == "Y");

	//region Catalog Section
	$sectionListParams = [
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"BANNER_TYPE" => $arParams['BANNER_TYPE'],
		"SECTIONS_VIEW_MODE" => $arParams['SECTIONS_VIEW_MODE'],
		"SHOW_PARENT_NAME" => 'N',//$arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"SECTION_USER_FIELDS" => $arParams["SECTION_USER_FIELDS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"GRID_RESPONSIVE_SETTINGS" => $arParams["~SECTIONS_GRID_RESPONSIVE_SETTINGS"],

		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
	];
	if ($sectionListParams["COUNT_ELEMENTS"] === "Y")
	{
		$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_ACTIVE";
		if ($arParams["HIDE_NOT_AVAILABLE"] == "Y")
		{
			$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_AVAILABLE";
		}
	}

	if (preg_match('/^UF_/', $arParams['LIST_META_KEYWORDS']))
	{
		$sectionListParams['SECTION_USER_FIELDS'][] = $arParams['LIST_META_KEYWORDS'];
	}
	if (preg_match('/^UF_/', $arParams['LIST_META_DESCRIPTION']))
	{
		$sectionListParams['SECTION_USER_FIELDS'][] = $arParams['LIST_META_DESCRIPTION'];
	}
	if (preg_match('/^UF_/', $arParams['LIST_BROWSER_TITLE']))
	{
		$sectionListParams['SECTION_USER_FIELDS'][] = $arParams['LIST_BROWSER_TITLE'];
	}

	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"catalog",
		$sectionListParams,
		$component
	);
	unset($sectionListParams);
	//endregion
}
else
{
	$arParams['SIDEBAR_INNER_SECTION_SHOW'] = (isset($arParams['SIDEBAR_INNER_SECTION_SHOW']) && $arParams['SIDEBAR_INNER_SECTION_SHOW'] == 'Y' ? 'Y' : 'N');
	$arParams['SIDEBAR_OUTER_SECTION_SHOW'] = (isset($arParams['SIDEBAR_OUTER_SECTION_SHOW']) && $arParams['SIDEBAR_OUTER_SECTION_SHOW'] == 'Y' ? 'Y' : 'N');

	$bSidebarInner = ($arParams["SIDEBAR_INNER_SECTION_SHOW"] == "Y");
	$bSidebarOuter = ($arParams["SIDEBAR_OUTER_SECTION_SHOW"] == "Y");

	if ($arParams['SHOW_SECTIONS_LIST'] == 'Y')
	{
		//region Catalog Section
		$sectionListParams = [
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
			// "TOP_DEPTH" => 1,
			"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => $arParams['SECTION_LIST_VIEW'],
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
			"ADD_SECTIONS_CHAIN" => "N",
			"GRID_RESPONSIVE_SETTINGS" => $arParams['~SECTION_LIST_VIEW_BLOCKS_GRID_RESPONSIVE_SETTINGS'],
			"VIEW_MODE_BUFFER" => (RS_MM_CATALOG_SECTION_TYPE != 'type3' ? 'lines' : ''),
		];
		if ($sectionListParams["COUNT_ELEMENTS"] === "Y")
		{
			$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_ACTIVE";
			if ($arParams["HIDE_NOT_AVAILABLE"] == "Y")
			{
				$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_AVAILABLE";
			}
		}
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"catalog2",
			$sectionListParams,
			$component
		);
		unset($sectionListParams);
		//endregion

		if (RS_MM_CATALOG_SECTION_TYPE != 'type3')
		{
			$APPLICATION->AddViewContent(
				'site_sidebar_outer',
				$APPLICATION->GetViewContent('site_catalog_section_list_buffer'),
				300
			);
		}

		// if (RS_MM_CATALOG_SECTION_TYPE == 'type3')
		// {
		// 	//region Catalog Section
		// 	$sectionListParams = [
		// 		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		// 		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		// 		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		// 		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		// 		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		// 		"CACHE_TIME" => $arParams["CACHE_TIME"],
		// 		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		// 		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		// 		"TOP_DEPTH" => 1,
		// 		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		// 		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		// 		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		// 		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		// 		"ADD_SECTIONS_CHAIN" => "N",
		// 	];
		// 	if ($sectionListParams["COUNT_ELEMENTS"] === "Y")
		// 	{
		// 		$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_ACTIVE";
		// 		if ($arParams["HIDE_NOT_AVAILABLE"] == "Y")
		// 		{
		// 			$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_AVAILABLE";
		// 		}
		// 	}
		// 	$APPLICATION->IncludeComponent(
		// 		"bitrix:catalog.section.list",
		// 		"links",
		// 		$sectionListParams,
		// 		$component
		// 	);
		// 	unset($sectionListParams);
		// 	// endregion
		// }
		// else
		// {
		// 	//region Catalog Section
		// 	$sectionListParams = [
		// 		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		// 		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		// 		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		// 		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		// 		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		// 		"CACHE_TIME" => $arParams["CACHE_TIME"],
		// 		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		// 		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		// 		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		// 		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		// 		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		// 		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		// 		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		// 		"ADD_SECTIONS_CHAIN" => "N",
		// 	];
		// 	if ($sectionListParams["COUNT_ELEMENTS"] === "Y")
		// 	{
		// 		$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_ACTIVE";
		// 		if ($arParams["HIDE_NOT_AVAILABLE"] == "Y")
		// 		{
		// 			$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_AVAILABLE";
		// 		}
		// 	}
		// 	ob_start();
		// 	$APPLICATION->IncludeComponent(
		// 		"bitrix:catalog.section.list",
		// 		"sidebar.menu",
		// 		$sectionListParams,
		// 		$component
		// 	);
		// 	$sHtmlContent = ob_get_clean();
		// 	$APPLICATION->AddViewContent('site_sidebar_outer', $sHtmlContent, 300);
		// 	unset($sHtmlContent);

		// 	unset($sectionListParams);
		// 	// endregion
		// }
	}

	if ($isFilter)
	{
		ob_start();

		$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"catalog",
				[
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => '',// $arResult['SECTION']['ID'],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => $arParams["~PRICE_CODE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"FILTER_VIEW_MODE" => $arResult["FILTER_VIEW_MODE"],
					"XML_EXPORT" => "N",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams['FILTER_USE_HIDE_NOT_AVAILABLE'] === 'Y' ? 'N' : $arParams["HIDE_NOT_AVAILABLE"],
					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					"SEF_MODE" => 'N', //$arParams["SEF_MODE"],
					"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
					"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"SHOW_ALL_WO_SECTION" => "Y",

					"SCROLL_PROPS" => $arParams["FILTER_SCROLL_PROPS"],
					"OFFER_SCROLL_PROPS" => $arParams["OFFER_FILTER_SCROLL_PROPS"],
					"SEARCH_PROPS" => $arParams["FILTER_SEARCH_PROPS"],
					"OFFER_SEARCH_PROPS" => $arParams["OFFER_FILTER_SEARCH_PROPS"],
					"OFFER_TREE_COLOR_PROPS" => $arParams["OFFER_TREE_COLOR_PROPS"],
					"OFFER_TREE_BTN_PROPS" => $arParams["OFFER_TREE_BTN_PROPS"],
					"TOP_PROPS" => $arParams["FILTER_TOP_PROPS"],
					"TARGET_ID" => $arParams['AJAX_ID'],
					'FILTER_USE_HIDE_NOT_AVAILABLE' => $arParams['FILTER_USE_HIDE_NOT_AVAILABLE'],
					'FILTER_HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				],
				$component,
				['HIDE_ICONS' => 'Y']
			);

		$sHtmlContent = ob_get_clean();
		if ($arResult["FILTER_VIEW_MODE"] == 'HORIZONTAL')
		{
			$sHtmlContentFilter = $sHtmlContent;
		}
		else
		{
			$APPLICATION->AddViewContent('site_sidebar_outer', $sHtmlContent, 500);
		}
		unset($sHtmlContent);
	}


	if ($isFilter)
	{
		?>
		<div class="bg-light py-4 px-2 d-block mb-1 d-md-none">
			<a class="btn btn-outline-secondary w-100" data-fancybox="catalog-filter" data-type="inline" data-popup-type="window" data-touch="false" href="#<?=$arParams['AJAX_ID']?>-filter"><?=Loc::getMessage('RS_MM_BC_CATALOG_FILTER_SHOW')?></a>
		</div>
		<?php
	}

	if ($arResult["FILTER_VIEW_MODE"] == 'HORIZONTAL' && $isFilter)
	{
		?><div class="d-none d-sm-none d-md-block"><?
			echo $sHtmlContentFilter;
		?></div><?
	}

	if ($arParams['USE_SORTER'] == 'Y')
	{
		?>
		<div class="catalog-sorter">
			<?php
			global $alfaCTemplate, $alfaCSortType, $alfaCSortToo, $alfaCOutput;

			$arSorterParams = array();

			if (intval($arParams['SORTER_CNT_TEMPLATES']) > 0)
			{
				 for ($i = 0; $i < $arParams['SORTER_CNT_TEMPLATES']; $i++)
				 {
					$arSorterParams['ALFA_CNT_TEMPLATES_'.$i] = $arParams['SORTER_CNT_TEMPLATES_'.$i];
					$arSorterParams['ALFA_CNT_TEMPLATES_NAME_'.$i] = $arParams['SORTER_CNT_TEMPLATES_NAME_'.$i];
				}
			}

			$APPLICATION->IncludeComponent(
				"redsign:catalog.sorter",
				"catalog",
				array(
					"ALFA_ACTION_PARAM_NAME" => $arParams['SORTER_ACTION_PARAM_NAME'],
					"ALFA_ACTION_PARAM_VALUE" => $arParams['SORTER_ACTION_PARAM_VALUE'],
					"ALFA_CHOSE_TEMPLATES_SHOW" => $arParams['SORTER_CHOSE_TEMPLATES_SHOW'],
					"ALFA_DEFAULT_TEMPLATE" => $arParams['SORTER_DEFAULT_TEMPLATE'],
					"ALFA_SORT_BY_SHOW" => $arParams['SORTER_SORT_BY_SHOW'],
					"ALFA_SORT_BY_NAME" => $arParams['SORTER_SORT_BY_NAME'],
					"ALFA_SORT_BY_DEFAULT" => $arParams['SORTER_SORT_BY_DEFAULT'],
					"ALFA_OUTPUT_OF_SHOW" => $arParams['SORTER_OUTPUT_OF_SHOW'],
					"ALFA_OUTPUT_OF" => $arParams['SORTER_OUTPUT_OF'],
					"ALFA_OUTPUT_OF_DEFAULT" => $arParams['SORTER_OUTPUT_OF_DEFAULT'],
					"ALFA_OUTPUT_OF_SHOW_ALL" => $arParams['SORTER_OUTPUT_OF_SHOW_ALL'],
					"ALFA_SHORT_SORTER" => $arParams['SORTER_SHORT_SORTER'],
					"ALFA_CNT_TEMPLATES" => $arParams['SORTER_CNT_TEMPLATES'],
					"TARGET_ID" => $arParams['AJAX_ID'],
				) + $arSorterParams,
				$component
			);

			$alfaTemplateRows = false;

			switch ($alfaCTemplate)
			{
				case 'view-list':
					$alfaTemplateRows = array_fill (
						0,
						$alfaCOutput,
						array(
						   'VARIANT' => '0',
						   'BIG_DATA' => false
					   )
					);

					$alfaTemplateRows = Json::encode($alfaTemplateRows);
					break;

				case 'view-line':
					$alfaTemplateRows = array_fill (
						0,
						$alfaCOutput,
						array(
						   'VARIANT' => '9',
						   'BIG_DATA' => false
					   )
					);

					$alfaTemplateRows = Json::encode($alfaTemplateRows);
					break;

				default:
					$alfaTemplateRows = $arParams['LIST_PRODUCT_ROW_VARIANTS'];
					break;
			}
			?>
		</div>
		<?php
	}

	if (ModuleManager::isModuleInstalled("sale"))
	{
		$arRecomData = array();
		$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
		$obCache = new CPHPCache();
		if ($obCache->InitCache(36000, serialize($recomCacheID), "/sale/bestsellers"))
		{
			$arRecomData = $obCache->GetVars();
		}
		elseif ($obCache->StartDataCache())
		{
			if (Loader::includeModule("catalog"))
			{
				$arSKU = CCatalogSku::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
				$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
			}
			$obCache->EndDataCache($arRecomData);
		}
	}
	$componentSectionParams = [
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_SORT_FIELD" => isset($alfaCSortType) ? $alfaCSortType : $arParams["ELEMENT_SORT_FIELD"],
		"ELEMENT_SORT_ORDER" => isset($alfaCSortToo) ? $alfaCSortToo : $arParams["ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_FIELD2" => isset($alfaCSortType) ? $arParams["ELEMENT_SORT_FIELD"] : $arParams["ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER2" => isset($alfaCSortToo) ? $arParams["ELEMENT_SORT_ORDER"] : $arParams["ELEMENT_SORT_ORDER2"],
		"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
		"PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"MESSAGE_404" => $arParams["~MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
		"PAGE_ELEMENT_COUNT" => isset($alfaCOutput) ? $alfaCOutput : $arParams["PAGE_ELEMENT_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => $arParams["~PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
		// "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_BASE_LINK" => $arResult['FOLDER'],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"LAZY_LOAD" => $arParams["LAZY_LOAD"],
		"LAZY_LOAD_VIEW" => $arParams["LAZY_LOAD_VIEW"],
		"MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
		"LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

		"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
		'LABEL_PROP_POSITION' => $arParams['LIST_LABEL_PROP_POSITION'],
		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
		'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
		'PRODUCT_ROW_VARIANTS' => $alfaTemplateRows ? $alfaTemplateRows : $arParams['LIST_PRODUCT_ROW_VARIANTS'],
		'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
		'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
		'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
		'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
		'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
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
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ""),
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
		'COMPARE_NAME' => $arParams['COMPARE_NAME'],
		'USE_COMPARE_LIST' => 'Y',
		'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
		'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
		'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

		"USE_OFFER_NAME" => $arParams['USE_OFFER_NAME'],
		'SITE_LOCATION_ID' => SITE_LOCATION_ID,
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"FILL_ITEM_ALL_PRICES" => (is_array($arParams['PRICE_CODE']) && count($arParams['PRICE_CODE']) > 1) ? 'Y' :  $arParams['FILL_ITEM_ALL_PRICES'],

		"AJAX_ID" => $arParams['AJAX_ID'],
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
		'BACKGROUND_COLOR' => $arParams['LIST_BACKGROUND_COLOR'],
		'SHOW_SECTION_DESCRIPTION' => $arParams['SHOW_SECTION_DESCRIPTION'],
		'SHOW_ERROR_SECTION_EMPTY' => $arParams['SHOW_ERROR_SECTION_EMPTY'],
		'DISPLAY_PREVIEW_TEXT' => $arParams['LIST_DISPLAY_PREVIEW_TEXT'],

		'MESS_BTN_REQUEST' => $arParams['MESS_BTN_REQUEST'],
		'LINK_BTN_REQUEST' => $arParams['LINK_BTN_REQUEST'],
		'MESS_BTN_BUY1CLICK' => $arParams['MESS_BTN_BUY1CLICK'],
		'CHEAPER_FORM_URL' => $arParams['CHEAPER_FORM_URL'],
		'PRODUCT_PREVIEW' => $arParams['PRODUCT_PREVIEW'],
		'SLIDER_SLIDE_COUNT' => $arParams['LIST_SLIDER_SLIDE_COUNT'],

		'BUY_ON_CAN_BUY' => $arParams['BUY_ON_CAN_BUY'],
		'SECTION_ADD_TO_BASKET_ACTION' => $arParams['SECTION_ADD_TO_BASKET_ACTION'],

		'RS_LIST_SECTION' => 'l_section',

		"BY_LINK" => "Y",
		// set smart.filter + INCLUDE_SUBSECTIONS=Y = bug
		// "SHOW_ALL_WO_SECTION" => "Y", // set smart.filter + INCLUDE_SUBSECTIONS=Y = bug
		//without SHOW_ALL_WO_SECTION=Y and with INCLUDE_SUBSECTIONS=Y in $arParams NO ITEMS in $arResult catalog.section
	];

	if (
		isset($arParams['LIST_BACKGROUND_COLOR']) &&
		is_array($componentSectionParams['SECTION_USER_FIELDS']) &&
		!in_array($arParams['LIST_BACKGROUND_COLOR'], $componentSectionParams['SECTION_USER_FIELDS'])
	)
	{
		$componentSectionParams['SECTION_USER_FIELDS'][] = $arParams['LIST_BACKGROUND_COLOR'];
	}

	if ($componentSectionParams['USE_OFFER_NAME'] === 'Y')
	{
		if (!is_array($componentSectionParams['OFFERS_FIELD_CODE']))
			$componentSectionParams['OFFERS_FIELD_CODE'] = [];

		if (!in_array('NAME', $componentSectionParams['OFFERS_FIELD_CODE']))
			$componentSectionParams['OFFERS_FIELD_CODE'][] = 'NAME';
	}
	?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		$arParams['LIST_TEMPLATE'],
		$componentSectionParams,
		$component
	);?>

	<?php
	if (ModuleManager::isModuleInstalled("sale"))
	{
		if (!empty($arRecomData))
		{
			if (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N')
			{
				ob_start();
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"sidebar",
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
							"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
							"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
							"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
							"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
							"PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
							"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
							"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
							"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_FILTER" => $arParams["CACHE_FILTER"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
							"PAGE_ELEMENT_COUNT" => 0,
							"PRICE_CODE" => $arParams["~PRICE_CODE"],
							"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

							"SET_TITLE" => "N",
							"SET_BROWSER_TITLE" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_LAST_MODIFIED" => "N",
							"ADD_SECTIONS_CHAIN" => "N",

							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
							"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
							"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
							"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

							"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
							"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
							"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
							"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
							"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
							"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
							"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
							"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

							"SECTION_ID" => $intSectionID,
							"SECTION_CODE" => "",
							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
							"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
							'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

							'LABEL_PROP' => $arParams['LABEL_PROP'],
							'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
							'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
							'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
							'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
							'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
							'PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
									ElementListUtils::predictRowVariants(
									1,
									$arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT'],
									true
								)
							),
							'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
							'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
							'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
							'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
							'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

							"DISPLAY_TOP_PAGER" => 'N',
							"DISPLAY_BOTTOM_PAGER" => 'N',
							"HIDE_SECTION_DESCRIPTION" => "Y",

							"RCM_TYPE" => isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '',
							"SHOW_FROM_SECTION" => 'Y',

							'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
							'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
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
							'ADD_TO_BASKET_ACTION' => $basketAction,
							'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
							'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
							'COMPARE_NAME' => $arParams['COMPARE_NAME'],
							'USE_COMPARE_LIST' => 'Y',
							'BACKGROUND_IMAGE' => '',
							'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

							// 'PRODUCT_BLOCKS' => $arParams['LIST_PRODUCT_BLOCKS'],
							"DISPLAY_PREVIEW_TEXT" => $arParams["LIST_DISPLAY_PREVIEW_TEXT"],
							"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],

							'IS_USE_CART' => $arParams['IS_USE_CART'],
							'PRICE_PROP' => $arParams['PRICE_PROP'],
							'DISCOUNT_PROP' => $arParams['DISCOUNT_PROP'],
							'CURRENCY_PROP' => $arParams['CURRENCY_PROP'],
							'PRICE_DECIMALS' => $arParams['PRICE_DECIMALS'],
							'SHOW_PARENT_DESCR' => 'Y',

							'TEMPLATE_VIEW' => $arParams['TEMPLATE_VIEW'],
							// 'GRID_RESPONSIVE_SETTINGS' => $arParams['~GRID_RESPONSIVE_SETTINGS'],
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
							'PRODUCT_PREVIEW' => $arParams['PRODUCT_PREVIEW'],

							'RS_LIST_SECTION' => 'l_section',
							'RS_LIST_SECTION_SHOW_TITLE' => 'Y',
							'RS_LIST_SECTION_TITLE' => GetMessage('CATALOG_PERSONAL_RECOM'),
						),
						$component
					);

				$sHtmlContent = ob_get_clean();
				$APPLICATION->AddViewContent('site_sidebar_inner', $sHtmlContent, 500);
				unset($sHtmlContent);
			}

			if (
				Loader::includeModule('catalog')
				&& (!isset($arParams['LIST_SHOW_VIEWED']) || $arParams['LIST_SHOW_VIEWED'] != 'N')
			)
			{
				ob_start();

					$APPLICATION->IncludeComponent(
						'bitrix:catalog.products.viewed',
						'sidebar',
						array(
							'IBLOCK_MODE' => 'single',
							'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
							'IBLOCK_ID' => $arParams['IBLOCK_ID'],
							'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
							'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
							'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
							'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
							'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
							'PROPERTY_CODE_'.$arRecomData['OFFER_IBLOCK_ID'] => $arParams['LIST_OFFERS_PROPERTY_CODE'],
							'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
							'BASKET_URL' => $arParams['BASKET_URL'],
							'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'].'_cpv',
							'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
							'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
							'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
							'CACHE_TYPE' => $arParams['CACHE_TYPE'],
							'CACHE_TIME' => $arParams['CACHE_TIME'],
							'CACHE_FILTER' => $arParams['CACHE_FILTER'],
							'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
							'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
							'PRICE_CODE' => $arParams['~PRICE_CODE'],
							'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
							'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
							'PAGE_ELEMENT_COUNT' => $bSidebarOuter ? 3 : 4,

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
							'CART_PROPERTIES_'.$arParams['IBLOCK_ID'] => $arParams['PRODUCT_PROPERTIES'],
							'CART_PROPERTIES_'.$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFERS_CART_PROPERTIES'],
							'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => $arParams['ADD_PICT_PROP'],
							'ADDITIONAL_PICT_PROP_'.$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP'],

							'SHOW_FROM_SECTION' => 'N',
							'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
							'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],

							'LABEL_PROP_'.$arParams['IBLOCK_ID'] => $arParams['LABEL_PROP'],
							'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => $arParams['LABEL_PROP_MOBILE'],
							'LABEL_PROP_POSITION' => $arParams['LIST_LABEL_PROP_POSITION'],
							// 'PRODUCT_BLOCKS' => $arParams['LIST_PRODUCT_BLOCKS'],
							'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
							'PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
								  ElementListUtils::predictRowVariants(
									1,
									1
								)
							),
							'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
							'ENLARGE_PROP_'.$arParams['IBLOCK_ID'] => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
							'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
							'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
							'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

							'OFFER_TREE_PROPS_'.$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_TREE_PROPS'],
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
							'PRODUCT_PREVIEW' => $arParams['PRODUCT_PREVIEW'],

							'RS_LIST_SECTION' => 'l_section',
							'RS_LIST_SECTION_SHOW_TITLE' => 'Y',
							'RS_LIST_SECTION_TITLE' => GetMessage('CATALOG_VIEWED'),

						),
						$component
					);


				$sHtmlContent = ob_get_clean();
				$APPLICATION->AddViewContent('site_sidebar_inner', $sHtmlContent, 500);
				unset($sHtmlContent);
			}
		}
	}
}

$APPLICATION->SetPageProperty("hide_section", "Y");
$APPLICATION->SetPageProperty('wide_page', 'N');
$APPLICATION->SetPageProperty('hide_inner_sidebar', $bSidebarInner ? 'N' : 'Y');
$APPLICATION->SetPageProperty('hide_outer_sidebar', $bSidebarOuter ? 'N' : 'Y');
