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

if ($showAddBtn)
{
	?>
	<a class="btn <?=$showButtonClassName?> product-detail-buy-button mb-4"
	   id="<?=$itemIds['ADD_BASKET_LINK']?>"
	   href="javascript:void(0);"><span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span></a>
	<?
}

if ($showBuyBtn)
{
	?>
	<a class="btn <?=$buyButtonClassName?> product-detail-buy-button mb-4"
	   id="<?=$itemIds['BUY_LINK']?>"
	   href="javascript:void(0);"><span><?=$arParams['MESS_BTN_BUY']?></span></a>
	<?
}

if ($showRequestBtn)
{
    ?>
        <a class="btn <?=$requestButtonClassName?> product-detail-buy-button mb-4" id="<?=$itemIds['ACTION_REQUEST_LINK']?>"
            data-type="ajax" data-fancybox="request"
            href="<?=str_replace('#ELEMENT_ID#', $actualItem['ID'], $arParams['LINK_BTN_REQUEST'])?>">
            <span><?=$arParams['MESS_BTN_REQUEST']?></span>
        </a>
    <?
}
