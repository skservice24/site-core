<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true); ?>

<h3 class="brands-title">Бренды</h3>

<div class="brands-menu">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="brand-elem">
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="brand-link">
				<img class="brand-img" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
			</a>
		</div>
	<?endforeach;?>
</div>