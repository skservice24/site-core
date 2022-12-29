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
?>
<div class="props_group">
	<div class="props_group__name"><?=$arrValue['GROUP']['NAME']?></div>
	<dl class="product-cat-properties">
		<?php
		foreach ($arResult['PROPERTIES'][$sPropCode]['VALUE'] as $iPropKey => $sProp)
		{
			?>
			<dt><?=$arResult['PROPERTIES'][$sPropCode]["DESCRIPTION"][$iPropKey]?>:</dt>
			<dd><span><?=$sProp?></dd>
			<?php
		}
		?>
	</dl>
</div>
