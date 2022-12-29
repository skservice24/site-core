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
 * @var array $item
 * @var array $itemIds
 * @var bool $showSlider
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>"
	width="<?=$item['PREVIEW_PICTURE']['WIDTH']?>"
	height="<?=$item['PREVIEW_PICTURE']['HEIGHT']?>"
	alt="<?=$item['PREVIEW_PICTURE']['ALT']?>"
	title="<?=$item['PREVIEW_PICTURE']['TITLE']?>"
	<?=($showSlider ? ' style="display: none;"' : '')?>
	id="<?=$itemIds['PICT']?>"
	class="product-cat-image"
<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
	loading="lazy"
<?php endif; ?>
/>
