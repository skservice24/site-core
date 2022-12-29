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

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if (count($arResult['ITEMS']) > 0)
{
	?>
	<div class="l-section l-section--outer-spacing">
		<div class="adv-index-full">
			<?php
			foreach ($arResult['ITEMS'] as $arItem)
			{
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
				?>
				<div class="b-adv-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?php if (isset($arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'])): ?>
						<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE']?>" <?
							?>target="<?=(isset($arItem['DISPLAY_PROPERTIES']['LINK_TARGET']['VALUE_XML_ID'])) ? $arItem['DISPLAY_PROPERTIES']['LINK_TARGET']['VALUE_XML_ID'] : '_self' ?>"<?
							?>title="<?=(isset($arItem['DISPLAY_PROPERTIES']['LINK_TITLE']['VALUE'])) ? $arItem['DISPLAY_PROPERTIES']['LINK_TITLE']['VALUE'] : '' ?>">
					<?php endif; ?>
							<div class="b-adv-index-full" style="background-image: url('<?=CFile::GetPath($arItem['DISPLAY_PROPERTIES']['IMAGE']['VALUE'])?>')"></div>
					<?php if (isset($arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'])): ?>
						</a>
					<?php endif; ?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}
