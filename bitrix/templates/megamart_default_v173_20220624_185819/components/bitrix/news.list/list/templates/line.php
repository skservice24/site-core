<?php

/**
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

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
$layout
	->addModifier('bg-white')
	->addModifier('shadow')
	->addModifier('outer-spacing')
	->addData('TITLE', $sectionTitle);

$layout->start();
?>

<?php if ($arParams['DISPLAY_TOP_PAGER']): ?>
	<?=$arResult['NAV_STRING']?>
<?php endif; ?>

<ul class="b-news-list-line list-unstyled mb-0">
<?php
foreach ($arResult['ITEMS'] as $arItem)
{
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
	?>
	<li class="row row-borders bg-white border-top border-body-bg mt--1">
		<div class="col-12">
			<div class="b-news-list-line__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="row">
					<div class="col-12 col-sm-6 col-lg-3">
						<?php
						if (!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || ($arItem['DETAIL_TEXT'] && $arResult['USER_HAVE_ACCESS']))
						{
							?>
							<a class="b-news-list-line__pic__canvas" href="<?=$arItem['DETAIL_PAGE_URL']?>">
								<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"

									width="<?=$arItem['PREVIEW_PICTURE']['WIDTH']?>"
									height="<?=$arItem['PREVIEW_PICTURE']['HEIGHT']?>"
									alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>"
									title="<?=$arItem['PREVIEW_PICTURE']['TITLE']?>"
									class="b-news-list-line__pic"
								<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
									loading="lazy"
								<?php endif; ?>
								/>
							</a>
							<?php
						}
						else
						{
							?>
							<div class="b-news-list-line__pic__canvas">
								<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"

									width="<?=$arItem['PREVIEW_PICTURE']['WIDTH']?>"
									height="<?=$arItem['PREVIEW_PICTURE']['HEIGHT']?>"
									alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>"
									title="<?=$arItem['PREVIEW_PICTURE']['TITLE']?>"
									class="b-news-list-line__pic"
								<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
									loading="lazy"
								<?php endif; ?>
								/>
							</div>
							<?php
						}
						?>
					</div>
					<div class="col-12 col-sm-6 col-lg-9">
						<div class="b-news-list-line__body">
							<div class="b-news-list-line__stickers">
								<div class="b-news-list-line__stickers-in"><?
									?><?php if ($arParams['STICKER_IBLOCK'] == 'Y'): ?><div class="c-sticker"><span class="c-sticker__name"><?=$arResult['NAME']?></span></div><?php endif; ?><?
									if (is_array($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_STICKER']]['DISPLAY_VALUE'])) {
										foreach ($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_STICKER']]['DISPLAY_VALUE'] as $key => $stickerName) {
											$color = $arItem['DISPLAY_PROPERTIES'][$arParams['PROP_STICKER']]['VALUE_XML_ID'][$key];
											?><div <?
												?>class="c-sticker" <?
												?><?=(!empty($color) ? ' style="background-color: #'.$color.';color: #'.$color.';"' : '')?><?
												?>><span class="c-sticker__name"><?=$stickerName?></span><?
											?></div><?
										}
									} elseif (!empty($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_STICKER']]['DISPLAY_VALUE'])) {
										$color = $arItem['DISPLAY_PROPERTIES'][$arParams['PROP_STICKER']]['VALUE_XML_ID'][0];
										$stickerName = $arItem['DISPLAY_PROPERTIES'][$arParams['PROP_STICKER']]['DISPLAY_VALUE'];
										?><div <?
											?>class="c-sticker" <?
											?><?=(!empty($color) ? ' style="background-color: #'.$color.';color: #'.$color.';"' : '')?><?
											?>><span class="c-sticker__name"><?=$stickerName?></span><?
										?></div><?
									}
								?></div>
							</div><!-- /.b-news-list-line__stickers -->
							<div class="b-news-list-line__head">
								<div class="b-news-list-line__info"><?
									?><?php if (!empty($arItem['DISPLAY_ACTIVE_FROM'])): ?><?
									?><span <?
										?>class="b-news-list-line__info-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?><?
									?></span><?
									?><?php endif; ?><?
									?><?php if (!empty($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SLOGAN']]['DISPLAY_VALUE'])): ?><?
									?><span class="b-news-list-line__info-slogan"><?=$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SLOGAN']]['DISPLAY_VALUE']?></span><?
									?><?php endif; ?><?
								?></div>
								<h6 class="b-news-list-line__title">
									<?php if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
									<a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>"><?=$arItem['NAME']?></a>
									<?php else: ?><?=$arItem['NAME']?><?php endif; ?>
								</h6>
								<?php if ($arParams['DISPLAY_PREVIEW_TEXT'] == 'Y' && !empty($arItem['PREVIEW_TEXT'])): ?>
								<div class="b-news-list-line__preview-text"><?=$arItem['PREVIEW_TEXT']?></div>
								<?php endif; ?>
							</div><!-- /.b-news-list-line__head -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</li>
	<?php
}
?>
</ul>

<?php if ($arParams['DISPLAY_BOTTOM_PAGER']): ?>
	<?=$arResult['NAV_STRING']?>
<?php endif; ?>

<?php
$layout->end();
