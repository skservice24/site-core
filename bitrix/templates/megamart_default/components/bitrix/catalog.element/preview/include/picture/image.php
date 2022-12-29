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
		?>
		<div class="product-detail-slider-images-container show-items-1"
			data-entity="images-container" data-slider="<?=$itemIds['BIG_SLIDER_ID']?>" data-slider-options="<?=htmlspecialcharsbx(\Bitrix\Main\Web\Json::encode($arSliderOptions))?>"
		>
			<?php
			$iSlideIndex = 0;

			foreach ($actualItem['MORE_PHOTO'] as $key => $arPicture)
			{
				$arThumb = $arPicture;
				if (isset($arPicture['RESIZE']['small']['src']))
				{
					$arThumb['SRC'] = $arPicture['RESIZE']['small']['src'];
					$arThumb['WIDTH'] = $arPicture['RESIZE']['small']['width'];
					$arThumb['HEIGHT'] = $arPicture['RESIZE']['small']['height'];
				}
				?>
				<span class="product-detail-slider-image"
					data-fancybox="gallery"
					data-caption="<?=$strTitle?>"
					data-src="<?=$arPicture['SRC']?>"
					data-entity="image"
					data-index="<?=$iSlideIndex++?>"
					data-options='{"slideShow" : false}'
					data-dot="<?=htmlspecialcharsbx('<button class="owl-preview" style="background-image:url(\''.$arThumb['SRC'].'\')"></button>')?>"
				><?php
					if (isset($arPicture['RESIZE']['big']['src']))
					{
						$arPicture['SRC'] = $arPicture['RESIZE']['big']['src'];
						$arPicture['WIDTH'] = $arPicture['RESIZE']['big']['width'];
						$arPicture['HEIGHT'] = $arPicture['RESIZE']['big']['height'];
					}
					?><img src="<?=$arPicture['SRC']?>"
						width="<?=$arPicture['WIDTH']?>"
						height="<?=$arPicture['HEIGHT']?>"
						alt="<?=$alt?>"
						title="<?=$title?>"
						<?=($key == 0 ? ' itemprop="image"' : '')?>
					<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
						loading="lazy"
					<?php endif; ?>
					/><?php
				?></span>
				<?php
			}
			unset($arThumb, $arPicture, $key);

			if (!empty($arResult['DISPLAY_PROPERTIES']['HTML_VIDEO']['VALUE']['TEXT']))
			{
				?>
				<span class="product-detail-slider-image"
					data-fancybox="gallery"
					data-caption="<?=$strTitle?>"
					data-src="<?=$arResult['DISPLAY_PROPERTIES']['HTML_VIDEO']['VALUE']['TEXT']?>"
					data-index="<?=$iSlideIndex++?>"
					data-options='{"slideShow" : false}'
					data-dot="<?=htmlspecialcharsbx('<button class="owl-preview" style="background-image:url(\''.$templateFolder.'/images/play_icon.png"\')"></button>')?>"
				><?php
					?><img src="<?=$templateFolder?>/images/play_icon_652.png"
						width="652" height="652" alt="<?=$alt?>"
					<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
						loading="lazy"
					<?php endif; ?>
						/><?php
					?></span>
				<?php
			}
			?>
		</div>
		<?php
	}
}
