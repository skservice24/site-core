<?php

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $sectionTitle
 * @var string $strSectionEdit
 * @var string $strSectionDelete
 * @var array $arSectionDeleteParams
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

if ($arResult['SECTIONS_COUNT'] < 1)
    return;

$layout = new \Redsign\MegaMart\Layouts\Section();
$layout
    ->addModifier('bg-white')
    ->addModifier('outer-spacing')
    ->addModifier('shadow')
    ->addData('TITLE', $sectionTitle);

$layout->start();

?><div class="d-block p-4"> <span><?=Loc::getMessage('RS_MM_CSL_VIEW_BUTTONS_TITLE');?></span><?php

    $nRemain = $arResult['SECTIONS_COUNT'];

    foreach ($arResult['SECTIONS'] as $nIndex => $arSection)
    {
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

        ?><a
            href="<?=$arSection["SECTION_PAGE_URL"]?>"
            id="<?=$this->GetEditAreaId($arSection['ID']);?>"
        ><?=$arSection["NAME"]?></a><?php

        if (--$nRemain > 0)
        {
            echo ', ';
        }

    }
?></div><?php

$layout->end();

unset($layout);
