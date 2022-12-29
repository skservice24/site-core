<?php

use Bitrix\Main\Type\RandomSequence;

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

global $APPLICATION;

$strReturn = '';
$strMinimize = '';

$itemSize = count($arResult);
$canMinimize = $itemSize > 3;

$rand  = new RandomSequence(microtime());
$dropdownId = 'dropdown_'.$rand->randString();

$strReturn .= '<ol class="breadcrumb'.($canMinimize ? ' can-minimize' : '').'" itemscope itemtype="http://schema.org/BreadcrumbList">';

if ($canMinimize)
{

	$strMinimize .= '<div class="dropdown d-inline-block">';

		$strMinimize .= '<a href="#" class="dropdown-toggle" id="'.$dropdownId.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="viewport">';
			$strMinimize .= '<svg class="icon-svg "><use xlink:href="#svg-chevron-down"></use></svg>';
		$strMinimize .= '</a>';

		$strMinimize .= '<div class="dropdown-menu" aria-labelledby="'.$dropdownId.'">';
		for ($index = 1; $index < $itemSize - 1; $index++)
		{
			$title = htmlspecialcharsex($arResult[$index]['TITLE']);
			$strMinimize .= '<a class="dropdown-item" href="'.$arResult[$index]['LINK'].'">'.$title.'</a>';
		}
		$strMinimize .= '</div>';

	$strMinimize .= '</div>';
}


for ($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]['TITLE']);

	if (($index == $itemSize - 1) && $canMinimize)
	{
		$strReturn .= '<li  class="breadcrumb-item breadcrumb-item-dropdown">';
			$strReturn .= $strMinimize;
		$strReturn .= '</li>';
	}

	if ($arResult[$index]['LINK'] <> '' && $index != $itemSize - 1)
	{
		$strReturn .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'.
				'<a itemprop="item" href="'.$arResult[$index]['LINK'].'" title="'.$title.'">'.
					'<span itemprop="name">'.$title.'</span>'.
					'<meta itemprop="position" content="'.($index + 1).'">'.
				'</a>'.
			'</li>';
	}
	else
	{
		$strReturn .= ' <li class="breadcrumb-item">'.
				'<span>'.$title.'</span>'.
			'</li>';
	}
}

$strReturn .= '</ol>';

return $strReturn;
