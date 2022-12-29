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

if ($showDisplayProperties || $arResult['SHOW_OFFERS_PROPS'])
{
	$iDisplayPropCount = 0;
	?>
	<div class="product-detail-properties">
		<?
		if ($showDisplayProperties)
		{
			?>
			<dl class="product-cat-properties">
				<?
				foreach ($arDisplayProperties as $property)
				{
					if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']]))
					{
						?>
						<dt><?=$property['NAME']?>:</dt>
						<dd><?=(is_array($property['DISPLAY_VALUE'])
								? implode(' / ', $property['DISPLAY_VALUE'])
								: $property['DISPLAY_VALUE'])?>
						</dd>
						<?
						$iDisplayPropCount++;
					}
				}
				unset($property);
				?>
			</dl>
			<?
		}

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			?>
			<dl class="product-cat-properties" id="<?=$itemIds['DISPLAY_MAIN_PROP_DIV']?>"></dl>
			<?
		}
		?>

		<?php if ($iDisplayPropCount > 0): ?>
			<div class="mt-3">
				<a class="js-link-scroll" href="#<?=$mainId?>-props-tab"><?=Loc::getMessage('RS_MM_BCE_CATALOG_ALL_PROPS')?></a>
			</div>
		<?php endif; ?>
	</div>
	<?
}
