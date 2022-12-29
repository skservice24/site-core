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

$this->addExternalCss($templateFolder.'/theme/'.mb_strtolower($arParams['RS_TEMPLATE']).'.css');

$layout = \Redsign\MegaMart\Layouts\Builder::createFromParams($arParams);
$layout
	->addModifier('shadow')
	->addModifier('bg-white')
	->addModifier('outer-spacing')
	->addData('TITLE', $sectionTitle);

$layoutHeader = $layout->getHeader();
if ($layoutHeader)
{
	$layoutHeader->addData('TITLE_LINK', ltrim(CComponentEngine::MakePathFromTemplate($arResult['LIST_PAGE_URL']), SITE_DIR));
}
// if ($arParams['USE_OWL'] == 'Y')
// {
	$layout->useSlider($sBlockId);
// }

$layout->start();
?>
<div data-slider="<?=$sBlockId?>" data-slider-options="<?=htmlspecialcharsbx(\Bitrix\Main\Web\Json::encode($arResult['RS_SLIDER_OPTIONS']))?>" class="<?=$arResult['RS_SLIDER_CLASSES']?>">
	<?php
	foreach ($arResult['ITEMS'] as $item)
	{
		?>
		<div class="col" id="<?=$this->GetEditAreaId($item['ID']);?>">
			<?php
			$this->AddEditAction($item['ID'], $item['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
			?>
			<a class="brand-item-light" href="<?=$item['DETAIL_PAGE_URL']?>">
				<?php
				if (is_array($item['PREVIEW_PICTURE']))
				{
					?>
					<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item['NAME']?>">
					<?php
				}
				?>
			</a>
		</div>
		<?php
	}
	unset($item);
	?>
</div>
<?php

$layout->end();
