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
?>
<div class="row row-borders">
	<?php
	foreach ($arResult['PROPERTIES'][$sPropCode]['VALUE'] as $arFile)
	{
		?>
		<div class="col-12">
			<div class="doc row align-items-center px-5 py-6">
				<div class="col-3 text-center">

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
				</div>
				<div class="col">
					<div class="doc__name">
						<?=($arFile['DESCRIPTION'] == '' ? $arFile['ORIGINAL_NAME'] : $arFile['DESCRIPTION'])?>
					</div>
					<a class="btn-link font-size-sm" href="<?=$arFile['FULL_PATH']?>" target="_blank" download>
						<?php
						echo Loc::getMessage('RS_MM_BCE_CATALOG_DOWNLOAD_FILE').': ';

						if ($arFile['FILE_EXT'] != '')
						{
							echo mb_strtoupper($arFile['FILE_EXT']).', ';
						}
						echo $arFile['SIZE'];
						?>
					</a>
				</div>
			</div>
		</div>
		<?php
	}
	unset($arFile);
	?>
</div>
