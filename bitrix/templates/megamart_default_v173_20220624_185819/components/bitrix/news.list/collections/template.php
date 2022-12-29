<?php

use Bitrix\Main\Localization\Loc;

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
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_COLLECTION_ELEMENT_DELETE_CONFIRM'));

$this->setFrameMode(true);
?>
<div class="d-block">
    <?php foreach ($arResult['ITEMS'] as $arItem): ?>
        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn-outline-primary m-2"><?=$arItem['NAME']?></a>
    <?php endforeach; ?>
</div>