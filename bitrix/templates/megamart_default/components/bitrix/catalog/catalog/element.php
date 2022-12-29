<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

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

use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;
use \Bitrix\Main\ModuleManager;
use \Redsign\MegaMart\MyTemplate;

$this->setFrameMode(true);

$request = Application::getInstance()->getContext()->getRequest();

$sOfferSelected = $request->get('offer');

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? array($arParams['COMMON_ADD_TO_BASKET_ACTION']) : array());
}
else
{
	$basketAction = (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION'] : array());
}

if (!function_exists('getSiteHeadCatalog'))
{
	function getSiteHeadCatalog()
	{
		global $APPLICATION;

		$sHTML = '';
		$sHTML .= '<div class="l-main__head'.$APPLICATION->GetViewContent('backgroundClass').'" '.$APPLICATION->GetProperty("backgroundImage").'>';
			$sHTML .= '<div class="container">';

				$sHTML .= $APPLICATION->GetNavChain(
					$path = false,
					$iNumFrom = 0,
					$sNavChainPath = SITE_TEMPLATE_PATH.'/components/bitrix/breadcrumb/standart/template.php',
					$bIncludeOnce = true,
					$bShowIcons = false
				);

				$sHTML .= $APPLICATION->GetViewContent('after-title');
			$sHTML .= '</div>';
		$sHTML .= '</div>';

		return $sHTML;
	}
}

$APPLICATION->AddBufferContent('getSiteHeadCatalog');
?>
<div class="container">
	<?php $APPLICATION->ShowViewContent('catalog-element-sale-banner'); ?>
<div class="position-relative">
		<?php
		$componentElementParams = [
			'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
			'IBLOCK_ID' => $arParams['IBLOCK_ID'],
			'PROPERTY_CODE' => (isset($arParams['DETAIL_PROPERTY_CODE']) ? $arParams['DETAIL_PROPERTY_CODE'] : []),
			'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
			'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
			'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
			'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
			'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
			'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
			'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
			'CHECK_SECTION_ID_VARIABLE' => (isset($arParams['DETAIL_CHECK_SECTION_ID_VARIABLE']) ? $arParams['DETAIL_CHECK_SECTION_ID_VARIABLE'] : ''),
			'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'CACHE_TYPE' => $arParams['CACHE_TYPE'],
			'CACHE_TIME' => $arParams['CACHE_TIME'],
			'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
			'SET_TITLE' => $arParams['SET_TITLE'],
			'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
			'MESSAGE_404' => $arParams['~MESSAGE_404'],
			'SET_STATUS_404' => $arParams['SET_STATUS_404'],
			'SHOW_404' => $arParams['SHOW_404'],
			'FILE_404' => $arParams['FILE_404'],
			'PRICE_CODE' => $arParams['~PRICE_CODE'],
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
			'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
			'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
			'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'PRODUCT_PROPERTIES' => (isset($arParams['PRODUCT_PROPERTIES']) ? $arParams['PRODUCT_PROPERTIES'] : []),
			'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
			'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
			'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
			'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
			'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
			'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],

			'OFFERS_CART_PROPERTIES' => (isset($arParams['OFFERS_CART_PROPERTIES']) ? $arParams['OFFERS_CART_PROPERTIES'] : []),
			'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
			'OFFERS_PROPERTY_CODE' => (isset($arParams['DETAIL_OFFERS_PROPERTY_CODE']) ? $arParams['DETAIL_OFFERS_PROPERTY_CODE'] : []),
			'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
			'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
			'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
			'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],

			'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
			'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
			'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
			'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
			'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
			'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
			'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
			'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
			'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
			'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
			'STRICT_SECTION_CHECK' => (isset($arParams['DETAIL_STRICT_SECTION_CHECK']) ? $arParams['DETAIL_STRICT_SECTION_CHECK'] : ''),
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
			'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
			'LIST_LABEL_PROP_POSITION' => $arParams['LIST_LABEL_PROP_POSITION'],
			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
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
			'MESS_PRICE_RANGES_TITLE' => (isset($arParams['~MESS_PRICE_RANGES_TITLE']) ? $arParams['~MESS_PRICE_RANGES_TITLE'] : ''),
			'MESS_DESCRIPTION_TAB' => (isset($arParams['~MESS_DESCRIPTION_TAB']) ? $arParams['~MESS_DESCRIPTION_TAB'] : ''),
			'MESS_PROPERTIES_TAB' => (isset($arParams['~MESS_PROPERTIES_TAB']) ? $arParams['~MESS_PROPERTIES_TAB'] : ''),
			'MESS_COMMENTS_TAB' => (isset($arParams['~MESS_COMMENTS_TAB']) ? $arParams['~MESS_COMMENTS_TAB'] : ''),
			'MAIN_BLOCK_PROPERTY_CODE' => (isset($arParams['DETAIL_MAIN_BLOCK_PROPERTY_CODE']) ? $arParams['DETAIL_MAIN_BLOCK_PROPERTY_CODE'] : ''),
			'MAIN_BLOCK_OFFERS_PROPERTY_CODE' => (isset($arParams['DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE']) ? $arParams['DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE'] : ''),
			'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
			'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
			'USE_COMMENTS' => $arParams['DETAIL_USE_COMMENTS'],
			'BLOG_USE' => (isset($arParams['DETAIL_BLOG_USE']) ? $arParams['DETAIL_BLOG_USE'] : ''),
			'BLOG_URL' => (isset($arParams['DETAIL_BLOG_URL']) ? $arParams['DETAIL_BLOG_URL'] : ''),
			'BLOG_EMAIL_NOTIFY' => (isset($arParams['DETAIL_BLOG_EMAIL_NOTIFY']) ? $arParams['DETAIL_BLOG_EMAIL_NOTIFY'] : ''),
			'VK_USE' => (isset($arParams['DETAIL_VK_USE']) ? $arParams['DETAIL_VK_USE'] : ''),
			'VK_API_ID' => (isset($arParams['DETAIL_VK_API_ID']) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
			'FB_USE' => (isset($arParams['DETAIL_FB_USE']) ? $arParams['DETAIL_FB_USE'] : ''),
			'FB_APP_ID' => (isset($arParams['DETAIL_FB_APP_ID']) ? $arParams['DETAIL_FB_APP_ID'] : ''),
			'BRAND_USE' => (isset($arParams['DETAIL_BRAND_USE']) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
			'BRAND_PROP_CODE' => (isset($arParams['DETAIL_BRAND_PROP_CODE']) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
			'DISPLAY_NAME' => (isset($arParams['DETAIL_DISPLAY_NAME']) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
			'IMAGE_RESOLUTION' => (isset($arParams['DETAIL_IMAGE_RESOLUTION']) ? $arParams['DETAIL_IMAGE_RESOLUTION'] : ''),
			'PRODUCT_INFO_BLOCK_ORDER' => (isset($arParams['DETAIL_PRODUCT_INFO_BLOCK_ORDER']) ? $arParams['DETAIL_PRODUCT_INFO_BLOCK_ORDER'] : ''),
			'PRODUCT_PAY_BLOCK_ORDER' => (isset($arParams['DETAIL_PRODUCT_PAY_BLOCK_ORDER']) ? $arParams['DETAIL_PRODUCT_PAY_BLOCK_ORDER'] : ''),
			'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			'ADD_SECTIONS_CHAIN' => (isset($arParams['ADD_SECTIONS_CHAIN']) ? $arParams['ADD_SECTIONS_CHAIN'] : ''),
			'ADD_ELEMENT_CHAIN' => (isset($arParams['ADD_ELEMENT_CHAIN']) ? $arParams['ADD_ELEMENT_CHAIN'] : ''),
			'DISPLAY_PREVIEW_TEXT_MODE' => (isset($arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE']) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
			'DETAIL_PICTURE_MODE' => (isset($arParams['DETAIL_DETAIL_PICTURE_MODE']) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : array()),
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'ADD_TO_BASKET_ACTION_PRIMARY' => (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION_PRIMARY']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION_PRIMARY'] : null),
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
			'BACKGROUND_IMAGE' => (isset($arParams['DETAIL_BACKGROUND_IMAGE']) ? $arParams['DETAIL_BACKGROUND_IMAGE'] : ''),
			'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
			'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
			'SET_VIEWED_IN_COMPONENT' => (isset($arParams['DETAIL_SET_VIEWED_IN_COMPONENT']) ? $arParams['DETAIL_SET_VIEWED_IN_COMPONENT'] : ''),
			'SHOW_SLIDER' => (isset($arParams['DETAIL_SHOW_SLIDER']) ? $arParams['DETAIL_SHOW_SLIDER'] : ''),
			'SLIDER_INTERVAL' => (isset($arParams['DETAIL_SLIDER_INTERVAL']) ? $arParams['DETAIL_SLIDER_INTERVAL'] : ''),
			'SLIDER_PROGRESS' => (isset($arParams['DETAIL_SLIDER_PROGRESS']) ? $arParams['DETAIL_SLIDER_PROGRESS'] : ''),
			'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
			'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
			'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

			'USE_GIFTS_DETAIL' => $arParams['USE_GIFTS_DETAIL']?: 'Y',
			'USE_GIFTS_MAIN_PR_SECTION_LIST' => $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST']?: 'Y',
			'GIFTS_SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
			'GIFTS_SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
			'GIFTS_DETAIL_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
			'GIFTS_DETAIL_HIDE_BLOCK_TITLE' => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
			'GIFTS_DETAIL_TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
			'GIFTS_DETAIL_BLOCK_TITLE' => $arParams['GIFTS_DETAIL_BLOCK_TITLE'],
			'GIFTS_SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
			'GIFTS_SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
			'GIFTS_MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
			'GIFTS_PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
			'GIFTS_SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
			'GIFTS_SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
			'GIFTS_SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

			'GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
			'GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],
			'GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'],

			"USE_OFFER_NAME" => $arParams['USE_OFFER_NAME'],
			'SITE_LOCATION_ID' => SITE_LOCATION_ID,
			'FILL_ITEM_ALL_PRICES' => $arParams['FILL_ITEM_ALL_PRICES'],

			// catalog.section
			// 'LIST_PRODUCT_BLOCKS' => $arParams['LIST_PRODUCT_BLOCKS'],
			'LIST_PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
			'LIST_SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
			'LIST_SLIDER_INTERVAL' => $arParams['LIST_SLIDER_INTERVAL'],
			'LIST_SLIDER_PROGRESS' => $arParams['LIST_SLIDER_PROGRESS'],
			'LIST_PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
			'LIST_PROPERTY_CODE_MOBILE' => $arParams['LIST_PROPERTY_CODE_MOBILE'],
			'LIST_OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
			'LIST_OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
			'LIST_DISPLAY_PREVIEW_TEXT' => $arParams['LIST_DISPLAY_PREVIEW_TEXT'],
			'LIST_USE_VOTE_RATING' => $arParams['LIST_USE_VOTE_RATING'],
			'LIST_BACKGROUND_COLOR' => $arParams['LIST_BACKGROUND_COLOR'],
			'LIST_TEMPLATE_VIEW' => $arParams['TEMPLATE_VIEW'],
			'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],

			// catalog.store.amount
			'USE_STORE' => $arParams['USE_STORE'],
			'STORE_PATH' => $arParams['STORE_PATH'],
			'STOCK_MAIN_TITLE' => $arParams['MAIN_TITLE'],
			'MAIN_TITLE' => $arParams['MAIN_TITLE'],
			'USE_MIN_AMOUNT' =>  $arParams['USE_MIN_AMOUNT'],
			'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
			'STORES' => $arParams['STORES'],
			'SHOW_EMPTY_STORE' => $arParams['SHOW_EMPTY_STORE'],
			'SHOW_GENERAL_STORE_INFORMATION' => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
			'USER_FIELDS' => $arParams['USER_FIELDS'],
			'FIELDS' => $arParams['FIELDS'],

			// iblock element props
			'PRICE_PROP' => $arParams['PRICE_PROP'],
			'DISCOUNT_PROP' => $arParams['DISCOUNT_PROP'],
			'CURRENCY_PROP' => $arParams['CURRENCY_PROP'],
			'PRICE_DECIMALS' => $arParams['PRICE_DECIMALS'],
			'ARTNUMBER_PROP' => $arParams['ARTNUMBER_PROP'],
			'PRODUCT_DEALS_PROP' => $arParams['PRODUCT_DEALS_PROP'],

			// offer props
			'OFFER_ARTNUMBER_PROP' => $arParams['OFFER_ARTNUMBER_PROP'],
			'OFFER_TREE_DROPDOWN_PROPS' => $arParams['OFFER_TREE_DROPDOWN_PROPS'],
			'OFFERS_SELECTED' => $sOfferSelected <> '' ? $sOfferSelected : false,

			// brand props
			'USE_BRANDS' => $arParams['USE_BRANDS'],
			'BRAND_PROP' => $arParams['BRAND_PROP'],
			'BRAND_IBLOCK_ID' => $arParams['BRAND_IBLOCK_ID'],
			'BRAND_IBLOCK_BRAND_PROP' => $arParams['BRAND_IBLOCK_BRAND_PROP'],

			// share settings
			'USE_SHARE' => $arParams['USE_SHARE'],
			'SOCIAL_SERVICES' => $arParams['DETAIL_SOCIAL_SERVICES'],
			'SOCIAL_COUNTER' => $arParams['SOCIAL_COUNTER'],
			'SOCIAL_COPY' => $arParams['SOCIAL_COPY'],
			'SOCIAL_LIMIT' => $arParams['SOCIAL_LIMIT'],
			'SOCIAL_SIZE' => $arParams['SOCIAL_SIZE'],

			// tabs settings
			'TAB_PROPERTIES' => $arParams['DETAIL_TAB_PROPERTIES'],
			'TABS' => $arParams['DETAIL_TABS'],
			'TABS_ORDER' => $arParams['DETAIL_TABS_ORDER'],

			// lines settings
			'BLOCK_LINES_PROPERTIES' => $arParams['DETAIL_BLOCK_LINES_PROPERTIES'],
			'BLOCK_LINES' => $arParams['DETAIL_BLOCK_LINES'],
			'BLOCK_LINES_ORDER' => $arParams['DETAIL_BLOCK_LINES_ORDER'],
			'LINES_PROPERTIES' => $arParams['DETAIL_LINES_PROPERTIES'] ?? [],

			// delivery
			'DETAIL_DELIVERY_PAYMENT_INFO' => $arParams['DETAIL_DELIVERY_PAYMENT_INFO'],
			'DETAIL_DELIVERY_LINK' => $arParams['DETAIL_DELIVERY_LINK'],
			'DETAIL_PAYMENT_LINK' => $arParams['DETAIL_PAYMENT_LINK'],

			// favorite
			'USE_FAVORITE' => $arParams['USE_FAVORITE'],
			'MESS_BTN_FAVORITE' => $arParams['MESS_BTN_FAVORITE'],
			'FAVORITE_COUNT_PROP' => $arParams['FAVORITE_COUNT_PROP'],

			// size table
			'SHOW_SIZE_TABLE' => $arParams['DETAIL_SHOW_SIZE_TABLE'],
			'OFFER_TREE_SIZE_PROPS' => $arParams['OFFER_TREE_SIZE_PROPS'],
			'SIZE_TABLE_USER_FIELDS' => $arParams['SIZE_TABLE_USER_FIELDS'],
			'SIZE_TABLE_PROP' => $arParams['SIZE_TABLE_PROP'],

			// other settings
			'DISPLAY_PROPERTIES_MAX' => $arParams['DETAIL_DISPLAY_PROPERTIES_MAX'],
			'OFFERS_PROPERTIES_MAX' => $arParams['DETAIL_OFFERS_PROPERTIES_MAX'],
			'USE_GIFTS' => $arParams['USE_GIFTS'],
			'BACKGROUND_COLOR' => $arParams['DETAIL_BACKGROUND_COLOR'],
			'PRODUCT_DEALS_SHOW' => $arParams['PRODUCT_DEALS_SHOW'],
			'PRODUCT_DEALS_USER_FIELDS' => $arParams['PRODUCT_DEALS_USER_FIELDS'],
			'PROPERTY_ELEMENT_LINE_COUNT' => $arParams['PROPERTY_ELEMENT_LINE_COUNT'],
			'PRODUCT_PREVIEW' => $arParams['PRODUCT_PREVIEW'],

			'MESS_BTN_REQUEST' => $arParams['MESS_BTN_REQUEST'],
			'LINK_BTN_REQUEST' => $arParams['LINK_BTN_REQUEST'],
			'MESS_BTN_BUY1CLICK' => $arParams['MESS_BTN_BUY1CLICK'],
			'CHEAPER_FORM_URL' => $arParams['CHEAPER_FORM_URL'],

			'BUY_ON_CAN_BUY' => $arParams['BUY_ON_CAN_BUY'],
			'SHOW_CASHBACK' => $arParams['DETAIL_SHOW_CASHBACK'],
			'SHOW_WIDE_VIEW' => $arParams['SHOW_WIDE_VIEW'],


			'LIST_PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
			'LIST_PRODUCT_ROW_VARIANTS' => $alfaTemplateRows ? $alfaTemplateRows : $arParams['LIST_PRODUCT_ROW_VARIANTS'],
			'LIST_ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
			'LIST_ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
			'LIST_SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
			'LIST_SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
			'LIST_SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',
			'LIST_SLIDER_SLIDE_COUNT' => $arParams['LIST_SLIDER_SLIDE_COUNT'],
		];

		if (isset($arParams['USER_CONSENT']))
		{
			$componentElementParams['USER_CONSENT'] = $arParams['USER_CONSENT'];
		}

		if (isset($arParams['USER_CONSENT_ID']))
		{
			$componentElementParams['USER_CONSENT_ID'] = $arParams['USER_CONSENT_ID'];
		}

		if (isset($arParams['USER_CONSENT_IS_CHECKED']))
		{
			$componentElementParams['USER_CONSENT_IS_CHECKED'] = $arParams['USER_CONSENT_IS_CHECKED'];
		}

		if (isset($arParams['USER_CONSENT_IS_LOADED']))
		{
			$componentElementParams['USER_CONSENT_IS_LOADED'] = $arParams['USER_CONSENT_IS_LOADED'];
		}

		if (is_array($arParams['PRICE_CODE']) && count($arParams['PRICE_CODE']) > 1)
		{
			$componentElementParams['FILL_ITEM_ALL_PRICES'] = 'Y';
		}

		foreach ($arParams as $name => $prop)
		{
			if (strncmp($name, 'PROPERTY_FILE_VIEW_', 19) === 0)
			{
				$componentElementParams[$name] = $arParams[$name];
			}
		}

		if ($componentElementParams['USE_OFFER_NAME'] === 'Y')
		{
			if (!is_array($componentElementParams['OFFERS_FIELD_CODE']))
				$componentElementParams['OFFERS_FIELD_CODE'] = [];

			if (!in_array('NAME', $componentElementParams['OFFERS_FIELD_CODE']))
				$componentElementParams['OFFERS_FIELD_CODE'][] = 'NAME';
		}

		if ($request->isAjaxRequest() && $request->get('fancybox') == 'true')
		{

			$componentElementParams['SLIDER_SLIDE_COUNT'] = $arParams['LIST_SLIDER_SLIDE_COUNT'];

			$elementId = $APPLICATION->IncludeComponent(
				'bitrix:catalog.element',
				'preview',
				$componentElementParams,
				$component
			);
		}
		else
		{

			$elementId = $APPLICATION->IncludeComponent(
				'bitrix:catalog.element',
				$arParams['DETAIL_TEMPLATE'],
				$componentElementParams,
				$component
			);
			$GLOBALS['CATALOG_CURRENT_ELEMENT_ID'] = $elementId;
		}

		if ($elementId > 0)
		{
			include(MyTemplate::getTemplatePart($templateFolder.'/include/element/store.php'));

			$recommendedData = array();
			$recommendedCacheId = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);

			$obCache = new CPHPCache();
			if ($obCache->InitCache(36000, serialize($recommendedCacheId), '/catalog/recommended'))
			{
				$recommendedData = $obCache->GetVars();
			}
			elseif ($obCache->StartDataCache())
			{
				if (Loader::includeModule('catalog'))
				{
					$arSku = CCatalogSku::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
					$recommendedData['OFFER_IBLOCK_ID'] = (!empty($arSku) ? $arSku['IBLOCK_ID'] : 0);
					$recommendedData['IBLOCK_LINK'] = '';
					$recommendedData['ALL_LINK'] = '';
					$rsProps = CIBlockProperty::GetList(
						array('SORT' => 'ASC', 'ID' => 'ASC'),
						array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_TYPE' => 'E', 'ACTIVE' => 'Y')
					);
					$found = false;
					while ($arProp = $rsProps->Fetch())
					{
						if ($found)
						{
							break;
						}

						if ($arProp['CODE'] == '')
						{
							$arProp['CODE'] = $arProp['ID'];
						}

						$arProp['LINK_IBLOCK_ID'] = intval($arProp['LINK_IBLOCK_ID']);
						if ($arProp['LINK_IBLOCK_ID'] != 0 && $arProp['LINK_IBLOCK_ID'] != $arParams['IBLOCK_ID'])
						{
							continue;
						}

						if ($arProp['LINK_IBLOCK_ID'] > 0)
						{
							if ($recommendedData['IBLOCK_LINK'] == '')
							{
								$recommendedData['IBLOCK_LINK'] = $arProp['CODE'];
								$found = true;
							}
						}
						else
						{
							if ($recommendedData['ALL_LINK'] == '')
							{
								$recommendedData['ALL_LINK'] = $arProp['CODE'];
							}
						}
					}

					if ($found)
					{
						if (defined('BX_COMP_MANAGED_CACHE'))
						{
							global $CACHE_MANAGER;
							$CACHE_MANAGER->StartTagCache('/catalog/recommended');
							$CACHE_MANAGER->RegisterTag('iblock_id_'.$arParams['IBLOCK_ID']);
							$CACHE_MANAGER->EndTagCache();
						}
					}
				}

				$obCache->EndDataCache($recommendedData);
			}

			if (!empty($recommendedData))
			{
				include(MyTemplate::getTemplatePart($templateFolder.'/include/element/recommended.php'));
				include(MyTemplate::getTemplatePart($templateFolder.'/include/element/popular.php'));
				include(MyTemplate::getTemplatePart($templateFolder.'/include/element/viewed.php'));
			}
			include(MyTemplate::getTemplatePart($templateFolder.'/include/element/lines.php'));
		}
	?>
	<div class="l-main__nav-wrap">
		<?php
		$sPageNavId = 'l-main__nav';
		$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $sPageNavId);
		$jsParams = array(
			'ID' => $sPageNavId,
		);

		$this->addExternalJs($templateFolder.'/page-nav.js');
		?>
		<nav class="l-main__nav nav-scrollspy position-sticky sticky-compact" id="<?=$sPageNavId?>">
		</nav>
		<script>
			var <?=$obName?> = new JCPageNavComponent(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
		</script>
	</div>
</div>

</div>
<?php
$APPLICATION->SetPageProperty("hide_section", "Y");
$APPLICATION->SetPageProperty('hide_title', 'Y');
$APPLICATION->SetPageProperty('wide_page', 'Y');
$APPLICATION->SetPageProperty('hide_outer_sidebar', 'Y');
$APPLICATION->SetPageProperty('hide_inner_sidebar', 'Y');
