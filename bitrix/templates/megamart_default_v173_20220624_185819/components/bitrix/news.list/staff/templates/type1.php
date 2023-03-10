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
 * @var string $sectionTitle
 * @var string $elementEdit
 * @var string $elementDelete
 * @var array $elementDeleteParams
 */
?>
<div class="row no-gutters row-borders m--1">
	<?php
	foreach ($arResult['ITEMS'] as $arItem)
	{
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
		?>
		<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
			<div class="b-employee b-employee--type1" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

				<div class="b-employee__picture">
					<?php if (!empty($arItem['PREVIEW_PICTURE'])):?>
					<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>" title="<?=$arItem['PREVIEW_PICTURE']['TITLE']?>">
					<?php endif; ?>
				</div>

				<div class="b-employee__data">
					<div class="b-employee__name">
						<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_NAME']])): ?>
						<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_NAME']]['DISPLAY_VALUE']?>
						<?php endif; ?>
					</div>
					<div class="b-employee__position">
						<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_POSITION']])): ?>
						<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_POSITION']]['DISPLAY_VALUE']?>
						<?php endif; ?>
					</div>
					<div class="b-employee__description">
						<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_DESCRIPTION']])): ?>
						<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_DESCRIPTION']]['DISPLAY_VALUE']?>
						<?php endif; ?>
					</div>
					<div class="b-employee__contacts">
					<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_CONTACTS']])): ?>
					<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_CONTACTS']]['DISPLAY_VALUE']?>
					<?php endif; ?>
					</div>
					<div class="b-employee__quest">
						<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_IS_ASK']]) && $arItem['DISPLAY_PROPERTIES'][$arParams['PROP_IS_ASK']]['DISPLAY_VALUE'] == 'Y'): ?>
						<a href="<?=str_replace('#ELEMENT_ID#', $arItem['ID'], $arParams['ASK_LINK'])?>" data-type="ajax"><?=Loc::getMessage('RS_MM_NL_TPL_STAFF_ASK_QUESTION');?></a>
						<?php endif; ?>
					</div>
					<div class="b-employee__social">
					<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SOCIAL']])): ?>
						<?php foreach ($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SOCIAL']]['VALUE'] as $index => $sLink): ?>
						<a class="b-employee-social-icon" href="<?=$sLink?>" target="_blank" rel="nofollow">
							<svg class="icon-svg"><use xlink:href="#svg-<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SOCIAL']]['DESCRIPTION'][$index]?>"></use></svg>
						</a>
						<?php endforeach; ?>
					<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
		<?php
	}
	?>
</div>
