<?php

use Bitrix\Main\Localization\Loc;
use Redsign\MegaMart\MyTemplate;

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

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_BRANDS_ELEMENT_DELETE_CONFIRM'));

$this->setFrameMode(true);

$sectionTitle = (
    isset($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
    ? $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
    : $arResult['NAME']
);

$this->setFrameMode(true);

$sBlockId = 'rs-brands-'.$this->randString(5);

if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)
{
	include(MyTemplate::getTemplatePart($templateFolder.'/templates/'.mb_strtolower($arParams['RS_TEMPLATE']).'.php'));
}
