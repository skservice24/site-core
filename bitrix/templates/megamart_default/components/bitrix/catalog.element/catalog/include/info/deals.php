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

if (is_array($arResult['PRODUCT_DEALS']) && count($arResult['PRODUCT_DEALS']) > 0)
{
	foreach ($arResult['PRODUCT_DEALS'] as $arDeal)
	{
		?>
		<div class="product-detail-sale">
			<img class="product-detail-sale-icon" src="<?=$this->GetFolder().'/images/flame.png'?>" alt="">
			<div class="product-detail-sale-body">
				<div class="product-detail-sale-title"><?=Loc::getMessage('RS_MM_BCE_CATALOG_PRODUCT_DEAL')?></div>
				<a class="product-detail-sale-name" href="<?=$arDeal['DETAIL_PAGE_URL']?>"><?=$arDeal['NAME']?></a>
			</div>
		</div>
		<?php
	}
	unset($arDeal);
}
