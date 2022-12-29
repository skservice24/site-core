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

$priceCode = array_search($price['PRICE_TYPE_ID'], array_column($arResult['CAT_PRICES'], 'ID', 'CODE'));
$showDiscount = $price['RATIO_PRICE'] < $price['RATIO_BASE_PRICE'];

/*
<div class="product-detail-price-title small text-extra w-100 mb--2">
	<?php
	if ($arResult['CAT_PRICES'][$priceCode]['TITLE'] != '') {
		echo $arResult['CAT_PRICES'][$priceCode]['TITLE'];
	} else {
		echo Loc::getMessage('RS_MM_BCE_PREVIEW_PRICE');
	}
	?>:
</div>
*/
?>
<div class="text-nowrap">
	<span class="product-detail-price-current product-cat-price-current<?=($showDiscount ? ' discount' : '')?>"<?/*id="<?=$mainId.'_old_price_'.$price['PRICE_TYPE_ID']?>"*/?> data-entity="price-current">
		<?php
		if (!empty($price)) {
			echo $price['PRINT_RATIO_PRICE'];
		} else {
			echo Loc::getMessage('RS_MM_BCE_PREVIEW_NO_PRICE');
		}
		?>
	</span>

	<?
	if ($arParams['SHOW_OLD_PRICE'] === 'Y')
	{
		?>
		<span class="product-detail-price-old product-cat-price-old"<?/*id="<?=$mainId.'_price_'.$price['PRICE_TYPE_ID']?>"*/?>
			<?=($showDiscount ? '' : ' style="display:none;"')?> data-entity="price-full">
			<?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
		</span>
		<?
	}
	?>
</div>

<?
if ($arParams['SHOW_OLD_PRICE'] === 'Y')
{
	?>
	<div class="product-detail-price-economy product-cat-price-economy"<?/* id="<?=$mainId.'_price_discount_'.$price['PRICE_TYPE_ID']?>"*/?>
		<?=($showDiscount ? '' : ' style="display:none;"')?> data-entity="price-discount">
		<?
		if ($showDiscount)
		{
			echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
		}
		?>
	</div>
	<?
}
