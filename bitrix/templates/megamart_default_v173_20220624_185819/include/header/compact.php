<?php
global $RS_FAVORITE_DATA;
global $RS_BASKET_DATA;
global $RS_COMPARE_DATA;


$needIndicator = false;
if (
	isset($RS_FAVORITE_DATA['COUNT']) && $RS_FAVORITE_DATA['COUNT'] > 0 ||
	isset($RS_BASKET_DATA['NUM_PRODUCTS']) && $RS_BASKET_DATA['NUM_PRODUCTS'] > 0 ||
	isset($RS_COMPARE_DATA['COMPARE']) && $RS_COMPARE_DATA['COUNT'] > 0
)
{
	$needIndicator = true;
}
?>
<div class="js-compact-header">
	<div class="l-compact-header js-fix-scroll">
		<div class="container">
			<div class="l-compact-header__blocks">

				<div class="l-compact-header__block l-compact-header__block--menu">
					<button class="hamburger hamburger--squeeze hamburger--text text-left d-block<?=(!$needIndicator ?: ' hamburger--has-indicator')?>" data-compact-menu-toggle>
						<span class="hamburger__text d-none d-md-inline-block"><?=\Bitrix\Main\Localization\Loc::getMessage('RS_COMPACT_MENU'); ?></span>
						<span class="hamburger__box">
							<span class="hamburger__inner"></span>
						</span>
					</button>
				</div>

				<div class="l-compact-header__block l-compact-header__block--logo">
					<a class="b-compact-logo" href="<?=SITE_DIR?>">
						<?$APPLICATION->IncludeFile(
							SITE_DIR."include/compact/logo.php",
							Array(),
							Array("MODE"=>"html")
						);?>
					</a>
				</div>

				<div class="l-compact-header__block l-compact-header__block--search">
                    <?$APPLICATION->IncludeFile(
						SITE_DIR."include/compact/search.php",
						Array(),
						Array("MODE"=>"html")
					);?>
				</div>

				<div class="l-compact-header__block l-compact-header__block--personal">
					<?$APPLICATION->IncludeFile(
						SITE_DIR."include/compact/personal.php",
						Array(),
						Array("MODE"=>"html")
					);?>
				</div>

				<div class="l-compact-header__block l-compact-header__block--icons">
					<?php
					$APPLICATION->IncludeComponent(
						'rsmm:ui.widget',
						'favorite-icon',
						array(
						),
						false,
						array(
							'HIDE_ICONS' => 'Y'
						)
					);

					$APPLICATION->IncludeComponent(
						'rsmm:ui.widget',
						'compare-icon',
						array(
						),
						false,
						array(
							'HIDE_ICONS' => 'Y'
						)
					);

					$APPLICATION->IncludeComponent(
						'rsmm:ui.widget',
						'cart-icon',
						array(
						),
						false,
						array(
							'HIDE_ICONS' => 'Y'
						)
					);
					?>
				</div>

			</div>
		</div>
	</div>

	<?=$APPLICATION->ShowViewContent('popup-search'); ?>
</div>
