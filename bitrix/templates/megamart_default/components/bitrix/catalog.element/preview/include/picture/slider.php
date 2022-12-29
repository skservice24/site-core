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

$arSliderOptions = array(
	'margin' => 0,
	'nav' => true,
/*
	'navClass' => array('owl-prev', 'owl-next'),
	'navText' => array(
		'<svg class="icon-svg icon-svg-chevron-left"><use xlink:href="#svg-chevron-left"></use></svg>',
		'<svg class="icon-svg icon-svg-chevron-right"><use xlink:href="#svg-chevron-right"></use></svg>'
	),
*/
	'dots' => true,
	'dotsData' => true,
	'dotsContainer' => '#'.$itemIds['BIG_SLIDER_DOTS_ID'],
	'items' => 1,
	'responsive' => array(),
);

if (!empty($actualItem['MORE_PHOTO']))
{
	if (is_array($actualItem['MORE_PHOTO']) && count($actualItem['MORE_PHOTO']) > 0)
	{
		?>
		<div class="product-detail-slider-images-container product-cat-image-slider slide" data-entity="images-container">
			<?php
			foreach ($actualItem['MORE_PHOTO'] as $key => $arPhoto)
			{
				if ($key > $arParams['SLIDER_SLIDE_COUNT'] - 1)
					break;
				?>
				<span class="product-cat-image-slide item<?=($key == 0 ? ' active' : '')?>" data-entity="image">
					<?php

					if (isset($arPhoto['RESIZE']['big']['src']))
					{
						$arPhoto['SRC'] = $arPhoto['RESIZE']['big']['src'];
						$arPhoto['WIDTH'] = $arPhoto['RESIZE']['big']['width'];
						$arPhoto['HEIGHT'] = $arPhoto['RESIZE']['big']['height'];
					}
					?>

					<img src="<?=$arPhoto['SRC']?>"
						width="<?=$arPhoto['WIDTH']?>"
						height="<?=$arPhoto['HEIGHT']?>"
						alt="<?=$alt?>" title="<?=$title?>"
						<?=($key == 0 ? ' itemprop="image"' : '')?>
						class="product-cat-image"
					<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
						loading="lazy"
					<?php endif; ?>
					/>

					<?php
					if ($key > $arParams['SLIDER_SLIDE_COUNT'] - 2 && count($actualItem['MORE_PHOTO']) > $arParams['SLIDER_SLIDE_COUNT'])
					{
						?>
						<span class="product-cat-image-slider-more">
							<span class="product-cat-image-slider-more-wrapper">
								<span class="product-cat-image-slider-more-icon">
									<svg class="icon-svg"><use xlink:href="#svg-camera"></use></svg>
								</span>
								<span class="product-cat-image-slider-more-text">
									<?=Loc::getMessage('RS_MM_BCI_CATALOG_SLIDER_MORE_MESSAGE',  array('#NUMBER#' => count($actualItem['MORE_PHOTO']) - $arParams['SLIDER_SLIDE_COUNT']))?>
								</span>
							</span>
						</span>
						<?php
					}
					?>
				</span>
			<?php
			}
			?>
		</div>
		<?php
	}
}
