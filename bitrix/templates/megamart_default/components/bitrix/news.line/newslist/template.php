<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$this->setFrameMode(true);

if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y')
{
	UI\Extension::load([
		'main.lazyload',
	]);
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_NEWSLIST_ELEMENT_DELETE_CONFIRM'));

if (count($arResult['ITEMS']) > 0)
{
	$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
	$layout->addModifier('bg-lg');

	$layout->start();

	if (file_exists($arResult['TEMPLATE_PATH']))
	{
		include($arResult['TEMPLATE_PATH']);
	}

	$layout->end();
}
