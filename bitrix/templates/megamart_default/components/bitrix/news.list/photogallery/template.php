<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$this->setFrameMode(true);

if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y')
{
	UI\Extension::load([
		'main.lazyload',
	]);
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_PHOTOGALLERY_ELEMENT_DELETE_CONFIRM'));

$sectionTitle = (
    isset($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
    ? $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
    : $arResult['NAME']
);

$sBlockId = 'gallery_'.$this->randString(10);

if (!empty($arResult['ITEMS'])):
?>
<div id="<?=$sBlockId?>">
	<div class="row text-center text-lg-left">
		<?php
		foreach ($arResult['ITEMS'] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);

			$arEmptyImage = [
				'SRC' => $templateFolder.'images/no-image.png',
				'WIDTH' => '',
				'HEIGHT' => '',
			];

			$arPreviewPic = is_array($arItem['PREVIEW_PICTURE'])
				? $arItem['PREVIEW_PICTURE']
				: $arEmptyImage;

			$arDetailPic = is_array($arItem['DETAIL_PICTURE'])
				? $arItem['DETAIL_PICTURE']
				: $arEmptyImage;

			$imgTitle = isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
				? $itearItemm['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
				: $arItem['NAME'];

			$imgAlt = isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] != ''
				? $itearItemm['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']
				: $arItem['NAME'];

			$sPreviewText = isset($arItem['PREVIEW_TEXT'])
				? HTMLToTxt($arItem['PREVIEW_TEXT'])
				: '';
			?>
			<div class="col-lg-4 col-md-4 col-xs-6">
				<figure class="photogallery-figure" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

					<img src="<?=$arPreviewPic['SRC']?>"
						width="<?=$arPreviewPic['WIDTH']?>"
						height="<?=$arPreviewPic['HEIGHT']?>"
						alt="<?=$imgAlt?>" title="<?=$imgTitle?>"
						class="img-fluid"
					<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
						loading="lazy"
					<?php endif; ?>
					/>

					<a href="<?=$arDetailPic['SRC']?>" class="photogallery-figure__link" data-fancybox="images"<?php if ($arItem['PREVIEW_TEXT']): ?> data-caption="<?=$sPreviewText?>"<?php endif; ?>></a>
				</figure>
			</div>
			<?php
		}
		?>
	</div>
</div>
<?php
endif;
