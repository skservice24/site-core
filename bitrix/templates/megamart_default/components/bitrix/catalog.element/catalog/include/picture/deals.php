<?php

use Bitrix\Main\Localization\Loc;

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

if ($haveOffers)
{
	?>
	<span class="product-cat-deals" id="<?=$itemIds['SALE_BANNER']?>" style="display:none">
		<svg class="product-cat-deals-icon icon-svg"><use xlink:href="#svg-alarm"></use></svg>
		<span class="product-cat-deals-name" data-entity="sale-banner-title"></span>
	</span>
	<?
}
else
{
	if (isset($actualItem['DAYSARTICLE']))
	{
		?>
		<span class="product-cat-deals">
			<svg class="product-cat-deals-icon icon-svg"><use xlink:href="#svg-alarm"></use></svg>
			<span class="product-cat-deals-name"><?=Loc::getMessage('RS_MM_BCE_CATALOG_DAYSARTICLE_TITLE')?></span>
		</span>
		<?
	}
	elseif (isset($actualItem['QUICKBUY']))
	{
		?>
		<span class="product-cat-deals">
			<svg class="product-cat-deals-icon icon-svg"><use xlink:href="#svg-alarm"></use></svg>
			<span class="product-cat-deals-name"><?=Loc::getMessage('RS_MM_BCE_CATALOG_QUICKBUY_TITLE')?></span>
		</span>
		<?
	}
}