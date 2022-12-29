<?php

use Bitrix\Iblock\PropertyTable;

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

$sBrandPropCode = $arParams['BRAND_PROP'][$arResult['IBLOCK_ID']];
$sBrandCode = is_array($arResult['PROPERTIES'][$sBrandPropCode]['VALUE'])
	? reset($arResult['PROPERTIES'][$sBrandPropCode]['VALUE'])
	: $arResult['PROPERTIES'][$sBrandPropCode]['VALUE'];

if (isset($arResult['BRANDS'][$sBrandCode]))
{
	$sBrandUrl = !empty($arResult['BRANDS'][$sBrandCode])
		? $arResult['BRANDS'][$sBrandCode]['DETAIL_PAGE_URL']
		: $arResult['PROPERTIES'][$sBrandPropCode]['FILTER_URL'];
	?>
	<a class="d-flex align-items-center py-2" href="<?=$sBrandUrl?>">
		<?php
		if ($arResult['BRANDS'][$sBrandCode]['PREVIEW_PICTURE'])
		{
			?>
			<img src="<?=$arResult['BRANDS'][$sBrandCode]['PREVIEW_PICTURE']['RESIZE']['src']?>" alt="<?=$arResult['BRANDS'][$sBrandCode]['PREVIEW_PICTURE']['ALT']?>">
			<?php
		}
		else
		{
			if ($arResult['PROPERTIES'][$sBrandPropCode]['PROPERTY_TYPE'] == PropertyTable::TYPE_ELEMENT)
			{
				echo $arResult['BRANDS'][$sBrandCode]['NAME'];
			}
			else
			{
				echo !empty($arResult['DISPLAY_PROPERTIES'][$sBrandPropCode]['DISPLAY_VALUE'])
					? $arResult['DISPLAY_PROPERTIES'][$sBrandPropCode]['DISPLAY_VALUE']
					: $sBrandCode;
			}
		}
		?>
	</a>
	<?php
}
