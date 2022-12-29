<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock;
use Redsign\MegaMart\ParametersUtils;
use Redsign\MegaMart\ElementListUtils;

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * @var array $arTemplateParameters
 */

global $USER_FIELD_MANAGER;

Loc::loadMessages(__FILE__);


$bMegamartInclude = Loader::includeModule('redsign.megamart');

if (!Loader::includeModule('iblock'))
	return;

$boolCatalog = Loader::includeModule('catalog');
CBitrixComponent::includeComponentClass($componentName);

$usePropertyFeatures = Iblock\Model\PropertyFeature::isEnabledFeatures();

$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$defaultValue = array('-' => GetMessage('CP_BCS_TPL_PROP_EMPTY'));
$arSKU = false;
$boolSKU = false;
$boolIsCatalog = false;
$filterDataValues = array();
if ($boolCatalog && $iblockExists)
{
	$arSKU = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
	$filterDataValues['iblockId'] = (int)$arCurrentValues['IBLOCK_ID'];
	if ($boolSKU)
	{
		$filterDataValues['offersIblockId'] = $arSKU['IBLOCK_ID'];
	}

	$arCatalog = CCatalogSku::GetInfoByIBlock($arCurrentValues['IBLOCK_ID']);
	if (false !== $arCatalog) {
		$boolIsCatalog = true;
	}
}

