<?php

use Bitrix\Main\Loader;

/**
 * @global CMain $APPLICATION
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

if (Loader::includeModule('redsign.megamart'))
{

	$layout = new \Redsign\MegaMart\Layouts\Section();
	$layout
		->addModifier('container')
		->addModifier('outer-spacing')
		->setNewContext(false);

	$layout->start();
}

$areaIds = [];

$arResult['BANNER_CLASS'] = 'rs-banners-container--mozaic'
?>
<div class="rs-banners-container <?=$arResult['BANNER_CLASS']?>">
	<div class="row align-items-stretch">

		<div class="col-12 col-md-6 d-flex align-items-stretch">
			<?php
			$arItem = reset($arResult['ITEMS']);

			$uniqueId = $arItem['ID'].'_'.$this->randString();
			$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
			$this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
			?>

			<div class="rs-banners_banner pb-6 pb-md-0 d-flex" id="<?=$areaIds[$item['ID']];?>">


				<?php if(!empty($arItem['BACKGROUND'])): ?>

					<?php if(!empty($arItem['PRODUCT_LINK'])): ?>
						<a
							href="<?=$arItem['PRODUCT_LINK']?>"
							target="<?=(isset($arItem['DISPLAY_PROPERTIES']['LINK_TARGET']['VALUE_XML_ID'])) ? $arItem['DISPLAY_PROPERTIES']['LINK_TARGET']['VALUE_XML_ID'] : '_self' ?>"
							title="<?=(isset($arItem['DISPLAY_PROPERTIES']['LINK_TITLE']['VALUE'])) ? $arItem['DISPLAY_PROPERTIES']['LINK_TITLE']['VALUE'] : '' ?>"
						>
					<?php endif; ?>

					<img class="absolute-center" src="<?=$arItem['BACKGROUND']?>" alt="<?=$arItem['BACKGROUND']?>">

					<?php if(!empty($arItem['PRODUCT_LINK'])): ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="col-12 col-md-6 d-flex flex-column justify-content-stretch">
			<?php
			if (!empty($arResult['SIDEBANNERS']))
			{
				?>
				<?php
				foreach($arResult['SIDEBANNERS'] as $key => $arImage):
					$uniqueId = $arImage['ID'].'_'.$this->randString();
					$areaIds[$arImage['ID']] = $this->GetEditAreaId($uniqueId);
					$this->AddEditAction($uniqueId, $arImage['EDIT_LINK'], $elementEdit);
					$this->AddDeleteAction($uniqueId, $arImage['DELETE_LINK'], $elementDelete, $elementDeleteParams);
				?>
					<div class="rs-banners_banner--side flex-grow-1 position-relative overflow-hidden mt-6<?=($key != 0 ? ' mt-md-gutter' : ' mt-md-0')?>" id="<?=$areaIds[$arImage['ID']]?>">
						<?php
						if ($arImage['LINK'])
						{
							?>
							<a href="<?=$arImage['LINK']?>"
								target="<?=(isset($arImage['LINK_TARGET'])) ? $arItem['LINK_TARGET'] : '_self' ?>"
								title="<?=(isset($arImage['LINK_TITLE'])) ? $arIte['LINK_TITLE'] : '' ?>"
							>
								<img class="absolute-center" src="<?=$arImage['SRC']?>" alt="<?=$arImage['NAME']?>">
							</a>
							<?php
						}
						else
						{
							?>
							<img class="absolute-center" src="<?=$arImage['SRC']?>" alt="<?=$arImage['NAME']?>">
							<?php
						}
						?>

					</div>
				<?php endforeach; ?>
				<?php
			}
			?>
		</div>

	</div>
</div>
<?php

if (Loader::includeModule('redsign.megamart'))
{
	$layout->end();
}