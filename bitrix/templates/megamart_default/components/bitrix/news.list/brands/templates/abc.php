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
	->addModifier('inner-spacing')
	->addModifier('outer-spacing')
	->addData('TITLE', $sectionTitle);

$layout->start();

foreach ($arResult['LETTERS'] as $arLetters)
{
	?>
	<div class="row">
		<?php
		foreach ($arLetters as $sLetter => $arLetter)
		{
			?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
				<div class="mb-4 mb-lg-6">
					<div class="abc__letter badge badge-primary badge-md mb-2"><?=$sLetter?></div>
					<?php
					foreach ($arLetter as $iItemKey)
					{
						$item = $arResult['ITEMS'][$iItemKey];
						?>
						<div class="abc__list" id="<?=$this->GetEditAreaId($item['ID'])?>">
							<?php
							$this->AddEditAction($item['ID'], $item['EDIT_LINK'], $elementEdit);
							$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
							?>
							<a class="text-body" href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}

$layout->end();
