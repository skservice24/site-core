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
		if ($showSliderControls)
		{
			?>
			<a href="<?=$arResult['DETAIL_PAGE_URL']?>">
				<?php
				if ($haveOffers)
				{
					?>
					<div class="product-cat-image-slider-control-container" id="<?=$itemIds['SLIDER_CONT_ID']?>">
						<?
						foreach ($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['MORE_PHOTO'] as $key => $photo)
						{
							if ($key > $arParams['SLIDER_SLIDE_COUNT'] - 1)
								break;
							?>
							<div class="product-cat-image-slider-control<?=($key == 0 ? ' active' : '')?>" data-entity="slider-control" data-go-to="<?=$key?>"></div>
							<?
						}
						?>
					</div>
					<?
				}
				else
				{
					?>
					<div class="product-cat-image-slider-control-container" id="<?=$itemIds['SLIDER_CONT_ID']?>">
						<?
						if (!empty($actualItem['MORE_PHOTO']))
						{
							foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
							{
								if ($key > $arParams['SLIDER_SLIDE_COUNT'] - 1)
									break;
								?>
								<div class="product-cat-image-slider-control<?=($key == 0 ? ' active' : '')?>" data-entity="slider-control" data-go-to="<?=$key?>"></div>
								<?
							}
						}
						?>
					</div>
					<?
				}
				?>
			</a>
			<?php
		}
	}
}
