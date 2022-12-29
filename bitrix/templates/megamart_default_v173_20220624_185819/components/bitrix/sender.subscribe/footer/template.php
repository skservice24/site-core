<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
	die();
}


use \Bitrix\Main\Localization\Loc;

$mainId = 'sender_subscribe_'.$this->randString();
$formId = $mainId.'_form';
$buttonId = $mainId.'_btn';
$rubricId = $mainId.'_rubric';
$containerId = $mainId.'_container';
?>
<div class="footer-subscribe" id="<?=$mainId?>">
	<? $frame = $this->createFrame($mainId, false)->begin(); ?>
	<?if(isset($arResult['MESSAGE'])): CJSCore::Init(array("popup"));?>
		<div id="<?=$containerId?>" style="display: none;">
			<div class="rsform">
				<div class="mt-6 d-flex align-items-center">
					<div class="d-block text-primary mr-4">
						<svg class="icon-svg" style="font-size: 2.5rem;"><use xlink:href="#svg-select-circle"></use></svg>
					</div>
					<div class="d-block">
						<?=htmlspecialcharsbx($arResult['MESSAGE']['TEXT'])?>
					</div>
				</div>
			</div>
		</div>
		<script>
			BX.ready(function(){
				RS.Utils.popup(
					BX('sender-subscribe-response-cont'),
					'window',
					{
                        'title': '<?=Loc::getMessage('subscr_form_response_'.$arResult['MESSAGE']['TYPE'])?>',
                        'afterShow': function () {
                            var replaceUrl = BX.util.remove_url_param(
                                window.location.href,
                                ['sender_subscription']
                            );

                            if (window.history.replaceState)
                            {
                                window.history.replaceState({}, null, replaceUrl);
                            }
                        }
					}
				);
			});
		</script>
	<?endif;?>

	<form id="<?=$formId?>" method="post" action="<?=$arResult["FORM_ACTION"]?>">
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="sender_subscription" value="add">

		<div style="display: none;">
			<?php foreach($arResult["RUBRICS"] as $itemID => $itemValue): ?>
			<div class="bx_subscribe_checkbox_container">
				<input class="d-none" type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]" id="<?=$rubricId.'_'.$itemValue['ID']?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?>>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="form-inline flex-nowrap">
			<input class="form-control flex-grow-1 w-auto footer-subscribe__input" type="email" name="SENDER_SUBSCRIBE_EMAIL" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" placeholder="<?=htmlspecialcharsbx(GetMessage('subscr_form_email_title'))?>">
			<button class="footer-subscribe__button d-flex align-items-center" id="<?=$buttonId?>">
				<svg class="icon-svg"><use xlink:href="#svg-mail"></use></svg>
				<span class="d-none"><?=Loc::getMessage("subscr_form_button")?></span>
			</button>
		</div>

		<?php if ($arParams['USER_CONSENT'] == 'Y'): ?>
		<div class="bx_subscribe_checkbox_container bx-sender-subscribe-agreement position-absolute invisible">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.userconsent.request",
				"",
				array(
					"ID" => $arParams["USER_CONSENT_ID"],
					"IS_CHECKED" => 'N',
					"AUTO_SAVE" => "Y",
					'INPUT_NAME' => 'CONSENT',
					"IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
					"ORIGIN_ID" => "sender/sub",
					"ORIGINATOR_ID" => "",
					"REPLACE" => array(
						"button_caption" => Loc::getMessage("subscr_form_button"),
						"fields" => array(Loc::getMessage("subscr_form_email_title"))
					),
				)
			);?>
		</div>
		<?php endif; ?>

		<?php if (!empty($arParams['RS_NOTE_TEXT'])): ?>
			<div class="footer-subscribe__note">
				<?=$arParams['RS_NOTE_TEXT']?>
			</div>
		<?php endif; ?>
	</form>
	<?php $frame->beginStub(); ?>
	<?if(isset($arResult['MESSAGE'])): CJSCore::Init(array("popup"));?>
		<div id="<?=$containerId?>" style="display: none;">
			<div class="rsform">
				<div class="mt-6 d-flex align-items-center">
					<div class="d-block text-primary mr-4">
						<svg class="icon-svg" style="font-size: 2.5rem;"><use xlink:href="#svg-select-circle"></use></svg>
					</div>
					<div class="d-block">
						<?=htmlspecialcharsbx($arResult['MESSAGE']['TEXT'])?>
					</div>
				</div>
			</div>
		</div>
		<script>
			BX.ready(function(){
				RS.Utils.popup(
					BX('sender-subscribe-response-cont'),
					'window',
					{
						'title': '<?=Loc::getMessage('subscr_form_response_'.$arResult['MESSAGE']['TYPE'])?>'
					}
				);
			});
		</script>
	<?endif;?>

	<form id="<?=$formId?>" method="post" action="<?=$arResult["FORM_ACTION"]?>">
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="sender_subscription" value="add">

		<div style="display: none;">
			<?php foreach($arResult["RUBRICS"] as $itemID => $itemValue): ?>
			<div class="bx_subscribe_checkbox_container">
				<input class="d-none" type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]" id="<?=$rubricId.'_'.$itemValue['ID']?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?>>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="form-inline flex-nowrap">
			<input class="form-control flex-grow-1 w-auto footer-subscribe__input" type="email" name="SENDER_SUBSCRIBE_EMAIL" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" placeholder="<?=htmlspecialcharsbx(GetMessage('subscr_form_email_title'))?>">
			<button class="footer-subscribe__button d-flex align-items-center" id="<?=$buttonId?>">
				<svg class="icon-svg"><use xlink:href="#svg-mail"></use></svg>
				<span class="d-none"><?=Loc::getMessage("subscr_form_button")?></span>
			</button>
		</div>

		<?php if ($arParams['USER_CONSENT'] == 'Y'): ?>
		<div class="bx_subscribe_checkbox_container bx-sender-subscribe-agreement position-absolute invisible">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.userconsent.request",
				"",
				array(
					"ID" => $arParams["USER_CONSENT_ID"],
					"IS_CHECKED" => 'N',
					"AUTO_SAVE" => "Y",
					'INPUT_NAME' => 'CONSENT',
					"IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
					"ORIGIN_ID" => "sender/sub",
					"ORIGINATOR_ID" => "",
					"REPLACE" => array(
						"button_caption" => Loc::getMessage("subscr_form_button"),
						"fields" => array(Loc::getMessage("subscr_form_email_title"))
					),
				)
			);?>
		</div>
		<?php endif; ?>

		<?php if (!empty($arParams['RS_NOTE_TEXT'])): ?>
			<div class="footer-subscribe__note">
				<?=$arParams['RS_NOTE_TEXT']?>
			</div>
		<?php endif; ?>
	</form>
	<?php $frame->end(); ?>
</div>