$arProperty_UF = array();
$arSProperty_LNS = array();
$arSProperty_F = array();
if ($iblockExists)
{
	$arUserFields = $USER_FIELD_MANAGER->GetUserFields('IBLOCK_'.$arCurrentValues['IBLOCK_ID'].'_SECTION', 0, LANGUAGE_ID);
	foreach( $arUserFields as $FIELD_NAME => $arUserField)
	{
		$arUserField['LIST_COLUMN_LABEL'] = (string)$arUserField['LIST_COLUMN_LABEL'];
		$arProperty_UF[$FIELD_NAME] = $arUserField['LIST_COLUMN_LABEL'] ? '['.$FIELD_NAME.']'.$arUserField['LIST_COLUMN_LABEL'] : $FIELD_NAME;

		if ($arUserField['USER_TYPE']['BASE_TYPE'] === 'string')
		{
			$arSProperty_LNS[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
		}

		if ($arUserField['USER_TYPE']['BASE_TYPE'] === 'file' && $arUserField['MULTIPLE'] === 'N')
		{
			$arSProperty_F[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
		}
	}
	unset($arUserFields);
}

if ($bMegamartInclude)
{
	ParametersUtils::addCommonParameters(
		$arTemplateParameters,
		$arCurrentValues,
		array(
			'owlSupport',
			'blockName',
			'lazy-images',
		)
	);
}

if ($arCurrentValues['USE_OWL'] !== 'Y')
{
$lineElementCount = (int)$arCurrentValues['LINE_ELEMENT_COUNT'] ?: 3;
$pageElementCount = (int)$arCurrentValues['PAGE_ELEMENT_COUNT'] ?: 18;

$arTemplateParameters['PRODUCT_ROW_VARIANTS'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_ROW_VARIANTS'),
	'TYPE' => 'CUSTOM',
	'BIG_DATA' => 'Y',
	'COUNT_PARAM_NAME' => 'PAGE_ELEMENT_COUNT',
	'JS_FILE' => ParametersUtils::getSettingsScript('dragdrop_add'),
	'JS_EVENT' => 'initDraggableAddControl',
	'JS_MESSAGES' => Json::encode(array(
		'variant' => GetMessage('CP_BCS_TPL_SETTINGS_VARIANT'),
		'delete' => GetMessage('CP_BCS_TPL_SETTINGS_DELETE'),
		'quantity' => GetMessage('CP_BCS_TPL_SETTINGS_QUANTITY'),
		'quantityBigData' => GetMessage('CP_BCS_TPL_SETTINGS_QUANTITY_BIG_DATA')
	)),
	'JS_DATA' => Json::encode(ElementListUtils::getTemplateVariantsMap()),
	'DEFAULT' => Json::encode(ElementListUtils::predictRowVariants($lineElementCount, $pageElementCount))
);

$arTemplateParameters['ENLARGE_PRODUCT'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_ENLARGE_PRODUCT'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'N',
	'ADDITIONAL_VALUES' => 'N',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N',
	'VALUES' => array(
		'STRICT' => GetMessage('CP_BCS_TPL_ENLARGE_PRODUCT_STRICT'),
		'PROP' => GetMessage('CP_BCS_TPL_ENLARGE_PRODUCT_PROP')
	)
);
}

$arProductBlocks = array(
	// 'price' => GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_PRICE'),
	// 'quantity' => GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_QUANTITY'),
	// 'buttons' => GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_BUTTONS'),
	'props' => GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_PROPS'),
	//'compare' => GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_COMPARE'),
	'preview' => GetMessage('RS_MM_PRODUCT_BLOCK_PREVIEW'),
);

// if ($arCurrentValues['USE_VOTE_RATING'] == 'Y')
// {
	// $arProductBlocks['rate'] = GetMessage('RS_MM_PRODUCT_BLOCK_RATE');
// }

if ($boolIsCatalog)
{
	$arProductBlocks['sku'] = GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_SKU');
	// $arProductBlocks['quantityLimit'] = GetMessage('CP_BCS_TPL_PRODUCT_BLOCK_QUANTITY_LIMIT');
}

$arTemplateParameters['PRODUCT_BLOCKS_ORDER'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_BLOCKS_ORDER'),
	'TYPE' => 'CUSTOM',
	'JS_FILE' => CatalogSectionComponent::getSettingsScript($componentPath, 'dragdrop_order'),
	'JS_EVENT' => 'initDraggableOrderControl',
	'JS_DATA' => Json::encode($arProductBlocks),
	'DEFAULT' => 'preview,price,quantity,buttons'
);

$arTemplateParameters['SHOW_SLIDER'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_SHOW_SLIDER'),
	'TYPE' => 'CHECKBOX',
	'MULTIPLE' => 'N',
	'REFRESH' => 'Y',
	'DEFAULT' => 'Y'
);

if (isset($arCurrentValues['SHOW_SLIDER']) && $arCurrentValues['SHOW_SLIDER'] === 'Y')
{
	$arTemplateParameters['SLIDER_SLIDE_COUNT'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('RS_MM_SLIDER_SLIDE_COUNT'),
		'TYPE' => 'TEXT',
		'MULTIPLE' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '5'
	);
/*
	$arTemplateParameters['SLIDER_SLIDE_COUNT'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SLIDER_INTERVAL'),
		'TYPE' => 'TEXT',
		'MULTIPLE' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '3000'
	);
	$arTemplateParameters['SLIDER_PROGRESS'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SLIDER_PROGRESS'),
		'TYPE' => 'CHECKBOX',
		'MULTIPLE' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => 'N'
	);
*/

}

$arAllPropList = array();
$arFilePropList = $defaultValue;
$arListPropList = array();
$arHighloadPropList = array();

if ($iblockExists)
{
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];

		if ($arProp['CODE'] == '')
		{
			$arProp['CODE'] = $arProp['ID'];
		}

		$arAllPropList[$arProp['CODE']] = $strPropName;

		if ($arProp['PROPERTY_TYPE'] === Iblock\PropertyTable::TYPE_FILE)
		{
			$arFilePropList[$arProp['CODE']] = $strPropName;
		}

		if ($arProp['PROPERTY_TYPE'] === Iblock\PropertyTable::TYPE_LIST)
		{
			$arListPropList[$arProp['CODE']] = $strPropName;
		}

		if ($arProp['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_STRING && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
		{
			$arHighloadPropList[$arProp['CODE']] = $strPropName;
		}
	}

	$showedProperties = [];
	if ($usePropertyFeatures)
	{
		if ($iblockExists)
		{
			$showedProperties = Iblock\Model\PropertyFeature::getListPageShowPropertyCodes(
				$arCurrentValues['IBLOCK_ID'],
				['CODE' => 'Y']
			);
			if ($showedProperties === null)
				$showedProperties = [];
		}
	}
	else
	{
		if (!empty($arCurrentValues['PROPERTY_CODE']) && is_array($arCurrentValues['PROPERTY_CODE']))
		{
			$showedProperties = $arCurrentValues['PROPERTY_CODE'];
		}
	}
	if (!empty($showedProperties))
	{
		$selected = array();

		foreach ($showedProperties as $code)
		{
			if (isset($arAllPropList[$code]))
			{
				$selected[$code] = $arAllPropList[$code];
			}
		}

		$arTemplateParameters['PROPERTY_CODE_MOBILE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_PROPERTY_CODE_MOBILE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'VALUES' => $selected
		);
	}
	unset($showedProperties);

	if (isset($arCurrentValues['ENLARGE_PRODUCT']) && $arCurrentValues['ENLARGE_PRODUCT'] === 'PROP')
	{
		$arTemplateParameters['ENLARGE_PROP'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_ENLARGE_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $defaultValue + $arListPropList
		);
	}

	if ($boolSKU)
	{
		$arTemplateParameters['PRODUCT_DISPLAY_MODE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_DISPLAY_MODE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => array(
				'N' => GetMessage('CP_BCS_TPL_DML_SIMPLE'),
				'Y' => GetMessage('CP_BCS_TPL_DML_EXT')
			)
		);
	}

	$arTemplateParameters['ADD_PICT_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_ADD_PICT_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arFilePropList
	);

	$arTemplateParameters['LABEL_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_LABEL_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'Y',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'Y',
		'VALUES' => $arListPropList
	);

	if (isset($arCurrentValues['LABEL_PROP']) && !empty($arCurrentValues['LABEL_PROP']))
	{
		if (!is_array($arCurrentValues['LABEL_PROP']))
		{
			$arCurrentValues['LABEL_PROP'] = array($arCurrentValues['LABEL_PROP']);
		}

		$selected = array();
		foreach ($arCurrentValues['LABEL_PROP'] as $name)
		{
			if (isset($arListPropList[$name]))
			{
				$selected[$name] = $arListPropList[$name];
			}
		}

		$arTemplateParameters['LABEL_PROP_MOBILE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_LABEL_PROP_MOBILE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'VALUES' => $selected
		);
		unset($selected);

/*
		$arTemplateParameters['LABEL_PROP_POSITION'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_LABEL_PROP_POSITION'),
			'TYPE' => 'CUSTOM',
			'JS_FILE' => CatalogSectionComponent::getSettingsScript($componentPath, 'position'),
			'JS_EVENT' => 'initPositionControl',
			'JS_DATA' => Json::encode(
				array(
					'positions' => array(
						'top-left', 'top-center', 'top-right',
						'middle-left', 'middle-center', 'middle-right',
						'bottom-left', 'bottom-center', 'bottom-right'
					),
					'className' => ''
				)
			),
			'DEFAULT' => 'top-left'
		);
*/
	}

	if ($boolSKU && isset($arCurrentValues['PRODUCT_DISPLAY_MODE']) && 'Y' == $arCurrentValues['PRODUCT_DISPLAY_MODE'])
	{
		$arAllOfferPropList = array();
		$arFileOfferPropList = $arTreeOfferPropList = $defaultValue;
		$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
		);
		while ($arProp = $rsProps->Fetch())
		{
			if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;
			$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
			$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
			if ('' == $arProp['CODE'])
				$arProp['CODE'] = $arProp['ID'];
			$arAllOfferPropList[$arProp['CODE']] = $strPropName;
			if ('F' == $arProp['PROPERTY_TYPE'])
				$arFileOfferPropList[$arProp['CODE']] = $strPropName;
			if ('N' != $arProp['MULTIPLE'])
				continue;
			if (
				'L' == $arProp['PROPERTY_TYPE']
				|| 'E' == $arProp['PROPERTY_TYPE']
				|| ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			)
				$arTreeOfferPropList[$arProp['CODE']] = $strPropName;
		}
		$arTemplateParameters['OFFER_ADD_PICT_PROP'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_OFFER_ADD_PICT_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFileOfferPropList
		);
		if (!$usePropertyFeatures)
		{
			$arTemplateParameters['OFFER_TREE_PROPS'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_OFFER_TREE_PROPS'),
				'TYPE' => 'LIST',
				'MULTIPLE' => 'Y',
				'ADDITIONAL_VALUES' => 'N',
				'REFRESH' => 'Y',
				'DEFAULT' => '-',
				'VALUES' => $arTreeOfferPropList
			);

			if (!empty($arCurrentValues['OFFER_TREE_PROPS']))
			{
				$selected = array();

				foreach ($arCurrentValues['OFFER_TREE_PROPS'] as $code)
				{
					if (isset($arTreeOfferPropList[$code]))
					{
						$selected[$code] = $arTreeOfferPropList[$code];
					}
				}

				$arTemplateParameters['OFFER_TREE_DROPDOWN_PROPS'] = array(
					'PARENT' => 'OFFERS_SETTINGS',
					'NAME' => getMessage('RS_MM_OFFER_TREE_DROPDOWN_PROPS'),
					'TYPE' => 'LIST',
					'VALUES' => $defaultValue + $selected,
					'MULTIPLE' => 'Y',
					'DEFAULT' => '-',
				);

				unset($selected);
			}
		}
		if (isset($arCurrentValues['SHOW_ARTNUMBER']) && $arCurrentValues['SHOW_ARTNUMBER'] === 'Y')
		{
			$arTemplateParameters['OFFER_ARTNUMBER_PROP'] = array(
				'PARENT' => 'OFFERS_SETTINGS',
				'NAME' => Loc::getMessage('RS_MM_OFFER_ARTNUMBER_PROP'),
				'TYPE' => 'LIST',
				'MULTIPLE' => 'N',
				'ADDITIONAL_VALUES' => 'N',
				'REFRESH' => 'N',
				'DEFAULT' => '-',
				'VALUES' => $defaultValue + $arAllOfferPropList
			);
		}
	}
}

