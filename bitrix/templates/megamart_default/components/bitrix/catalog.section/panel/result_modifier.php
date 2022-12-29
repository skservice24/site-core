<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

use Bitrix\Main\Loader;
use Redsign\MegaMart\IblockElementExt;

$component = $this->getComponent();

$arResult['MODULES']['sale'] = Loader::includeModule('sale');
$arResult['MODULES']['redsign.devfunc'] = Loader::includeModule('redsign.devfunc');
$arResult['MODULES']['redsign.megamart'] = Loader::includeModule('redsign.megamart');


$component->arParams['SHOW_SLIDER'] = 'N';

$arParams = $component->applyTemplateModifications();
$arParams['ADD_TO_BASKET_ACTION'] = $arResult['ORIGINAL_PARAMETERS']['ADD_TO_BASKET_ACTION'];

// place after applyTemplateModifications (process with JS_OFFERS)
if ($arParams['FILL_ITEM_ALL_PRICES'])
{
	foreach ($arResult['ITEMS'] as $key => $item)
	{
		$haveOffers = !empty($item['OFFERS']);

		if ($haveOffers)
		{
			// #bitrixwtf
			if ($arResult['MODULES']['redsign.megamart'])
			{
				foreach ($item['OFFERS'] as $offerKey => $offer)
				{
					IblockElementExt::fixCatalogItemFillAllPrices($arResult['ITEMS'][$key]['OFFERS'][$offerKey]);
					$arResult['ITEMS'][$key]['JS_OFFERS'][$offerKey]['ITEM_ALL_PRICES'] = $arResult['ITEMS'][$key]['OFFERS'][$offerKey]['ITEM_ALL_PRICES'];
				}
				unset($offerKey, $offer);
			}
		}
		else
		{
			// #bitrixwtf
			if ($arResult['MODULES']['redsign.megamart'])
			{
				IblockElementExt::fixCatalogItemFillAllPrices($arResult['ITEMS'][$key]);
			}
		}
	}
	unset($key, $item);
}

if ($arResult['MODULES']['redsign.devfunc'])
{
	\Redsign\DevFunc\Sale\Location\Region::editCatalogResult($arResult);

	foreach ($arResult['ITEMS'] as $key => $item)
	{
		$haveOffers = !empty($item['OFFERS']);

		\Redsign\DevFunc\Sale\Location\Region::editCatalogItem($arResult['ITEMS'][$key]);

		if ($haveOffers)
		{
			if ($arParams['FILL_ITEM_ALL_PRICES'])
			{
				foreach ($arResult['ITEMS'][$key]['OFFERS'] as $offerKey => $arOffer)
				{
					$arResult['ITEMS'][$key]['JS_OFFERS'][$offerKey]['ITEM_PRICES'] = $arOffer['ITEM_PRICES'];
					$arResult['ITEMS'][$key]['JS_OFFERS'][$offerKey]['ITEM_ALL_PRICES'] = $arOffer['ITEM_ALL_PRICES'];
				}
			}
		}
	}
	unset($key, $item);
}

if (!is_array($arResult['CATALOG']) && $arResult['MODULES']['redsign.megamart'])
{
	$params = array(
		'PROP_PRICE' => $arParams['PRICE_PROP'],
		'PROP_DISCOUNT' => $arParams['DISCOUNT_PROP'],
		'PROP_CURRENCY' => $arParams['CURRENCY_PROP'],
		'PRICE_DECIMALS' => $arParams['PRICE_DECIMALS'],
	);

	foreach ($arResult['ITEMS'] as $key => $item)
	{
		if (!isset($arResult['CATALOGS'][$item['IBLOCK_ID']]) && $arResult['MODULES']['redsign.megamart'])
		{
			$arResult['ITEMS'][$key]['RS_PRICES'] = IblockElementExt::getPrice($item, $params);
		}
	}
	unset($key, $item, $params);
}
