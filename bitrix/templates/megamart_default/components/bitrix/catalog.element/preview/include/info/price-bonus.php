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

$priceCode = array_search($price['PRICE_TYPE_ID'], array_column($arResult['CAT_PRICES'], 'ID', 'CODE'));

if ($arParams['SHOW_CASHBACK'] == 'Y')
{
	?>
	<div class="product-detail-cashback mt-3 mb-4 py-2" id="<?=$itemIds['PRICE_BONUS']?>" data-entity="cashback"<?=($price['RATIO_BONUS'] > 0 ? '' : ' style="display:none;"')?>>
		<img class="product-detail-cashback-icon mr-2 mb-1" src="<?=$this->GetFolder().'/images/coins.png?v3'?>" alt="">
		<span class="text-nowrap"><?=Loc::getMessage('RS_MM_BCE_PREVIEW_CASHBACK_TITLE');?>: <span class="text-primary font-weight-bold" data-entity="cashback-value"><?=$price['PRINT_RATIO_BONUS']?></span></span>
	</div>
	<?
}
