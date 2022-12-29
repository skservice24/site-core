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
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_NL_TPL_STAFF_ELEMENT_DELETE_CONFIRM'));

$sectionTitle = (
    isset($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
    ? $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
    : $arResult['NAME']
);

if (count($arResult['ITEMS'])):

$sBlockId = $this->randString(10);


$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
$layout
	->addModifier('bg-white')
	->addModifier('shadow')
	->addModifier('outer-spacing')
	->addData('TITLE', $sectionTitle);

$layout->start();

?>
<div class="l-staff" id="staff_<?=$sBlockId?>">
	<?php if ($arParams['SHOW_DESCRIPTION'] == 'Y'): ?>
		<?php if (intval($arParams['PARENT_SECTION']) > 0 && $arResult['PARENT_SECTION']['DESCRIPTION'] != ''): ?>
			<div class="block-spacing"><?=$arResult['PARENT_SECTION']['DESCRIPTION']?></div>
		<?php elseif (count($arResult['DESCRIPTION']) > 0): ?>
			<div class="block-spacing"><?=$arResult['DESCRIPTION']?></div>
		<?php endif; ?>
	<?php endif; ?>
	<?php
	if (file_exists($arResult['TEMPLATE_PATH'])) {
		include($arResult['TEMPLATE_PATH']);
	}
	?>
</div>
<?php
$layout->end();
endif;
