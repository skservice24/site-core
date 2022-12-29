<?php

use Bitrix\Main\Web\Uri;

/**
 * @var CBitrixComponentTemplate $this
 * @var CBitrixMenuComponent $component
 * @var array $arParams
 * @var array $arResult
 */


if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

foreach ($arResult as $index => $item)
{
	if (strpos($item['LINK'], 'logout=yes') !== false)
	{
		$arResult[$index]['LINK'] = (new Uri($item['LINK']))
			->addParams(['sessid' => bitrix_sessid()])
			->getUri();
	}
}
