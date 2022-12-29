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

$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
$layout
	->addModifier('shadow')
	->addModifier('bg-white')
	->addModifier('inner-spacing')
	->addModifier('outer-spacing');


$layout->start();

echo Loc::getMessage('RS_MM_NL_TPL_LIST_ITEMS_NOT_FOUND');

$layout->end();
