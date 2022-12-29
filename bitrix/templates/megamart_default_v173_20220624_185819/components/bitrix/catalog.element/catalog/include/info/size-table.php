<?php

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if ($arParams['SHOW_SIZE_TABLE'] == 'Y' && !empty($arResult['SIZE_TABLE']))
{
    ?>
    <div id="<?=$itemIds['SIZE_TABLE']?>" style="display:none"><?=$arResult['SIZE_TABLE']['PREVIEW_TEXT']?></div>
    <?php
}