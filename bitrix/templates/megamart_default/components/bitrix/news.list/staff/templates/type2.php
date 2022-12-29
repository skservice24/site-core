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

foreach ($arResult['ITEMS'] as $arItem)
{

	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
	?>
	<div class="b-employee b-employee--type2" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="b-employee__container">
			<div class="b-employee__picture">
				<?php if (!empty($arItem['PREVIEW_PICTURE'])):?>
				<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>" title="<?=$arItem['PREVIEW_PICTURE']['TITLE']?>">
				<?php endif; ?>
			</div>

			<div class="b-employee__data">
				<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_NAME']])): ?>
				<div class="b-employee__name">
					<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_NAME']]['DISPLAY_VALUE']?>
				</div>
				<?php endif; ?>

				<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_POSITION']])): ?>
				<div class="b-employee__position">
					<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_POSITION']]['DISPLAY_VALUE']?>
				</div>
				<?php endif; ?>

				<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_DESCRIPTION']])): ?>
				<div class="b-employee__description">
					<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_DESCRIPTION']]['DISPLAY_VALUE']?>
				</div>
				<?php endif; ?>

				<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_CONTACTS']])): ?>
				<div class="b-employee__contacts">
					<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_CONTACTS']]['DISPLAY_VALUE']?>
				</div>
				<?php endif; ?>

				<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_IS_ASK']]) && $arItem['DISPLAY_PROPERTIES'][$arParams['PROP_IS_ASK']]['DISPLAY_VALUE'] == 'Y'): ?>
				<div class="b-employee__quest">
					<a href="<?=str_replace('#ELEMENT_ID#', $arItem['ID'], $arParams['ASK_LINK'])?>" data-type="ajax"><?=Loc::getMessage('RS_MM_NL_TPL_STAFF_ASK_QUESTION');?></a>
				</div>
				<?php endif; ?>

				<?php if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SOCIAL']])): ?>
				<div class="b-employee__social">
					<?php foreach ($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SOCIAL']]['VALUE'] as $index => $sLink): ?>
					<a class="b-employee-social-icon" href="<?=$sLink?>" target="_blank" rel="nofollow">
						<svg class="icon-svg"><use xlink:href="#svg-<?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SOCIAL']]['DESCRIPTION'][$index]?>"></use></svg>
					</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

			</div>
		</div>

	</div>
	<?php
}
