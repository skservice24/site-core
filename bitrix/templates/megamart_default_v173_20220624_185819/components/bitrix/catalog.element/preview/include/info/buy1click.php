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

if ($showBuy1ClickBtn)
{
	?>
	<a class="btn <?=$buy1ClickButtonClassName?> w-100"
		id="<?=$itemIds['BUY1CLICK_LINK']?>"
		href="<?=str_replace('#ELEMENT_ID#', $actualItem['ID'], $arParams['LINK_BUY1CLICK'])?>" rel="nofollow">
		<span><?=$arParams['MESS_BTN_BUY1CLICK']?></span>
	</a>
	<?
}
