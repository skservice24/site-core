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
	->setNewContext(false);
	// ->addData('TITLE', $sectionTitle);

$layout->start();
?>
<div class="row row-borders">
	<?php
	foreach ($arResult['ITEMS'] as $arItem)
	{
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);

		if (!isset($arItem['DISPLAY_PROPERTIES'][$arParams['PROP_FILE']]['FILE_VALUE'])) {
			continue;
		}

		$arFile = $arItem['DISPLAY_PROPERTIES'][$arParams['PROP_FILE']]['FILE_VALUE'];
		?>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
			<div class="doc px-5 py-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?php
				$arPicture = [];
				if (isset($arItem['PREVIEW_PICTURE']['SRC']))
				{
					$arPicture = $arItem['PREVIEW_PICTURE'];
				}
				else
				{
					$arPicture = [
						'SRC' => $templateFolder.'/images/file.png',
						'WIDTH' => '114',
						'HEIGHT' => '161',
						'ALT' => $arItem['NAME'],
						'TITLE' => $arItem['NAME'],
					];
				}
				?>
				<a class="doc__preview" href="<?=$arFile['SRC']?>">
					<img src="<?=$arPicture['SRC']?>"
						width="<?=$arPicture['WIDTH']?>"
						height="<?=$arPicture['HEIGHT']?>"
						alt="<?=$arPicture['ALT']?>"
						title="<?=$arPicture['TITLE']?>"
						class="img-fluid"
					<?php if ($arParams['RS_LAZY_IMAGES_USE'] == 'Y'): ?>
						loading="lazy"
					<?php endif; ?>
					/>
				</a>

				<a class="doc__name" href="<?=$arFile['SRC']?>">
					<?=$arItem['NAME']?>
				</a>

				<?php if (isset($arItem['PREVIEW_TEXT'])): ?>
					<div class="doc__desc mt-2"><?=$arItem['PREVIEW_TEXT']?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
	?>
</div>
<?php
$layout->end();
