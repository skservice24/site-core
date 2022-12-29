<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<div class="l-section l-section--bg-white l-section--outer-spacing">
	<div class="l-section__main box-shadow-1 p-6">
<? if (!empty($arResult["ORDER"])): ?>
		<div class="order-success-container">
			<div class="row mb-5 text-center">
				<div class="col">
					<?=Loc::getMessage("SOA_ORDER_SUC", array(
						"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->format('d.m.Y H:i'),
						"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
					))?>
					<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
						<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
							"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
						))?>
					<? endif ?>
				</div>
			</div>
			<div class="row mb-5 text-center">
				<div class="col">
					<?=Loc::getMessage("SOA_ORDER_SUC1", array("#LINK#" => $arParams["PATH_TO_PERSONAL"]))?>
				</div>
			</div>

			<?
			if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
			{
				if (!empty($arResult["PAYMENT"]))
				{
					foreach ($arResult["PAYMENT"] as $payment)
					{
						if ($payment["PAID"] != 'Y')
						{
							if (!empty($arResult['PAY_SYSTEM_LIST'])
								&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
							)
							{
								$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

								if (empty($arPaySystem["ERROR"]))
								{
									?>

									<div class="row mb-2">
										<div class="col">
											<h2 class="pay_name h4"><?=Loc::getMessage("SOA_PAY") ?></h2>
										</div>
									</div>
									<div class="row mb-2 align-items-center flex-nowrap">
										<div class="col"><strong><?=$arPaySystem["NAME"] ?></strong></div>
										<div class="col-3 col-sm-auto"><?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px;height:auto;\"", "", false) ?></div>
									</div>
									<div class="row mb-2">
										<div class="col">
											<? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
												$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
												$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
											<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
											<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
											<br/>
												<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
											<? endif ?>
											<? else: ?>
												<?=$arPaySystem["BUFFERED_OUTPUT"]?>
											<? endif ?>
										</div>
									</div>



									<?
								}
								else
								{
									?>
									<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
									<?
								}
							}
							else
							{
								?>
								<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
								<?
							}
						}
					}
				}
			}
			else
			{
				?>
				<div class="alert alert-danger" role="alert"><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></div>
				<?
			}
			?>

		<? else: ?>


			<div class="row mb-2">
				<div class="col">
					<div class="alert alert-danger" role="alert"><strong><?=Loc::getMessage("SOA_ERROR_ORDER")?></strong><br />
						<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?><br />
						<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></div>
				</div>
			</div>
<? endif ?>
	</div>
</div>
