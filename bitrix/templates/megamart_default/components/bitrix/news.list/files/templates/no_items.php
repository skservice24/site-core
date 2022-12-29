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

Loc::loadMessages($templateFolder.'/template.php');

$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
$layout
	->addModifier('bg-white')
	->addModifier('inner-spacing')
	->addModifier('shadow')
	->setNewContext(false);
	// ->addData('TITLE', $sectionTitle);

$layout->start();

	echo Loc::getMessage('RS_MM_NL_TPL_FILES_ITEMS_NOT_FOUND');

$layout->end();
