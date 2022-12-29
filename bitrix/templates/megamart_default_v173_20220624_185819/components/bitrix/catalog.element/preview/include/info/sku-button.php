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
<li class="product-cat-scu-item-text-container btn btn-outline-secondary btn-sm" title="<?=$value['NAME']?>"
	data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
	<div class="product-cat-scu-item-text-block">
		<div class="product-cat-scu-item-text"><?=$value['NAME']?></div>
	</div>
</li>