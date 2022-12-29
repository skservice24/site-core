<?php

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogItemComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var array $itemIds
 * @var array $morePhoto
 * @var bool $showSlider
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<span class="product-cat-image-slider slide" id="<?=$itemIds['PICT_SLIDER']?>"
	<?=($showSlider ? '' : 'style="display: none;"')?>>
	<?
	if ($showSlider)
	{
		foreach ($morePhoto as $key => $photo)
		{
			if ($key > $arParams['SLIDER_SLIDE_COUNT'] - 1)
				break;
			?>
			<span class="product-cat-image-slide item<?=($key == 0 ? ' active' : '')?>">
				<img src="<?=$photo['SRC']?>"
					width="<?=$photo['WIDTH']?>"
					height="<?=$photo['HEIGHT']?>"
					alt=""
					class="product-cat-image"
				<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
					loading="lazy"
				<?php endif; ?>
				/>
				<?php
				if ($key > $arParams['SLIDER_SLIDE_COUNT'] - 2 && count($morePhoto) > $arParams['SLIDER_SLIDE_COUNT'])
				{
					?>
					<span class="product-cat-image-slider-more">
						<span class="product-cat-image-slider-more-wrapper">
							<span class="product-cat-image-slider-more-icon">
								<svg class="icon-svg"><use xlink:href="#svg-camera"></use></svg>
							</span>
							<span class="product-cat-image-slider-more-text">
								<?=Loc::getMessage('RS_MM_BCI_CATALOG_SLIDER_MORE_MESSAGE',  array('#NUMBER#' => count($morePhoto) - $arParams['SLIDER_SLIDE_COUNT']))?>
							</span>
						</span>
					</span>
					<?php
				}
				?>
			</span>
			<?php
		}
	}
	?>
</span>

<span class="product-cat-image-slider-control-container" id="<?=$itemIds['PICT_SLIDER']?>_indicator"
	<?=($showSlider ? '' : 'style="display: none;"')?>>
	<?
	if ($showSlider)
	{
		foreach ($morePhoto as $key => $photo)
		{
			?>
			<span class="product-cat-image-slider-control<?=($key == 0 ? ' active' : '')?>" data-go-to="<?=$key?>"></span>
			<?php
			if ($key >=  $arParams['SLIDER_SLIDE_COUNT'] - 1)
			{
				break;
			}
		}
	}
	?>
</span>