<?php

use Bitrix\Main\Loader;
use Redsign\MegaMart\ParametersUtils;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if (Loader::includeModule('redsign.megamart'))
{
	$arParams['GRID_RESPONSIVE_SETTINGS'] = ParametersUtils::prepareGridSettings($arParams['~GRID_RESPONSIVE_SETTINGS']);
}

if (Loader::includeModule('iblock'))
{
	if ($arResult['SECTION']['ID'] <= 0 && $arParams['DISPLAY_SECTION_DESCRIPTION'] != 'N')
	{
		$arOrder = [];
		$arFilter = [
			'TYPE' => $arParams['IBLOCK_TYPE'],
			'ID' => $arParams['IBLOCK_ID'],
		];
		$bIncCnt = false;

		$dbIblock = \CIBlock::getList($arOrder, $arFilter, $bIncCnt);

		if ($arIblock = $dbIblock->getNext())
		{
			$arResult['SECTION']['NAME'] = $arIblock['NAME'];
			$arResult['SECTION']['DESCRIPTION'] = $arIblock['DESCRIPTION'];
		}
		unset($arOrder, $arFilter, $bIncCnt);
	}
}

$arResult['SECTIONS_COUNT'] = (int)$arResult['SECTIONS_COUNT'];

if (!isset($arResult['SECTIONS']) || !is_array($arResult['SECTIONS']))
	$arResult['SECTIONS'] = [];

if (count($arResult['SECTIONS']))
{
	foreach ($arResult['SECTIONS'] as $iSectionKey => $arSection)
	{
		$arResult['SECTIONS'][$iSectionKey]['IS_PARENT'] = false;
		$arResult['SECTIONS'][$iSectionKey]['HAVE_SUBSECTIONS'] = false;
		if (
			intval($arSection['RIGHT_MARGIN']) - intval($arSection['LEFT_MARGIN']) > 1
			&& $arSection['RELATIVE_DEPTH_LEVEL'] < $arParams['TOP_DEPTH']
		)
		{
			$arResult['SECTIONS'][$iSectionKey]['HAVE_SUBSECTIONS'] = true;
			if ($arResult['SECTIONS'][$iSectionKey]['DEPTH_LEVEL'] == 1)
			{
				$arResult['SECTIONS'][$iSectionKey]['IS_PARENT'] = true;
			}
		}
	}
}

if (is_array($arParams['FILTER_IDS']) && count($arParams['FILTER_IDS']) > 0)
{
	$prevLevel = -1;
	for ($i = $arResult['SECTIONS_COUNT'] - 1; $i >= 0; --$i)
	{
		if (in_array($arResult['SECTIONS'][$i]['ID'], $arParams['FILTER_IDS']))
		{
			$prevLevel = $arResult['SECTIONS'][$i]['DEPTH_LEVEL'];
		}
		else
		{
			if ($prevLevel != -1 && $prevLevel > $arResult['SECTIONS'][$i]['DEPTH_LEVEL'])
			{
				$prevLevel = $arResult['SECTIONS'][$i]['DEPTH_LEVEL'];
			}
			elseif ($prevLevel == $arResult['SECTIONS'][$i]['DEPTH_LEVEL'])
			{
				$prevLevel = $arResult['SECTIONS'][$i]['DEPTH_LEVEL'];
				unset($arResult['SECTIONS'][$i]);
			}
			else
			{
				unset($arResult['SECTIONS'][$i]);
				if ($arResult['SECTIONS'][$i]['DEPTH_LEVEL'] == $arResult['SECTION']['DEPTH_LEVEL'] + 1)
				{
					$prevLevel = -1;
				}
			}

		}
	}

	$arResult['SECTIONS'] = array_values($arResult['SECTIONS']);
}
