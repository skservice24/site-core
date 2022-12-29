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
?>
<div class="product-cat-image-action">
<?php
if (
	$arParams['DISPLAY_COMPARE']
	&& (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
)
{
	?>
	<div class="product-cat-action-container">
		<label class="product-cat-action" id="<?=$itemIds['COMPARE_LINK']?>">
			<input type="checkbox" data-entity="compare-checkbox">
			<?/*<span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>*/?>
			<svg class="product-cat-action-icon icon-svg"><use xlink:href="#svg-copy"></use></svg>
		</label>
	</div>
	<?
}
?>


<?php
if ($arParams['USE_FAVORITE'] == 'Y')
{
	?>
	<div class="product-cat-action-container">
		<label class="product-cat-action" id="<?=$itemIds['FAVORITE_LINK']?>">
			<svg class="product-cat-action-icon icon-svg"><use xlink:href="#svg-heart"></use></svg>
		</label>
	</div>
	<?php
}
?>
</div>