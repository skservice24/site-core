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
<div class="row row-borders">
	<?php
	foreach ($arResult['PROPERTIES'][$sPropCode]['VALUE'] as $arFile)
	{
		?>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
			<div class="doc px-5 py-6">

				<?php
				if (CFile::IsImage($arFile['FILE_NAME'], $arFile['CONTENT_TYPE']))
				{
					$resizeImage = CFile::ResizeImageGet(
						$arFile['ID'],
						array('width' => 200, 'height' => 200),
						BX_RESIZE_IMAGE_PROPORTIONAL,
						true
					);
					?>
					<a class="doc__preview fancybox-zoom" href="<?=$arFile['FULL_PATH']?>" data-fancybox="<?=$sPropCode?>" data-caption="<?=($arFile['DESCRIPTION'] == '' ? $arFile['ORIGINAL_NAME'] : $arFile['DESCRIPTION'])?>">
						<img src="<?=$resizeImage['src']?>"
							width="<?=$resizeImage['width']?>"
							height="<?=$resizeImage['height']?>"
							alt="<?=$arFile['DESCRIPTION']?>"
							class="img-fluid"
						<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
							loading="lazy"
						<?php endif; ?>
						/>
					</a>
					<?php
					unset($resizeImage);
				}
				else
				{
					?>
					<a class="doc__preview" href="<?=$arFile['FULL_PATH']?>" download>
						<img class="img-fluid" src="<?=$templateFolder?>/images/file.png">
					</a>
					<?
				}
				?>

				<div class="doc__name">
					<?=($arFile['DESCRIPTION'] == '' ? $arFile['ORIGINAL_NAME'] : $arFile['DESCRIPTION'])?>
				</div>
			</div>
		</div>
		<?php
	}
	unset($arFile);
	?>
</div>