if ($boolIsCatalog)
{
	$arTemplateParameters['USE_OFFER_NAME'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('CP_BCS_TPL_USE_OFFER_NAME'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);

	$arTemplateParameters['PRODUCT_SUBSCRIPTION'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_SUBSCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y'
	);
	$arTemplateParameters['SHOW_DISCOUNT_PERCENT'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SHOW_DISCOUNT_PERCENT'),
		'TYPE' => 'CHECKBOX',
		'REFRESH' => 'N',
		'DEFAULT' => 'N'
	);

/*
	if (isset($arCurrentValues['SHOW_DISCOUNT_PERCENT']) && $arCurrentValues['SHOW_DISCOUNT_PERCENT'] === 'Y')
	{
		$arTemplateParameters['DISCOUNT_PERCENT_POSITION'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_DISCOUNT_PERCENT_POSITION'),
			'TYPE' => 'CUSTOM',
			'JS_FILE' => CatalogSectionComponent::getSettingsScript($componentPath, 'position'),
			'JS_EVENT' => 'initPositionControl',
			'JS_DATA' => Json::encode(
				array(
					'positions' => array(
						'top-left', 'top-center', 'top-right',
						'middle-left', 'middle-center', 'middle-right',
						'bottom-left', 'bottom-center', 'bottom-right'
					),
					'className' => 'bx-pos-parameter-block-circle'
				)
			),
			'DEFAULT' => 'bottom-right'
		);
	}

	$arTemplateParameters['SHOW_OLD_PRICE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SHOW_OLD_PRICE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);
*/
	$arTemplateParameters['SHOW_MAX_QUANTITY'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SHOW_MAX_QUANTITY'),
		'TYPE' => 'LIST',
		'REFRESH' => 'Y',
		'MULTIPLE' => 'N',
		'VALUES' => array(
			'N' => GetMessage('CP_BCS_TPL_SHOW_MAX_QUANTITY_N'),
			'Y' => GetMessage('CP_BCS_TPL_SHOW_MAX_QUANTITY_Y'),
			'M' => GetMessage('CP_BCS_TPL_SHOW_MAX_QUANTITY_M')
		),
		'DEFAULT' => array('N'),
	);

	if (isset($arCurrentValues['SHOW_MAX_QUANTITY']))
	{
		if ($arCurrentValues['SHOW_MAX_QUANTITY'] !== 'N')
		{
			$arTemplateParameters['MESS_SHOW_MAX_QUANTITY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_MESS_SHOW_MAX_QUANTITY'),
				'TYPE' => 'STRING',
				'DEFAULT' => ''// GetMessage('CP_BCS_TPL_MESS_SHOW_MAX_QUANTITY_DEFAULT')
			);
		}

		if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'M')
		{
			$arTemplateParameters['RELATIVE_QUANTITY_FACTOR'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_RELATIVE_QUANTITY_FACTOR'),
				'TYPE' => 'STRING',
				'DEFAULT' => '5'
			);
			$arTemplateParameters['MESS_RELATIVE_QUANTITY_MANY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_MANY'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_MANY_DEFAULT')
			);
			$arTemplateParameters['MESS_RELATIVE_QUANTITY_FEW'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_FEW'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_FEW_DEFAULT')
			);
		}
	}

	$arTemplateParameters['ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BCS_TPL_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'ADD' => GetMessage('ADD_TO_BASKET_ACTION_ADD'),
			'BUY' => GetMessage('ADD_TO_BASKET_ACTION_BUY')
		),
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N'
	);
