<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
	die();
}

use \Bitrix\Main\Localization\Loc;

if (!empty($arResult['PHONES']) && is_array($arResult['PHONES'])):?><div class="d-flex">
	<div class="d-block mr-4">
		<svg class="icon-svg text-extra h4"><use xlink:href="#svg-phone"></use></svg>
	</div>
	<div class="d-block">
		<?php
		foreach ($arResult['PHONES'] as $sPhone):
			$sPhoneUrl = preg_replace('/[^0-9\+]/', '', $sPhone);
		?>
		<a href="tel:<?=$sPhoneUrl?>" class="d-block font-weight-bold text-body"><?=$sPhone?></a>
		<?php endforeach; ?>
	</div>
</div><?php
endif;
