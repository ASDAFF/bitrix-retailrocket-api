<?php
/**
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * @var string $mid
 */

if (!$USER->IsAdmin()) return;

\Bitrix\Main\Localization\Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/options.php');
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::IncludeModule("retailrocket");

$aTabs = array(
	array(
		'DIV' => 'edit1',
		'TAB' => GetMessage('MAIN_TAB_SET'),
		'ICON' => 'ib_settings',
		'TITLE' => GetMessage('MAIN_TAB_TITLE_SET')
	),
);
$tabControl = new CAdminTabControl('tabControl', $aTabs);

if ($_POST && check_bitrix_sessid()) {
	if (isset($_POST['option_partner_id'])) {
		\RetailRocket\Config::setPartnerId($_POST['option_partner_id']);
	}
}
$tabControl->Begin();
?>
<form method='post' action='<?php echo $APPLICATION->GetCurPage() ?>?mid=<?php echo $mid ?>&amp;lang=<?php echo LANGUAGE_ID ?>'>
	<?php $tabControl->BeginNextTab(); ?>
	<tr class='heading'>
		<td colspan='2'><?php echo GetMessage('RR_OPTIONS_SETTINGS') ?></td>
	</tr>
	<tr>
		<td width='40%'>
			<label><?php echo GetMessage('RR_OPTIONS_PARTNER_ID') ?>:</label>
		</td>
		<td width='60%'>
			<input name='option_partner_id' value="<?php echo \RetailRocket\Config::getPartnerId() ?>" style="width: 40%"/>
		</td>
	</tr>

	<?php $tabControl->Buttons(); ?>
	<input type='submit' name='Update' value='<?php echo GetMessage('MAIN_SAVE') ?>'
		   title='<?php echo GetMessage('MAIN_OPT_SAVE_TITLE') ?>' class='adm-btn-save'>
	<input type='submit' name='Apply' value='<?php echo GetMessage('MAIN_OPT_APPLY') ?>'
		   title='<?php echo GetMessage('MAIN_OPT_APPLY_TITLE') ?>'>
	<?php echo bitrix_sessid_post(); ?>
	<?php $tabControl->End(); ?>
</form>