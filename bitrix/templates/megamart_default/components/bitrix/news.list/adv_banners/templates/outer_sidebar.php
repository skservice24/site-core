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
 * @var string $sectionTitle
 * @var string $elementEdit
 * @var string $elementDelete
 * @var array $elementDeleteParams
 */

if (count($arResult['ITEMS']) > 0): ?>
<div class="l-section l-section--outer-spacing">
	<div class="adv-outer-sidebar">
		<?php
		$randomItemId = rand(0, count($arResult['ITEMS']) - 1);
		$arItem = $arResult['ITEMS'][$randomItemId];
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
		?>
		<div class="b-adv-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?php if (isset($arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'])): ?>
			<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" <?
				?>target="<?=(isset($arItem['DISPLAY_PROPERTIES']['LINK_TARGET']['VALUE_XML_ID'])) ? $arItem['DISPLAY_PROPERTIES']['LINK_TARGET']['VALUE_XML_ID'] : '_self' ?>"<?
				?>title="<?=(isset($arItem['DISPLAY_PROPERTIES']['LINK_TITLE']['VALUE'])) ? $arItem['DISPLAY_PROPERTIES']['LINK_TITLE']['VALUE'] : '' ?>">
		<?php endif; ?>
		<?php if (isset($arItem['DISPLAY_PROPERTIES']['IMAGE']['VALUE'])): ?>
				<img src="<?=CFile::GetPath($arItem['DISPLAY_PROPERTIES']['IMAGE']['VALUE'])?>" width="260" height="500" style="border:0;">
		<?php endif; ?>
		<?php if (isset($arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'])): ?>
			</a>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>