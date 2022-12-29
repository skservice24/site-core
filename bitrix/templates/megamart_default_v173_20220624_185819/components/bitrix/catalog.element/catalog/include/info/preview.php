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

if ($showPreviewText)
{
	$displayPreviewText = $previewText != ''
		&& (
			$arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
			|| ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $actualItem['DETAIL_TEXT'] == '')
		);
	?>
	<div class="font-size-sm text-extra"<?php if (!$displayPreviewText): ?> style="display:none"<?php endif; ?>>

		<div id="<?=$itemIds['PREVIEW_TEXT_ID']?>">
			<?php
			if ($displayPreviewText)
			{
				echo $previewTextType === 'html' ? $previewText : $previewText;
			}
			?>
		</div>
		<a class="js-link-scroll" href="#<?=$mainId?>-descr-tab"><?=Loc::getMessage('RS_MM_BCE_CATALOG_MORE_INFO')?></a>
	</div>
	<?php
}
