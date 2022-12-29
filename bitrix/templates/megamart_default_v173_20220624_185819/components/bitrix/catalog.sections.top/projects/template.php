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
Loc::loadMessages(__FILE__);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => Loc::getMessage('RS_MM_CST_TPL_PROJECTS_ELEMENT_DELETE_CONFIRM'));

$this->addExternalCss(SITE_TEMPLATE_PATH.'/components/bitrix/news.list/projects/style.css');

if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y')
{
	UI\Extension::load([
		'main.lazyload',
	]);
}

$layoutHeader = new \Redsign\Megamart\Layouts\Parts\SectionHeaderBase();

$layout = new \Redsign\MegaMart\Layouts\Section();
$layout
	->useHeader($layoutHeader)
	->addModifier('bg-white')
	->addModifier('shadow')
	->addModifier('outer-spacing');

foreach ($arResult['SECTIONS'] as $arSection):
	$layoutHeader->addData('TITLE', $arSection['NAME']);
	$layoutHeader->addData('TITLE_LINK', $arSection['SECTION_PAGE_URL']);

	$layout->start();
?>
	<div class="l-project-list">
		<?php if ($arParams['SHOW_DESCRIPTION'] == 'Y' && !empty(trim($arSection['DESCRIPTION']))): ?>
		<div class="block-spacing"><?=$arSection['DESCRIPTION']?></div>
		<?php endif; ?>

		<?php
		$sTemplatePath = $_SERVER['DOCUMENT_ROOT'].$templateFolder.'/templates/type1.php';
		if (file_exists($sTemplatePath)) {
			include $sTemplatePath;
		}
		?>
	</div>
<?php
	$layout->end();
endforeach;
