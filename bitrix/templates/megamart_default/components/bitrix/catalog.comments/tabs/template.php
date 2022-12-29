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
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$this->setFrameMode(true);

$templateData = array(
	'TABS_ID' => 'soc_comments_'.$arResult['ELEMENT']['ID'],
	'TABS_FRAME_ID' => 'soc_comments_div_'.$arResult['ELEMENT']['ID'],
	'BLOG_USE' => ($arResult['BLOG_USE'] ? 'Y' : 'N'),
	'FB_USE' => $arParams['FB_USE'],
	'VK_USE' => $arParams['VK_USE'],
	'BLOG' => array(
		'BLOG_FROM_AJAX' => $arResult['BLOG_FROM_AJAX'],
	),
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

if (!$templateData['BLOG']['BLOG_FROM_AJAX'])
{
	if (!empty($arResult['ERRORS']))
	{
		ShowError(implode('<br>', $arResult['ERRORS']));
		return;
	}

	$arData = array();
	$arJSParams = array(
		'serviceList' => array(

		),
		'settings' => array(

		),
		'tabs' => array(

		),
        'EXTERNAL_TABS' => $arParams['EXTERNAL_TABS'],
	);

	if ($arResult['BLOG_USE'])
	{
		$templateData['BLOG']['AJAX_PARAMS'] = $arResult['BLOG_AJAX_PARAMS'];

		$arJSParams['serviceList']['blog'] = true;
		$arJSParams['settings']['blog'] = array(
			'ajaxUrl' => $templateFolder.'/ajax.php?IBLOCK_ID='.$arResult['ELEMENT']['IBLOCK_ID'].'&ELEMENT_ID='.$arResult['ELEMENT']['ID'].'&SITE_ID='.SITE_ID,
			'ajaxParams' => array(),
			'contID' => 'bx-cat-soc-comments-blg_'.$arResult['ELEMENT']['ID']
		);

		$arData["BLOG"] =  array(
			"NAME" => ($arParams['BLOG_TITLE'] != '' ? $arParams['BLOG_TITLE'] : GetMessage('IBLOCK_CSC_TAB_COMMENTS')),
			"ACTIVE" => "Y",
			"CONTENT" => '<div id="bx-cat-soc-comments-blg_'.$arResult['ELEMENT']['ID'].'"><div class="p-4 p-sm-7">'.GetMessage("IBLOCK_CSC_COMMENTS_LOADING").'</div></div>'
		);
	}

	if ($arParams["FB_USE"] == "Y")
	{
		$currentLanguage = mb_strtolower(LANGUAGE_ID);
		switch ($currentLanguage)
		{
			case 'en':
				$facebookLocale = 'en_US';
				break;
			case 'ua':
				$facebookLocale = 'uk_UA';
				break;
			case 'by':
				$facebookLocale = 'be_BY';
				break;
			default:
				$facebookLocale = $currentLanguage.'_'.mb_strtoupper(LANGUAGE_ID);
		}
		$arJSParams['serviceList']['facebook'] = true;
		$arJSParams['settings']['facebook'] = array(
			'parentContID' => $templateData['TABS_ID'].'FB',
			'contID' => 'bx-cat-soc-comments-fb_'.$arResult['ELEMENT']['ID'],
			'facebookPath' => 'https://connect.facebook.net/'.$facebookLocale.'/sdk.js#xfbml=1&version=v2.11'
		);
		$arData["FB"] = array(
			"NAME" => isset($arParams["FB_TITLE"]) && trim($arParams["FB_TITLE"]) != "" ? $arParams["FB_TITLE"] : "Facebook",
			"CONTENT" => '<div id="fb-root"></div>
			<div id="bx-cat-soc-comments-fb_'.$arResult['ELEMENT']['ID'].'"><div class="fb-comments" data-href="'.$arResult["URL_TO_COMMENT"].'"'.
			(isset($arParams["FB_COLORSCHEME"]) ? ' data-colorscheme="'.$arParams["FB_COLORSCHEME"].'"' : '').
			(isset($arParams["COMMENTS_COUNT"]) ? ' data-numposts="'.$arParams["COMMENTS_COUNT"].'"' : '').
			(isset($arParams["FB_ORDER_BY"]) ? ' data-order-by="'.$arParams["FB_ORDER_BY"].'"' : '').
			(isset($arResult["WIDTH"]) ? ' data-width="'.($arResult["WIDTH"] - 20).'"' : '').
			'></div></div>'.PHP_EOL
		);
	}

	if ($arParams["VK_USE"] == "Y")
	{
		$arData["VK"] = array(
			"NAME" => isset($arParams["VK_TITLE"]) && trim($arParams["VK_TITLE"]) != "" ? $arParams["VK_TITLE"] : GetMessage("IBLOCK_CSC_TAB_VK"),
			"CONTENT" => '
				<div id="vk_comments"></div>
				<script type="text/javascript">
					BX.load([\'https://vk.com/js/api/openapi.js?142\'], function(){
						if (!!window.VK)
						{
							VK.init({
								apiId: "'.(isset($arParams["VK_API_ID"]) && $arParams["VK_API_ID"] <> '' ? $arParams["VK_API_ID"] : "API_ID").'",
								onlyWidgets: true
							});

							VK.Widgets.Comments(
								"vk_comments",
								{
									pageUrl: "'.$arResult["URL_TO_COMMENT"].'",'.
									(isset($arParams["COMMENTS_COUNT"]) ? "limit: ".$arParams["COMMENTS_COUNT"]."," : "").
									(isset($arResult["WIDTH"]) ? "width: ".($arResult["WIDTH"] - 20)."," : "").
									'attach: false,
									pageTitle: BX.util.htmlspecialchars(document.title) || " ",
									pageDescription: " "
								}
							);
						}
					});
				</script>'
		);
	}

	if (!empty($arData))
	{
		$arTabsParams = array(
			"DATA" => $arData,
			"ID" => $templateData['TABS_ID']
		);

		$content = "";
		$activeTabId = "";
		$tabIDList = array();

        if ($arParams['EXTERNAL_TABS'] == 'N'):
?>
<div id="<? echo $templateData['TABS_FRAME_ID']; ?>" class="bx_soc_comments_div bx_important <? echo $templateData['TEMPLATE_CLASS']; ?>">
<div id="<? echo $templateData['TABS_ID']; ?>" class="bx-catalog-tab-section-container nav-container"<?=isset($arResult["WIDTH"]) ? ' style="width: '.$arResult["WIDTH"].'px;"' : ''?>>
    <div class="nav-wrap">
	<ul class="nav nav-tabs"><?
		foreach ($arData as $tabId => $arTab)
		{
			if (isset($arTab["NAME"]) && isset($arTab["CONTENT"]))
			{
				$id = $templateData['TABS_ID'].$tabId;
				$tabActive = (isset($arTab["ACTIVE"]) && $arTab["ACTIVE"] == "Y");
				?><li id="<?=$id?>"<?=($tabActive ? ' class="active"' : '')?>><a rel="nofollow" href="#<?=$id?>_cont" data-toggle="tab" aria-labelledby="<?=$id?>_cont-tab"><?=$arTab["NAME"]?></a></li><?
				if($tabActive || $activeTabId == "")
					$activeTabId = $tabId;

				$content .= '<div id="'.$id.'_cont" class="tab-pane'.($tabActive ? ' show active' : '').'" aria-labelledby="'.$id.'_cont-tab">'.$arTab["CONTENT"].'</div>';
				$tabIDList[] = $tabId;
			}
		}
		unset($tabId, $arTab);
	?></ul>
    </div>
	<div class="bx-catalog-tab-body-container">
		<div class="tab-content"><?=$content?></div>
	</div>
</div>
</div>
<?php
else:

        $arJSParams['settings']['facebook']['parentContID'] = $arParams['EXTERNAL_TABS_ID'];

		foreach ($arData as $tabId => $arTab)
		{
			if (isset($arTab["NAME"]) && isset($arTab["CONTENT"]))
			{
				$id = $templateData['TABS_ID'].$tabId;
				$tabActive = (isset($arTab["ACTIVE"]) && $arTab["ACTIVE"] == "Y" && $arParams['EXTERNAL_TABS_ACTIVE'] == 'N');
				?>
				<div
					class="tab-pane<?=($tabActive ? ' show active' : '')?>"
					id="<?=$id?>_cont"
					role="tabpanel"
					aria-labelledby="<?=$id?>_cont-tab">
					<?php
					$layout = new \Redsign\MegaMart\Layouts\Section();

					$layout
						->addModifier('bg-white')
						->addModifier('outer-spacing')
						->addData('TITLE', $arTab['NAME']);

					if ($tabId != 'BLOG')
					{
						$layout
							->addModifier('inner-spacing');
					}

					$layout->start();

					echo $arTab["CONTENT"];

					$layout->end();
					?>
				</div>
				<?php
				if($tabActive || $activeTabId == "")
					$activeTabId = $tabId;

				$content .= '';
				$tabIDList[] = $tabId;
			}
		}
		unset($tabId, $arTab);
endif;
?>

<?
		$arJSParams['tabs'] = array(
			'activeTabId' =>  $activeTabId,
			'tabsContId' => $templateData['TABS_ID'],
			'tabList' => $tabIDList
		);
?>
<script type="text/javascript">
var obCatalogComments_<? echo $arResult['ELEMENT']['ID']; ?> = new JCCatalogSocnetsComments(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script><?
	}
	else
	{
		ShowError(GetMessage("IBLOCK_CSC_NO_DATA"));
	}
}