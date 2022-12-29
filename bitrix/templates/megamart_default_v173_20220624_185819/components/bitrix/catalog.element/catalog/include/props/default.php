<?php

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

if ($arResult['PROPERTIES'][$sPropCode]['VALUE']['TYPE'] == 'text')
{
	echo $arResult['PROPERTIES'][$sPropCode]['VALUE']['TEXT'];
}
elseif (isset($arResult['DISPLAY_PROPERTIES'][$sPropCode]))
{
	echo $arResult['DISPLAY_PROPERTIES'][$sPropCode]['DISPLAY_VALUE'];
}