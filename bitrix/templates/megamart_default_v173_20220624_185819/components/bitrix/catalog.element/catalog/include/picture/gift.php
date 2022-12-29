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

if ($arParams['USE_GIFTS'] == 'Y' && is_array($arResult['GIFT_ITEMS']) && count($arResult['GIFT_ITEMS']) > 0)
{
	?>
	<span class="product-cat-gift">
		<svg class="product-cat-gift-icon icon-svg"><use xlink:href="#svg-gift"></use></svg>
	</span>
	<?
}