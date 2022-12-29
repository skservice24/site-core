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
<a class="prodcut-item-detail__cheaper cheaper-link" id="<?=$itemIds['CHEAPER_LINK_ID']?>"
	data-type="ajax" data-fancybox="cheaper"
	title="<?=Loc::getMessage('RS_MM_BCE_CATALOG_LOWER_PRICE')?>"
	href="<?=str_replace('#ELEMENT_ID#', $actualItem['ID'], $arParams['CHEAPER_FORM_URL'])?>">
	<span class="cheaper-link__icon"></span>
	<span class="cheaper-link__text">
		<span class="anchor"><?=Loc::getMessage('RS_MM_BCE_CATALOG_WANT_CHEAPER')?></span>&nbsp;
		<span class="anchor"><?=Loc::getMessage('RS_MM_BCE_CATALOG_LOWER_PRICE')?></span>
	</span>
</a>
<?