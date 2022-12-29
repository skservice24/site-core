<?php

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 * @var string $elementEdit
 * @var string $elementDelete
 * @var array $elementDeleteParams
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="row no-gutters row-borders align-items-stretch">
	<?php
	foreach ($arSection['ITEMS'] as $arItem)
	{
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
		?>
		<div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">

			<div class="project-item project-item--type1" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="project-item__head">
					<?php
					$arPicture = array();
					if ($arItem['PREVIEW_PICTURE']) {
						$arPicture = $arItem['PREVIEW_PICTURE'];
					} elseif (is_array($arItem['DETAIL_PICTURE'])) {
						$arPicture = $arItem['DETAIL_PICTURE'];
					} else {
						$arPicture = array(
							'SRC' => $templateFolder.'/images/no_photo.png'
						);
					}
					?>

					<?php if ($arParams['DISPLAY_PICTURE'] != 'N' && is_array($arPicture)): ?>
						<div class="project-item__pic">
							<?php if (!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || $arItem['DETAIL_TEXT']): ?>
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
									<img src="<?=$arPicture['SRC']?>"
										width="<?=$arPicture['WIDTH']?>"
										height="<?=$arPicture['HEIGHT']?>"
										alt="<?=$arPicture['ALT']?>"
										class="project-item__img"
									<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
										loading="lazy"
									<?php endif; ?>
									/>
								</a>
							<?php else: ?>
								<span class="project-item__img" style="background-image: url(<?=$arPicture['SRC']?>);" title="<?=$arPicture['TITLE']?>"></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="project-item__data">
					<?php if ($arParams['DISPLAY_NAME'] != 'N' && $arItem['NAME']): ?>
						<div class="project-item__name">
							<?php if (!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || $arItem['DETAIL_TEXT']):?>
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
							<?php else: ?>
								<?=$arItem['NAME']?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ($arParams['DISPLAY_PREVIEW_TEXT'] != 'N' && $arItem['PREVIEW_TEXT']): ?>
						<div class="project-item__description"><?=$arItem['PREVIEW_TEXT']?></div>
					<?php endif; ?>

					<?php if (is_array($arItem['DISPLAY_PROPERTIES']) && count($arItem['DISPLAY_PROPERTIES']) > 0): ?>
						<div class="project-item__props">
							<?php
							foreach($arItem["DISPLAY_PROPERTIES"] as $sPropKey => $arProperty):
								if (in_array($arProperty['CODE'], $arResult['DISPLAY_SKIP_PROPERTIES'])) {
									continue;
								}
							?>
								<div class="project-item__prop">
									<?php
									if ($arProperty['CODE'] == $arParams['PROP_SITE_DOMAIN']):
										echo $arProperty['NAME'].':&nbsp;';
										if (isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SITE_URL']]['VALUE'])):
											echo '<a href="'.$arItem['DISPLAY_PROPERTIES'][$arParams['PROP_SITE_URL']]['VALUE'].'" rel="nofollow">'.$arProperty['VALUE'].'</a>';
										else:
											echo $arProperty['VALUE'];
										endif;

									else:
										echo $arProperty['NAME'].':&nbsp;';
										if (is_array($arProperty['DISPLAY_VALUE'])):
											echo implode('&nbsp;/&nbsp;', $arProperty['DISPLAY_VALUE']);
										else:
											echo $arProperty['DISPLAY_VALUE'];
										endif;

									endif;
									?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>
