<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;

$documentRoot = Application::getDocumentRoot();
$request = Application::getInstance()->getContext()->getRequest();
$curPage = $APPLICATION->GetCurPage(true);

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/header.php');

$hasBanner = $curPage == SITE_DIR.'index.php';

$sMenuTheme = RS_MM_MENU_THEME;
define('RS_MM_HEAD_TYPE', 'type5');

$sHeaderClass = 'l-head l-head--type5 l-head--'.$sMenuTheme;
$sHeaderBackgroundClass = 'position-relative';

if ($hasBanner)
{

	$sHeaderClass .= ' has-banner';

	if (RS_MM_BANNER_TYPE == 'underlay') {
		$sHeaderClass .= ' is-underlay';
	}
	elseif (RS_MM_BANNER_TYPE == 'center_sidebanners')
	{
		$sHeaderClass .= ' has-sidebanners';
		define('RS_MM_BANNER_SIDEBANNERS', 'both');
	}
}

if (!$hasBanner || RS_MM_BANNER_TYPE != 'underlay')
 {
	$sHeaderBackgroundClass .= ' bg-light';
}
?>

<header class="<?=$sHeaderClass?>">
	<div class="l-head__main">
		<div class="<?=$sHeaderBackgroundClass?>">
			<div class="container">
				<div class="d-flex align-items-center justify-content-between py-5">

					<div class="l-head__logo-slogan d-flex align-items-center mr-3">
						<div class="d-block l-head__logo">
							<a class="b-header-logo" href="<?=SITE_DIR?>">
								<?php
								$APPLICATION->IncludeFile(
									SITE_DIR.'/include/header/logo.php',
									array(),
									array(
										'NAME' => Loc::getMessage('RS_HEADER_EDIT_LOGO')
									)
								);
								?>
							</a>
						</div>
					</div>

					<div class="l-head__location d-block mx-3">
						<?php
						$APPLICATION->IncludeFile(
							SITE_DIR.'/include/header/location.php',
							array(),
							array(
								'SHOW_BORDER' => false
							)
						);
						?>
					</div>

					<div class="l-head__phones d-block mx-4">
						<?php
						$APPLICATION->IncludeFile(
							SITE_DIR.'/include/header/phones_2.php',
							array(),
							array(
								'SHOW_BORDER' => false
							)
						);
						?>
					</div>

					<div class="d-block my-4">
						<?php
						$APPLICATION->IncludeFile(
							SITE_DIR.'/include/footer/emails.php',
							array(),
							array(
								'SHOW_BORDER' => false
							)
						);
						?>
					</div>

					<div class="l-head__search d-flex flex-md-grow-1 flex-lg-grow-0 align-items-center mx-4">
						<?php
						$APPLICATION->IncludeFile(
							SITE_DIR.'/include/header/search_form.php',
							array(),
							array(
								'SHOW_BORDER' => false
							)
						);
						?>
					</div>

					<div class="l-head__controls d-flex align-items-center mx-3">
						<div class="mr-5 d-block">
							<?php
							$APPLICATION->IncludeFile(
								SITE_DIR.'/include/header/personal.php',
								array(),
								array(
									'SHOW_BORDER' => false
								)
							);
							?>
						</div>

						<?/*php
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
						*/?>
					</div>

				</div>
			</div>

			<div class="l-head__line bg-<?=RS_MM_MENU_THEME?>">
				<div class="container js-menu-container">
					<div class="l-head__line-inner d-flex">

						<div class="d-block flex-grow-0 l-head__vertical-menu order-1">
							<?php $APPLICATION->IncludeFile(
								SITE_DIR.'include/header/menu_vertical.php',
								array(),
								array(
									'SHOW_BORDER' => false
								)
							); ?>
						</div>

						<div class="d-flex flex-grow-1 flex-shrink-1 order-2 l-head__menu">
							<?php $APPLICATION->IncludeFile(
								SITE_DIR.'include/header/menu_main.php',
								array(),
								array(
									'SHOW_BORDER' => false
								)
							); ?>
						</div>

						<div class="brands-menu-block">
							<?$APPLICATION->IncludeComponent(
								"bitrix:news.list",
								"brands-menu",
								Array(
									"ACTIVE_DATE_FORMAT" => "d.m.Y",
									"ADD_SECTIONS_CHAIN" => "N",
									"AJAX_MODE" => "N",
									"AJAX_OPTION_ADDITIONAL" => "",
									"AJAX_OPTION_HISTORY" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "N",
									"CACHE_FILTER" => "N",
									"CACHE_GROUPS" => "Y",
									"CACHE_TIME" => "36000000",
									"CACHE_TYPE" => "A",
									"CHECK_DATES" => "Y",
									"DETAIL_URL" => "",
									"DISPLAY_BOTTOM_PAGER" => "N",
									"DISPLAY_DATE" => "N",
									"DISPLAY_NAME" => "N",
									"DISPLAY_PICTURE" => "N",
									"DISPLAY_PREVIEW_TEXT" => "N",
									"DISPLAY_TOP_PAGER" => "N",
									"FIELD_CODE" => array(0=>"NAME",1=>"PREVIEW_PICTURE",2=>"",),
									"FILTER_NAME" => "",
									"HIDE_LINK_WHEN_NO_DETAIL" => "N",
									"IBLOCK_ID" => "22",
									"IBLOCK_TYPE" => "content",
									"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
									"INCLUDE_SUBSECTIONS" => "N",
									"MESSAGE_404" => "",
									"NEWS_COUNT" => "100",
									"PAGER_BASE_LINK_ENABLE" => "N",
									"PAGER_DESC_NUMBERING" => "N",
									"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
									"PAGER_SHOW_ALL" => "N",
									"PAGER_SHOW_ALWAYS" => "N",
									"PAGER_TEMPLATE" => ".default",
									"PAGER_TITLE" => "Новости",
									"PARENT_SECTION" => "",
									"PARENT_SECTION_CODE" => "",
									"PREVIEW_TRUNCATE_LEN" => "",
									"PROPERTY_CODE" => array(0=>"",1=>"",),
									"SET_BROWSER_TITLE" => "N",
									"SET_LAST_MODIFIED" => "N",
									"SET_META_DESCRIPTION" => "N",
									"SET_META_KEYWORDS" => "N",
									"SET_STATUS_404" => "N",
									"SET_TITLE" => "N",
									"SHOW_404" => "N",
									"SORT_BY1" => "NAME",
									"SORT_BY2" => "SORT",
									"SORT_ORDER1" => "ASC",
									"SORT_ORDER2" => "ASC",
									"STRICT_SECTION_CHECK" => "N"
								)
							);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if ($hasBanner): ?>
	<div class="l-head__banner">
		<?php
		$APPLICATION->IncludeFile(
			SITE_DIR.'include/header/banner.php',
			array(),
			array(
				'SHOW_BORDER' => false
			)
		);
			?>
	</div>
	<?php endif; ?>

</header>