/*
	$arTemplateParameters['SHOW_CLOSE_POPUP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SHOW_CLOSE_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
*/

	$arTemplateParameters['FILL_ITEM_ALL_PRICES'] = array(
		'PARENT' => 'PRICE',
		'NAME' => Loc::getMessage('RS_MM_FILL_ITEM_ALL_PRICES'),
		"TYPE" => 'CHECKBOX',
		"DEFAULT" => 'N',
	);
	$arTemplateParameters['USE_GIFTS'] = array(
		'PARENT' => 'GIFTS_SETTINGS',
		'NAME' => GetMessage('RS_MM_USE_GIFTS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		//'REFRESH' => 'Y',
	);
}
else
{
	$arTemplateParameters['PRICE_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('RS_MM_PRICE_PROP'),
		'TYPE' => 'LIST',
		'VALUES' => $defaultValue + $arAllPropList,
	);
	$arTemplateParameters['DISCOUNT_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('RS_MM_DISCOUNT_PROP'),
		'TYPE' => 'LIST',
		'VALUES' => $defaultValue + $arAllPropList,
	);

	$arTemplateParameters['CURRENCY_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('RS_MM_CURRENCY_PROP'),
		'TYPE' => 'LIST',
		'VALUES' => $defaultValue + $arAllPropList,
	);

	$arTemplateParameters['PRICE_DECIMALS'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('RS_MM_PRICE_DECIMALS'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'0' => '0',
			'1' => '1',
			'2' => '2',
		),
		'DEFAULT' => '0',
	);

	if ($boolLightBasket) {

		$arTemplateParameters['IS_USE_CART'] = array(
			'NAME' => Loc::getMessage('RS_MM_IS_USE_CART'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y'
		);
	}

	unset($addToBasketActions['BUY']);
}

$arTemplateParameters['SHOW_ARTNUMBER'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('RS_MM_SHOW_ARTNUMBER'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
);

if (isset($arCurrentValues['SHOW_ARTNUMBER']) && $arCurrentValues['SHOW_ARTNUMBER'] === 'Y')
{
	$arTemplateParameters['ARTNUMBER_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => Loc::getMessage('RS_MM_ARTNUMBER_PROP'),
		'TYPE' => 'LIST',
		'VALUES' => $defaultValue + $arAllPropList,
		'DEFAULT' => '-',
	);
}

$arTemplateParameters['FILTER_PROPS'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => getMessage('RS_MM_BCS_CATALOG_FILTER_PROPS'),
	'TYPE' => 'LIST',
	'VALUES' => array_merge(
		$defaultValue,
		$arListPropList//,
		// array(
			// 'ALL_PRODUCT' => getMessage('RS_SLINE.TAB_ALL'),
			// 'VIEWED_PRODUCT' => getMessage('RS_SLINE.TAB_VIEWED_PRODUCT'),
			// 'FAVORITE_PRODUCT' => getMessage('RS_SLINE.TAB_FAVORITE_PRODUCT'),
			// 'BESTSELLER_PRODUCT' => getMessage('RS_SLINE.TAB_BESTSELLER_PRODUCT'),
			// 'BIGDATA_PRODUCT' => getMessage('RS_SLINE.TAB_BIGDATA_PRODUCT'),
		// )
	),
	'MULTIPLE' => 'Y',
	'DEFAULT' => '-',
);

$arTemplateParameters['SHOW_ERROR_SECTION_EMPTY'] = array(
	'PARENT' => 'LIST_SETTINGS',
	'NAME' => getMessage('RS_MM_SHOW_ERROR_SECTION_EMPTY'),
	'TYPE' => 'CHECKBOX',
	'VALUE' => 'Y',
	'REFRESH' => 'N',
	'DEFAULT' => 'N',
);

if ($arCurrentValues['SHOW_ERROR_SECTION_EMPTY'] === 'Y')
{
	$arTemplateParameters['MESS_ERROR_SECTION_EMPTY'] = array(
		'PARENT' => 'LIST_SETTINGS',
		'NAME' => GetMessage('RS_MM_MESS_ERROR_SECTION_EMPTY'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('RS_MM_MESS_ERROR_SECTION_EMPTY_DEFAULT'),
	);
}

$arTemplateParameters['MESS_BTN_BUY'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_BUY'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_BUY_DEFAULT')
);

$arTemplateParameters['LAZY_LOAD'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_LAZY_LOAD'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N',
);

if (isset($arCurrentValues['LAZY_LOAD']) && $arCurrentValues['LAZY_LOAD'] !== 'N')
{
	$arLazyLoadValues = [
		'Y' => Loc::getMessage('CP_BCS_TPL_LAZY_LOAD_VIEW.SHOW'),
		'P' => Loc::getMessage('CP_BCS_TPL_LAZY_LOAD_VIEW.SHOW_PAGEN'),
	];
	$arTemplateParameters['LAZY_LOAD_VIEW'] = array(
		'PARENT' => 'PAGER_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_LAZY_LOAD_VIEW'),
		'TYPE' => 'LIST',
		'REFRESH' => 'Y',
		'DEFAULT' => 'N',
		'VALUES' => $arLazyLoadValues,
	);

	$arTemplateParameters['MESS_BTN_LAZY_LOAD'] = array(
		'PARENT' => 'PAGER_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_LAZY_LOAD'),
		'TYPE' => 'TEXT',
		'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_LAZY_LOAD_DEFAULT')
	);
}

