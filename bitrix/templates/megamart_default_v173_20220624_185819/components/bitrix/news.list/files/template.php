<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI;

/**
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
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
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_FILES_ELEMENT_DELETE_CONFIRM'));

$this->setFrameMode(true);

$sectionTitle = (
    isset($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
    ? $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
    : $arResult['NAME']
);

$sBlockId = 'files_'.$this->randString(10);
?>
<div id="<?=$sBlockId?>">
	<?php
	if (count($arResult['ITEMS']) > 0)
	{
		$sTemplatePath = $_SERVER['DOCUMENT_ROOT'].$templateFolder.'/templates/'.$arParams['RS_TEMPLATE'].'.php';
		if (file_exists($sTemplatePath))
		{
			include $sTemplatePath;
		}
	}
	else
	{
		include $templateFolder.'/templates/no_items.php';
	}
	?>
</div>
