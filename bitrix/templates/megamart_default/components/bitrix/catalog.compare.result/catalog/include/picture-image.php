<?php

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var array $arPicture
 * @var string $productAlt
 * @var string $productTitle
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<img src="<?=$arPicture['SRC']?>"
	width="<?=$arPicture['WIDTH']?>"
	height="<?=$arPicture['HEIGHT']?>"
	alt="<?=$productAlt?>"
	title="<?=$productTitle?>"
<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
	class="product-cat-image lazy-anim-img" loading="lazy"
<?php else: ?>
	class="product-cat-image"
<?php endif; ?>
/>