<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI;
use Redsign\MegaMart\ParametersUtils;

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

$this->setFrameMode(true);

if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y')
{
	UI\Extension::load([
		'main.lazyload',
	]);
}

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
$layout->addModifier('outer-spacing-quart');
$layout->addModifier('bg-lg');

$layoutHeader = $layout->getHeader();
if ($layoutHeader)
{
	$layoutHeader->addData('TITLE_ID', $this->GetEditAreaId($arResult['SECTION']['ID']));
	if (empty($layoutHeader->getData('TITLE')))
	{
		$sectionTitle = (
			isset($arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']) && $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != ''
			? $arResult['SECTION']['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']
			: $arResult['SECTION']['NAME']
		);

		$layoutHeader->addData('TITLE', $sectionTitle);
	}
}

$layout->start();

/*
	if ($arResult['SECTION']['DESCRIPTION'] != ''): ?>
		<div class="<?=$arCurView['DESCRIPTION']?> row">
			<div class="col-md-8"><?=$arResult['SECTION']['DESCRIPTION']?></div>
		</div>
	<?php endif;
*/

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<ul class="row list-unstyled mb-0">
<?
	switch ($arParams['SECTIONS_VIEW_MODE'])
	{
		case 'TILE':
		default:

			$iLvl1SectionCount = 0;

			$sGridClass = '';
			if (Loader::includeModule('redsign.megamart'))
				$sGridClass = ParametersUtils::gridToString($arParams['GRID_RESPONSIVE_SETTINGS']);

			foreach ($arResult['SECTIONS'] as &$arSection)
			{
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

				if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					if (0 < $intCurrentDepth) {
						if ($arSection['RELATIVE_DEPTH_LEVEL'] == 2) {
							echo '<ul class="tile__sub list-inline">';
						} else {
							echo '<ul>';
						}
					}
				}
				elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					if (!$boolFirst)
					{
						if ($arSection['RELATIVE_DEPTH_LEVEL'] == 1) {
							echo '</div></div>'; // .tile .tile__body
						}
						echo '</li>';
					}
				}
				else
				{
					while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
					{
						echo '</li></ul>';
						$intCurrentDepth--;
					}
					if ($arSection['RELATIVE_DEPTH_LEVEL'] == 1)
					{
						echo '</div>'; // .tile__head

						if ($arSectionTop)
						{
							if ($arSectionTop['SECTIONS_COUNT'] > 0)
							{
								?>
								<a href="<?=$arSectionTop['SECTION_PAGE_URL']?>">
									<?=Loc::getMessage('RS_MM_BCSL_CATALOG_SECTIONS_COUNT', array('#NUM#' => $arSectionTop['SECTIONS_COUNT']))?>
								</a>
								<?
							}
						}
						echo '</div></div>'; // .tile .tile__body
					}
					echo '</li>';
				}
				?>
				<?php if ($arSection['RELATIVE_DEPTH_LEVEL'] == 1): ?>

					<?php
					$iLvl1SectionCount++;
					if ($arParams['LVL1_SECTION_COUNT'] > 0 && $arParams['LVL1_SECTION_COUNT'] < $iLvl1SectionCount)
					{
						$intCurrentDepth = 0;
						break;
					}

					if (false === $arSection['PICTURE'])
						$arSection['PICTURE'] = array(
							'SRC' => $this->GetFolder().'/images/tile-empty.png',
							'ALT' => (
								'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
								? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
								: $arSection["NAME"]
							),
							'TITLE' => (
								'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
								? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
								: $arSection["NAME"]
							)
						);

					$arSectionTop = $arSection;
					?><li class="<?=$sGridClass?> mb-5 d-flex" id="<? echo $this->GetEditAreaId($arSection['ID']);?>">
						<div class="tile flex-fill">
							<a class="tile__pic" href="<?=$arSection['SECTION_PAGE_URL']?>">
								<img src="<?=$arSection['PICTURE']['SRC']?>"
									width="<?=$arSection['PICTURE']['WIDTH']?>"
									height="<?=$arSection['PICTURE']['HEIGHT']?>"
									alt="<?=$arSection['PICTURE']['TITLE']?>"
									class="tile__image"
								<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
									loading="lazy"
								<?php endif; ?>
								/>
							</a>
							<div class="tile__body">
								<div class="tile__head">
									<?php if ('Y' != $arParams['HIDE_SECTION_NAME']): ?>
										<h6 class="tile__title">
											<a href="<?=$arSection['SECTION_PAGE_URL']?>">
												<?php
												echo $arSection['NAME'];
												if ($arParams["COUNT_ELEMENTS"])
												{
													?> <span>(<?=$arSection['ELEMENT_CNT']?>)</span><?
												}
												?>
											</a>
										</h6>
									<?php endif; ?>

				<?php else: ?>
					<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="list-inline-item">
						<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"];?><?
						if ($arParams["COUNT_ELEMENTS"]) {
							?> <span>(<?=$arSection["ELEMENT_CNT"]?>)</span><?
						}
						?></a>
				<?php endif; ?>

				<?php
				$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
				$boolFirst = false;
			}
			unset($arSection);
			while ($intCurrentDepth > 1)
			{
				echo '</li></ul>';
				$intCurrentDepth--;
			}
			if ($intCurrentDepth > 0)
			{
				echo '</div></div></div>'; // .tile, .tile__body
				echo '</li>';
			}
			break;
	}
?>
</ul>
<?
}

$layout->end();
