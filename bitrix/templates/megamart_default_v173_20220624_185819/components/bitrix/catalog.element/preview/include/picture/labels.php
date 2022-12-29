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

if ($arResult['LABEL'] || $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
{
	?>
	<span class="product-cat-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>">
		<?
		if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
		{
			?>
			<span class="product-cat-label-text-item" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
				style="display:<?=($price['PERCENT'] > 0 ? '' : 'none')?>;">
				<?=-$price['PERCENT']?>%
			</span>
			<?
		}
		if (!empty($arResult['LABEL_ARRAY_VALUE']))
		{
			foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value)
			{
				$sLabelStyle = '';
				if (mb_substr($arResult['PROPERTIES'][$code]['VALUE_XML_ID'], 0, 1) == '#') {
					$sLabelStyle = ' style="background:'.$arResult['PROPERTIES'][$code]['VALUE_XML_ID'].'"';
				}
				?>
				<span class="product-cat-label-text-item<?=(!isset($arResult['LABEL_PROP_MOBILE'][$code]) ? ' hidden-xs' : '')?>"<?if ($sLabelStyle != ''){ echo $sLabelStyle; }?> title=" <?=$value?>">
					<?=$value?>
				</span>
				<?
			}
		}
		?>
	</span>
	<?
}
?>