$arTemplateParameters['LOAD_ON_SCROLL'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_LOAD_ON_SCROLL'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$arTemplateParameters['MESS_BTN_ADD_TO_BASKET'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_ADD_TO_BASKET'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_ADD_TO_BASKET_DEFAULT')
);
$arTemplateParameters['MESS_BTN_SUBSCRIBE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_SUBSCRIBE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_SUBSCRIBE_DEFAULT')
);

if (isset($arCurrentValues['DISPLAY_COMPARE']) && $arCurrentValues['DISPLAY_COMPARE'] === 'Y')
{
	$arTemplateParameters['MESS_BTN_COMPARE'] = array(
		'PARENT' => 'COMPARE',
		'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_COMPARE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_COMPARE_DEFAULT')
	);
	$arTemplateParameters['COMPARE_NAME'] = array(
		'PARENT' => 'COMPARE',
		'NAME' => GetMessage('CP_BCS_TPL_COMPARE_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'CATALOG_COMPARE_LIST'
	);
}

$arTemplateParameters['MESS_BTN_DETAIL'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_DETAIL'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_DETAIL_DEFAULT')
);
$arTemplateParameters['MESS_NOT_AVAILABLE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_NOT_AVAILABLE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_NOT_AVAILABLE_DEFAULT')
);
$arTemplateParameters['RCM_TYPE'] = array(
	'PARENT' => 'BIG_DATA_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_TYPE_TITLE'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'N',
	'VALUES' => array(
		// personal
		'personal' => GetMessage('CP_BCS_TPL_PERSONAL'),
		// general
		'bestsell' => GetMessage('CP_BCS_TPL_BESTSELLERS'),
		// item2item
		'similar_sell' => GetMessage('CP_BCS_TPL_SOLD_WITH'),
		'similar_view' => GetMessage('CP_BCS_TPL_VIEWED_WITH'),
		'similar' => GetMessage('CP_BCS_TPL_SIMILAR'),
		// randomly distributed
		'any_similar' => GetMessage('CP_BCS_TPL_SIMILAR_ANY'),
		'any_personal' => GetMessage('CP_BCS_TPL_PERSONAL_WBEST'),
		'any' => GetMessage('CP_BCS_TPL_RAND')
	),
	'DEFAULT' => 'personal'
);
$arTemplateParameters['RCM_PROD_ID'] = array(
	'PARENT' => 'BIG_DATA_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_ID_PARAM'),
	'TYPE' => 'STRING',
	'DEFAULT' => '={$_REQUEST["PRODUCT_ID"]}'
);
$arTemplateParameters['SHOW_FROM_SECTION'] = array(
	'PARENT' => 'BIG_DATA_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_SHOW_FROM_SECTION'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);
