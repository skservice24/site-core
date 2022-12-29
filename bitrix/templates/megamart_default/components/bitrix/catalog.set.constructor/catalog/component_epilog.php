<?php

use Bitrix\Main\Loader;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var array $templateData
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

global $APPLICATION;

$loadCurrency = Loader::includeModule('currency');
CJSCore::Init(array('currency'));
?>
<script type="text/javascript">
	BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
</script>