<?php

use Bitrix\Main\Localization\Loc;
use Redsign\MegaMart\MyTemplate;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

$this->setFrameMode(true);

$strSectionEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_EDIT');
$strSectionDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_DELETE');
$arSectionDeleteParams = array('CONFIRM' => Loc::getMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

$sectionTitle = (
    isset($arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
    ? $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
    : $arResult['SECTION']['NAME']
);


$path = null;
switch ($arParams['VIEW_MODE'])
{
    case 'buttons':
        $path = $templateFolder.'/include/buttons.php';
        break;
    case 'blocks':
        $path = $templateFolder.'/include/blocks.php';
        break;
    case 'links':
        $path = $templateFolder.'/include/links.php';
        break;
    case 'lines':
        $path = $templateFolder.'/include/lines.php';
        break;
}

if ($path)
{
    include(MyTemplate::getTemplatePart($path));
}


$pathBuffer = null;
switch ($arParams['VIEW_MODE_BUFFER'])
{
    case 'buttons':
        $pathBuffer = $templateFolder.'/include/buttons.php';
        break;
    case 'blocks':
        $pathBuffer = $templateFolder.'/include/blocks.php';
        break;
    case 'links':
        $pathBuffer = $templateFolder.'/include/links.php';
        break;
    case 'lines':
        $pathBuffer = $templateFolder.'/include/lines.php';
        break;
}

$this->SetViewTarget('site_catalog_section_list_buffer');
if ($pathBuffer)
{
    include(MyTemplate::getTemplatePart($pathBuffer));
}
$this->EndViewTarget();