$arTemplateParameters['USE_ENHANCED_ECOMMERCE'] = array(
	'PARENT' => 'ANALYTICS_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_USE_ENHANCED_ECOMMERCE'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['USE_ENHANCED_ECOMMERCE']) && $arCurrentValues['USE_ENHANCED_ECOMMERCE'] === 'Y')
{
	$arTemplateParameters['DATA_LAYER_NAME'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_DATA_LAYER_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'dataLayer'
	);
	$arTemplateParameters['BRAND_PROPERTY'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_BRAND_PROPERTY'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'DEFAULT' => '',
		'VALUES' => $defaultValue + $arAllPropList
	);
}

$arTemplateParameters['SHOW_OLD_PRICE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('RS_MM_SHOW_OLD_PRICE'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$arTemplateView = array(
	'default' => 'default',
	'popup' => 'popup',
	// 'scroll' => 'scroll',
);

$arTemplateParameters['TEMPLATE_VIEW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('RS_MM_TEMPLATE_VIEW'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'N',
	'DEFAULT' => 'default',
	'VALUES' => $arTemplateView
);

$arTemplateParameters['PRODUCT_PREVIEW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('RS_MM_PRODUCT_PREVIEW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);

$arTemplateParameters['BACKGROUND_COLOR'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('RS_MM_BACKGROUND_COLOR'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'N',
	'DEFAULT' => '-',
	'ADDITIONAL_VALUES' => 'Y',
	'VALUES' => array_merge($defaultValue, $arSProperty_LNS)
);

$arTemplateParameters['DISPLAY_PREVIEW_TEXT'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => Loc::getMessage('RS_MM_DISPLAY_PREVIEW_TEXT'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'Y',
);

if ($arCurrentValues['DISPLAY_PREVIEW_TEXT'] == 'Y')
{
	$arTemplateParameters['PREVIEW_TRUNCATE_LEN'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('RS_MM_PREVIEW_TRUNCATE_LEN'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	);
}

$arTemplateParameters['USE_VOTE_RATING'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('RS_MM_USE_VOTE_RATING'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);

if (isset($arCurrentValues['USE_VOTE_RATING']) && 'Y' == $arCurrentValues['USE_VOTE_RATING'])
{
	$arTemplateParameters['VOTE_DISPLAY_AS_RATING'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('RS_MM_VOTE_DISPLAY_AS_RATING'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'rating' => GetMessage('RS_MM_DVDAR_RATING'),
			'vote_avg' => GetMessage('RS_MM_DVDAR_AVERAGE'),
		),
		'DEFAULT' => 'rating'
	);

	$arTemplateParameters['SHOW_RATING'] = array(
		"NAME" => GetMessage("RS_MM_SHOW_RATING"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);
}

if (ModuleManager::isModuleInstalled('redsign.favorite'))
{
	$arTemplateParameters['USE_FAVORITE'] = array(
		'NAME' => getMessage('RS_MM_USE_FAVORITE'),
		'TYPE' => 'CHECKBOX',
		'MULTIPLE' => 'N',
		'VALUE' => 'Y',
		'DEFAULT' =>'N',
		'REFRESH'=> 'Y',
	);

	if ($arCurrentValues['USE_FAVORITE'] == 'Y')
	{
		$arTemplateParameters['FAVORITE_COUNT_PROP'] = array(
			'NAME' => getMessage('RS_MM_FAVORITE_COUNT_PROP'),
			'TYPE' => 'LIST',
			'VALUES' => $defaultValue + $arAllPropList,
			'DEFAULT' => '-',
		);
/*
		$arTemplateParameters['MESS_BTN_FAVORITE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => getMessage('RS_MM_MESS_BTN_FAVORITE'),
			'TYPE' => 'STRING',
			'DEFAULT' => getMessage('RS_MM_MESS_BTN_FAVORITE_DEFAULT'),
		);
*/
	}
}

if ($bMegamartInclude)
{
	\Redsign\Megamart\Layouts\Builder::createTemplateParams($arTemplateParameters, $arCurrentValues);
}
