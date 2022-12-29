<?php

use Bitrix\Main\Localization\Loc;

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

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_VACANCIES_ELEMENT_DELETE_CONFIRM'));

$sectionTitle = (
    isset($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
    ? $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
    : $arResult['NAME']
);

if (count($arResult['ITEMS']) > 0):
	$sBlockId = 'vacancies_'.$this->randString(5);
?>
<div class="b-vacancies js-vacancies">
	<?php if (isset($arResult['FILTER']['VALUES'])): ?>
	<div class="nav-container">
	<div class="nav-wrap">
		<ul class="nav nav-slide" id="<?=$sBlockId?>_filter">
			<?php foreach ($arResult['FILTER']['VALUES'] as $arFilter): ?>
				<li class="nav-item">
					<button class="btn btn-link nav-link" data-filter="<?=$arFilter['XML_ID']?>">
						<span><?=$arFilter['VALUE']?></span>
					</button>
				</li>
			<?php endforeach; ?>

			<li class="nav-item ">
				<button class="btn btn-link nav-link active" data-filter><span><?=Loc::getMessage('RS_MM_NL_TPL_VACANCIES_FILTER_ALL');?></span></button>
			</li>
		</ul>
	</div>
	</div>
	<?php endif; ?>

	<div class="accordion mt-5" id="<?=$sBlockId?>_accordion">
		<?php
		foreach ($arResult['ITEMS'] as $index => $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
			$sItemId = $this->GetEditAreaId($arItem['ID']);
			?>
			<div class="card" id="<?=$sItemId;?>" data-type="<?=$arItem['DISPLAY_PROPERTIES'][$arParams['RS_TYPE_PROPERTY']]['VALUE_XML_ID']?>" data-code="<?=$arItem['CODE']?>">
				<div class="card-header">
					<button class="btn btn-link card-header-link" id="<?=$sItemId?>_heading" data-toggle="collapse" data-target="#<?=$sItemId?>_collapse" aria-expanded="true" aria-controls="<?=$sItemId?>_collapse">
						<span class="card-header-link__title"><?=$arItem['NAME']?></span>
						<?php if (isset($arParams['NOTE_PROP']) && !empty($arItem['DISPLAY_PROPERTIES'][$arParams['NOTE_PROP']])):?>
							<span class="card-header-link__desc"><?=$arItem['DISPLAY_PROPERTIES'][$arParams['NOTE_PROP']]['DISPLAY_VALUE']?></span>
						<?php endif; ?>
						<span class="card-header-link__arrow">
							<svg class="icon-svg"><use xlink:href="#svg-chevron-down"></use></svg>
						</span>
					</button>
				</div>

				<div id="<?=$sItemId?>_collapse" class="collapse" aria-labelledby="<?=$sItemId?>_heading" data-parent="#<?=$sBlockId?>_accordion">
					<div class="card-body">
						<?=$arItem['PREVIEW_TEXT']?>

						<div class="mt-5">
							<?php if (!empty($arParams['JOB_LINK'])): ?>
							<a class="btn btn-primary" data-type="ajax" href="<?=str_replace("#ELEMENT_ID#", $arItem['ID'], $arParams['JOB_LINK'])?>"><?=Loc::getMessage('RS_MM_NL_TPL_VACANCIES_JOB_LINK')?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
<?php
endif;
