<?
$disabled = '';
$readonly = 'readonly';
$nofocus = 'nofocus';
//if($_SESSION['RGadmin']['access']['settings']['payroll'] == 0){$disabled = 'disabled';}
//var_dump(unserialize('a:2:{s:2:"en";a:3:{s:2:"NP";s:11:"no Position";s:3:"DES";s:8:"Designer";s:3:"DEV";s:10:"Develloper";}s:2:"th";a:3:{s:2:"NP";s:36:"ไม่มีตำแหน่ง";s:3:"DES";s:9:"-Designer";s:3:"DEV";s:11:"-Develloper";}}'));
$daysCalc = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

$sql1 = "SELECT * FROM rego_default_shiftplans ";
if ($res1 = $dba->query($sql1)) {
	while ($row1 = $res1->fetch_assoc()) {


		$shiftplandata[] = $row1;
	}
}

$payrollmdls = array();
$sqlv = "SELECT * FROM rego_payroll_models WHERE apply = '1'";
if ($resv = $dba->query($sqlv)) {
	while ($rowv = $resv->fetch_assoc()) {
		$payrollmdls[$rowv['id']] = $rowv['name'];
	}
}

$varAllowDeduct = array();
$sqlv = "SELECT * FROM rego_allow_deduct WHERE apply = '1' AND man_att='1'";
if ($resv = $dba->query($sqlv)) {
	while ($rowv = $resv->fetch_assoc()) {
		$varAllowDeduct[] = $rowv;
	}
}

$data_income = array();
$sqldi = "SELECT * FROM rego_allow_deduct WHERE apply = '1' AND hour_daily_rate='1'";
if ($resdi = $dba->query($sqldi)) {
	while ($rowdi = $resdi->fetch_assoc()) {
		$data_income[] = $rowdi;
	}
}

$settings = array();
if ($res = $dba->query("SELECT * FROM rego_default_settings")) {
	$settings = $res->fetch_assoc();
	$prefixValue =  unserialize($settings['id_prefix']);

	$periods_defaults =  unserialize($settings['periods_defaults']);
	$manualrates_default =  unserialize($settings['manualrates_default']);
	$emp_grpDefaults =  unserialize($settings['emp_grp']);
}
//var_dump($settings); exit;
$sso_defaults =  unserialize($settings['sso_defaults']);

$fix_allow = unserialize($settings['fix_allow']);
$var_allow = unserialize($settings['var_allow']);
if (empty($fix_allow)) {
	$fix_allow = array();
}
if (empty($var_allow)) {
	$var_allow = array();
}
//var_dump($fix_allow);
//var_dump($var_allow);

$fix_deduct = unserialize($settings['fix_deduct']);
$var_deduct = unserialize($settings['var_deduct']);

$taxrules = unserialize($settings['taxrules']);
//var_dump($taxrules);
$tax_settings_description = unserialize($settings['tax_settings_description']);

$tax_settings = unserialize($settings['tax_settings']);
//var_dump($tax_settings);
$tax_info_th = unserialize($settings['tax_info_th']);
//var_dump($tax_info_th);
$tax_info_en = unserialize($settings['tax_info_en']);
//var_dump($tax_info_en);
$tax_err_th = unserialize($settings['tax_err_th']);
//var_dump($tax_err_th);
$tax_err_en = unserialize($settings['tax_err_en']);
//var_dump($tax_err_en);
$payslip = unserialize($settings['payslip_field']);
//var_dump($payslip);

$positions = unserialize($settings['positions']);
if ($positions) {
	$pos_count = count($positions['th']);
} else {
	$pos_count = 0;
}
//unset($positions['en'][2]);
//unset($positions['th'][2]);
//var_dump($positions); exit;



?>

<style>
	*:disabled {
		cursor: default !important;
	}

	table.basicTable td.info {
		color: #006699;
		font-style: italic;
	}

	#tab_taxsettings .descri_info {
		width: 100%;
		text-align: right;
		border: none;
		color: #058;
		font-weight: bold;
	}

	#tab_manualrate .inptbkg {
		background: #f9f7dd !important;
	}
</style>


<h2><i class="fa fa-cogs"></i>&nbsp;&nbsp;<?= $lng['Default employee setting'] ?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?= $lng['Data is not updated to last changes made'] ?></span></h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

	<form id="payrollForm" style="height:100%">

		<ul class="nav nav-tabs" id="myTab">

			<li class="nav-item"><a class="nav-link active" data-target="#tab_defaults" data-toggle="tab"><?= $lng['Employee defaults'] ?></a></li>

		</ul>

		<button class="btn btn-primary" style="margin:0; position:absolute; top:15px; right:16px;" id="submitbtn" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?= $lng['Update'] ?></button>

		<div class="tab-content" style="height:calc(100% - 40px)">



			<div class="tab-pane active" id="tab_defaults">
				<div class="tab-content-left">
					<div style="overflow-x:auto">
						<table class="basicTable inputs" border="0">
							<thead>
								<tr style="line-height:100%">
									<th colspan="2"><?= $lng['Employee ID'] ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $lng['Automatic numbering'] ?></th>
									<td>
										<select name="auto_id" style="width:100%">
											<? foreach ($noyes01 as $k => $v) {
												echo '<option ';
												if ($settings['auto_id'] == $k) {
													echo 'selected';
												}
												echo ' value="' . $k . '">' . $v . '</option>';
											} ?>
										</select>
									</td>
								</tr>
								<!-- 	<tr>
										<th>
											<i data-toggle="tooltip" title="Max. 4 digits" class="fa fa-exclamation-circle fa-lg fa-mr"></i><?= $lng['Start at'] ?>
										</th>
										<td>
											<input placeholder="0001" maxlength="4" class="sel numeric" type="text" name="id_start" value="<?= $settings['id_start'] ?>">
										</td>
									</tr> -->
								<tr>
									<th>
										<!-- <i data-toggle="tooltip" title="Max. 3 characters separated by comma" class="fa fa-exclamation-circle fa-lg fa-mr"></i> -->
										<?= $lng['Prefix'] ?>
									</th>
									<td>
										<!-- <input maxlength="39" placeholder="EMP,OFF,OPE ..." type="text" name="id_prefix" value="<?= $settings['id_prefix'] ?>"> -->
										<select style="width: 79%;" id="id_prefix_select">
											<? if (isset($prefixValue)) {
												foreach ($prefixValue as $k => $v) { ?>
													<option value="<?php echo $k; ?>"><?php echo $k . ' - ' . $v['startCount']; ?></option>
											<?php }
											} ?>

										</select>

										<button style="width: 10%;" class="btn btn-primary " id="addPrefix" type="button"><i class="fa fa-plus"></i></button>
										<button style="width: 10%;" class="btn btn-primary " id="editPrefix" type="button"><i class="fa fa-pencil-square-o"></i></button>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Scan ID'] ?></th>
									<td>
										<select name="scan_id" style="width:100%">
											<option <? if ($settings['scan_id'] == 0) {
														echo 'selected';
													} ?> value="0"><?= $lng['Empty'] ?></option>
											<option <? if ($settings['scan_id'] == 1) {
														echo 'selected';
													} ?> value="1"><?= $lng['Same employee ID'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="line-height:10px">&nbsp;</td>
								</tr>
							</tbody>
							<thead>
								<tr style="line-height:100%">
									<th colspan="2"><?= $lng['Other settings'] ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $lng['Joining date'] ?></th>
									<td>
										<select name="joining_date" style="width:100%">
											<option <? if ($settings['joining_date'] == 0) {
														echo 'selected';
													} ?> value="0"><?= $lng['Current date'] ?> : <?= date('d-m-Y') ?></option>
											<option <? if ($settings['joining_date'] == 1) {
														echo 'selected';
													} ?> value="1"><?= $lng['Empty'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Team'] ?></th>
									<td>
										<select name="default_team" style="width:100%">
											<option value="select">Select</option>
											<option <? if ($settings['default_team'] == $emp_grpDefaults['team']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['team']['code']; ?>"><?php echo $emp_grpDefaults['team']['en']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Company'] ?></th>
									<td>
										<select name="entity" style="width:100%">
											<option value="select">Select</option>
											<option <? if ($settings['entity'] == $emp_grpDefaults['company']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['company']['code']; ?>"><?php echo $emp_grpDefaults['company']['en']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Location'] ?></th>
									<td>
										<select name="location" style="width:100%">
											<option value="select">Select</option>
											<option <? if ($settings['location'] == $emp_grpDefaults['location']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['location']['code']; ?>"><?php echo $emp_grpDefaults['location']['en']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Division'] ?></th>
									<td>
										<select name="division" style="width:100%">
											<option value="select">Select</option>
											<option <? if ($settings['division'] == $emp_grpDefaults['division']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['division']['code']; ?>"><?php echo $emp_grpDefaults['division']['en']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Department'] ?></th>
									<td>
										<select name="department" style="width:100%">
											<option value="select">Select</option>
											<option <? if ($settings['department'] == $emp_grpDefaults['department']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['department']['code']; ?>"><?php echo $emp_grpDefaults['department']['en']; ?></option>
										</select>
									</td>
								</tr>
								<!-- <tr>
										<th><?= $lng['Employee group'] ?></th>
										<td>
											<select name="emp_group" style="width:100%">
												<? foreach ($emp_groep as $k => $v) { ?>
													<option <? if ($settings['emp_group'] == $k) {
																echo 'selected';
															} ?> value="<?= $k ?>"><?= $v ?></option>
												<? } ?>
											</select>
										</td>
									</tr> -->
								<tr>
									<th><?= $lng['Employee type'] ?></th>
									<td>
										<select name="emp_type" style="width:100%">
											<? foreach ($emp_type as $k => $v) { ?>
												<option <? if ($settings['emp_type'] == $k) {
															echo 'selected';
														} ?> value="<?= $k ?>"><?= $v ?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Employee status'] ?></th>
									<td>
										<select name="emp_status" style="width:100%">
											<option <? if ($settings['emp_status'] == 1) {
														echo 'selected';
													} ?> value="1"><?= $lng['Active'] ?></option>
											<option <? if ($settings['emp_status'] == 0) {
														echo 'selected';
													} ?> value="0"><?= $lng['on Hold / Canceled'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Accounting code'] ?></th>
									<td>
										<select name="account_code" style="width:100%">
											<option <? if ($settings['account_code'] == 0) {
														echo 'selected';
													} ?> value="0"><?= $lng['Indirect'] ?></option>
											<option <? if ($settings['account_code'] == 1) {
														echo 'selected';
													} ?> value="1"><?= $lng['Direct'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Position'] ?></th>
									<td>
										<select name="position" style="width:100%">
											<option value="1"><?= $lng['no Position'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Date start Position'] ?></th>
									<td>
										<select name="date_start" style="width:100%">
											<option <? if ($settings['date_start'] == 0) {
														echo 'selected';
													} ?> value="0">Joining date : <?= date('d-m-Y') ?></option>
											<option <? if ($settings['date_start'] == 1) {
														echo 'selected';
													} ?> value="1">Empty</option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Time registration'] ?></th>
									<td>
										<select name="time_reg" style="width:100%">
											<? foreach ($noyes01 as $k => $v) {
												echo '<option ';
												if ($settings['time_reg'] == $k) {
													echo 'selected';
												}
												echo ' value="' . $k . '">' . $v . '</option>';
											} ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Take selfie'] ?></th>
									<td>
										<select name="selfie" style="width:100%">
											<? foreach ($noyes01 as $k => $v) {
												echo '<option ';
												if ($settings['selfie'] == $k) {
													echo 'selected';
												}
												echo ' value="' . $k . '">' . $v . '</option>';
											} ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Anual leave days'] ?></th>
									<td>
										<input class="sel numeric" type="text" name="leeve" placeholder="__" value="<?= $settings['leeve'] ?>">
									</td>
								</tr>
								<tr>
									<th><?= $lng['Payment type'] ?></th>
									<td>
										<select name="pay_type" style="width:100%">
											<option value=""><?= $lng['Empty'] ?></option>
											<option <? if ($settings['pay_type'] == 'cash') {
														echo 'selected';
													} ?> value="cash"><?= $lng['Cash'] ?></option>
											<option <? if ($settings['pay_type'] == 'cheque') {
														echo 'selected';
													} ?> value="cheque"><?= $lng['Cheque'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
								<th><?= $lng['Tax ID no.'] ?>(<?= $lng['Same as ID card no'] ?>)</th>
								<td class="pl-2">

								<input style="margin-left: 10px;" class="checkbox-custom-blue-2 checkbox-blue-custom-white" type="checkbox" id="tax_id_checkbox" onclick="checkTheBoxtaxId(this);" <? if ($settings['tax_id_check'] == 1) {
								echo 'checked';
								} ?>>

								<input type="hidden" name="tax_id_check" id="tax_id_check" value="<?= $settings['tax_id_check'] ? $settings['tax_id_check'] : '0'; ?>">
								</td>
								</tr>

								<tr>
								<th><?= $lng['SSO ID no.'] ?>(<?= $lng['Same as ID card no'] ?>)</th>
								<td class="pl-2">
								<input style="margin-left: 10px;" class="checkbox-custom-blue-2 checkbox-blue-custom-white" type="checkbox" id="sso_id_checkbox" onclick="checkTheBox(this);" <? if ($settings['sso_id_check'] == 1) {
								echo 'checked';
								} ?>>
								<input type="hidden" name="sso_id_check" id="sso_id_check" value="<?= $settings['sso_id_check'] ? $dsettingsata['sso_id_check'] : '0'; ?>">
								</td>
								</tr>
							</tbody>

						</table>
					</div>
				</div>

				<div class="tab-content-right">
					<div style="overflow-x:auto">
						<table class="basicTable inputs" border="0">
							<thead>
								<tr style="line-height:100%">
									<th colspan="2"><?= $lng['Pension fund'] ?> (PSF) / <?= $lng['Provident fund'] ?> (PVF)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $lng['Calculate PSF'] ?></th>
									<td>
										<select name="calc_psf" style="width:100%">
											<? foreach ($noyes01 as $k => $v) {
												echo '<option ';
												if ($settings['calc_psf'] == $k) {
													echo 'selected';
												}
												echo ' value="' . $k . '">' . $v . '</option>';
											} ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['PSF rate employee'] ?></th>
									<td><input class="sel numeric" type="text" name="psf_rate_emp" placeholder="__" value="<?= $settings['psf_rate_emp'] ?>"></td>
								</tr>
								<tr>
									<th><?= $lng['PSF rate employer'] ?></th>
									<td><input class="sel numeric" type="text" name="psf_rate_com" placeholder="__" value="<?= $settings['psf_rate_com'] ?>"></td>
								</tr>
								<tr>
									<th><?= $lng['Calculate PVF'] ?></th>
									<td>
										<select name="calc_pvf" style="width:100%">
											<? foreach ($noyes01 as $k => $v) {
												echo '<option ';
												if ($settings['calc_pvf'] == $k) {
													echo 'selected';
												}
												echo ' value="' . $k . '">' . $v . '</option>';
											} ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['PVF rate employee'] ?></th>
									<td><input class="sel numeric" type="text" name="pvf_rate_emp" placeholder="__" value="<?= $settings['pvf_rate_emp'] ?>"></td>
								</tr>
								<tr>
									<th><?= $lng['PVF rate employer'] ?></th>
									<td><input class="sel numeric" type="text" name="pvf_rate_com" placeholder="__" value="<?= $settings['pvf_rate_com'] ?>"></td>
								</tr>
								<tr>
									<td style="line-height:10px">&nbsp;</td>
								</tr>
							</tbody>
							<thead>
								<tr style="line-height:100%">
									<th colspan="2"><?= $lng['Financial'] ?> / <?= $lng['Tax'] ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $lng['Tax calculation method'] ?></th>
									<td>
										<select name="calc_method" style="width:100%">
											<option <? if ($settings['calc_method'] == 'cam') {
														echo "selected";
													} ?> value="cam"><?= $lng['Calculate in Advance Method'] ?> (CAM)</option>
											<option <? if ($settings['calc_method'] == 'acm') {
														echo "selected";
													} ?> value="acm"><?= $lng['Accumulative Calculation Method'] ?> (ACM)</option>
											<option <? if ($settings['calc_method'] == 'ytd') {
														echo "selected";
													} ?> value="ytd"><?= $lng['Year To Date'] ?> (YTD)</option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Calculate Tax'] ?></th>
									<td>
										<select name="calc_tax" style="width:100%">
											<option <? if ($settings['calc_tax'] == '1') {
														echo 'selected';
													} ?> value="1"><?= $lng['PND'] ?> 1</option>
											<option <? if ($settings['calc_tax'] == '3') {
														echo 'selected';
													} ?> value="3"><?= $lng['PND'] ?> 3</option>
											<option <? if ($settings['calc_tax'] == '0') {
														echo 'selected';
													} ?> value="0"><?= $lng['no Tax'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Calculate SSO'] ?></th>
									<td>
										<select name="calc_sso" style="width:100%">
											<? foreach ($noyes01 as $k => $v) {
												echo '<option ';
												if ($settings['calc_tax'] == $k) {
													echo 'selected';
												}
												echo ' value="' . $k . '">' . $v . '</option>';
											} ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Contract type'] ?></th>
									<td>
										<select name="contract_type" style="width:100%">
											<option <? if ($settings['contract_type'] == 'month') {
														echo 'selected';
													} ?> value="month"><?= $lng['Monthly wage'] ?></option>
											<option <? if ($settings['contract_type'] == 'day') {
														echo 'selected';
													} ?> value="day"><?= $lng['Daily wage'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Calculation base'] ?></th>
									<td>
										<select name="calc_base" style="width:100%">
											<option <? if ($settings['calc_base'] == 'gross') {
														echo 'selected';
													} ?> value="gross"><?= $lng['Gross amount'] ?></option>
											<option <? if ($settings['calc_base'] == 'net') {
														echo 'selected';
													} ?> value="net"><?= $lng['Net amount'] ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Base OT rate'] ?></th>
									<td>
										<select name="base_ot_rate" style="width:100%">
											<option <? if ($settings['base_ot_rate'] == 'cal') {
														echo 'selected';
													} ?> value="cal"><?= $lng['Calculated'] ?></option>
											<option <? if ($settings['base_ot_rate'] == 'fix') {
														echo 'selected';
													} ?> value="fix"><?= $lng['Fixed'] ?></option>
										</select>
									</td>

								</tr>
								<tr>
									<th><?= $lng['OT rate'] ?></th>
									<td><input class="sel numeric" type="text" name="ot_rate" placeholder="__" value="<?= $settings['ot_rate'] ?>"></td>
								</tr>
								<tr>
									<th><?= $lng['Payroll calculator model'] ?></th>
									<td>
										<select name="payroll_modal_value" style="width:100%">
											<? foreach ($payrollmdls as $k => $v) { ?>
												<option value="<?= $k ?>"><?= $v ?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</tbody>
							<thead>
								<tr style="line-height:100%">
									<th colspan="2"><?= $lng['Responsibilities'] ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th><?= $lng['Head of Location'] ?></th>
									<td>
										<select name="headoflocation" style="width:100%">
											<option <? if ($settings['headoflocation'] == 'noresp') {
														echo 'selected';
													} ?> value="noresp"><?= $lng['No Responsibility'] ?></option>
											<option <? if ($settings['headoflocation'] == $emp_grpDefaults['location']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['location']['code']; ?>"><?php echo $emp_grpDefaults['location']['en']; ?></option>

										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Head of division'] ?></th>
									<td>
										<select name="headofdivision" style="width:100%">
											<option <? if ($settings['headofdivision'] == 'noresp') {
														echo 'selected';
													} ?> value="noresp"><?= $lng['No Responsibility'] ?></option>
											<option <? if ($settings['headofdivision'] == $emp_grpDefaults['division']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['division']['code']; ?>"><?php echo $emp_grpDefaults['division']['en']; ?></option>

										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Head of department'] ?></th>
									<td>
										<select name="headofdepartment" style="width:100%">
											<option <? if ($settings['headofdepartment'] == 'noresp') {
														echo 'selected';
													} ?> value="noresp"><?= $lng['No Responsibility'] ?></option>
											<option <? if ($settings['headofdepartment'] == $emp_grpDefaults['department']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['department']['code']; ?>"><?php echo $emp_grpDefaults['department']['en']; ?></option>

										</select>
									</td>
								</tr>
								<tr>
									<th><?= $lng['Team supervisor'] ?></th>
									<td>
										<select name="headofsupervisor" style="width:100%">
											<option <? if ($settings['headofsupervisor'] == 'noresp') {
														echo 'selected';
													} ?> value="noresp"><?= $lng['No Responsibility'] ?></option>
											<option <? if ($settings['headofsupervisor'] == $emp_grpDefaults['team']['code']) {
														echo 'selected';
													} ?> value="<?php echo $emp_grpDefaults['team']['code']; ?>"><?php echo $emp_grpDefaults['team']['en']; ?></option>

										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
	</form>
</div>





<!------ modify add Modal  -------->
<div class="modal fade" id="addPrefixModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?= $lng['Add Prefix Data'] ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab">
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?= $lng['Enter Data'] ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?= $lng['Prefix'] ?></th>
								<td>
									<input style="width: 79%" maxlength="39" placeholder="EMP" type="text" name="id_prefix" id="id_prefix" value="">
								</td>
							</tr>
							<tr>
								<th class="tal"><?= $lng['Start at'] ?></th>
								<td>
									<input placeholder="1000" maxlength="4" class="sel numeric" type="text" name="id_start" id="id_start" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
					<div>
						<button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id=""><?= $lng['Cancel'] ?></button>
						<button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalAdd();"><?= $lng['Submit'] ?></button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify add Modal  -------->
<div class="modal fade" id="editPrefixModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?= $lng['Edit Prefix Data'] ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab">
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?= $lng['Update Data'] ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?= $lng['Prefix'] ?></th>
								<td>
									<input class="id_prefix" style="width: 79%" maxlength="39" placeholder="EMP" type="text" name="id_prefix" id="id_prefix" value="">
									<input type="hidden" name="keyToUpdate" class="keyToUpdate" value="">
								</td>
							</tr>
							<tr>
								<th class="tal"><?= $lng['Start at'] ?></th>
								<td>
									<input class="id_start" placeholder="1000" maxlength="4" class="sel numeric" type="text" name="id_start" id="id_start" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
					<div>
						<button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id=""><?= $lng['Cancel'] ?></button>
						<button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEdit();"><?= $lng['Update'] ?></button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


<script>
	var height = window.innerHeight - 265;

	function hrsOption(that, id) {

		if ($(that).attr('checked', true)) {
			$('#calcOpt' + id).attr('disabled', false).css('visibility', 'visible').addClass('inptbkg');
			$('#multiplicator' + id).attr('disabled', false).addClass('inptbkg');
			$('#nrhrs' + id).attr('disabled', false).addClass('inptbkg').attr('placeholder', '000:00');
			$('#incomeBase' + id).attr('disabled', false);
			$('#incomeBase' + id + ' option[value="56"]').attr('selected', true);
			$('input[name="income_base[' + id + ']"]').val(56);
			$('#incomeBase' + id).closest('div.SumoSelect').removeClass('disabled');
			$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'visible');
			$(".hourFormat").mask("999:99", {
				placeholder: "000:00"
			});

			//==== For Times 
			if ($('#times' + id).prop('checked')) {
				$('#thbunit' + id).attr('disabled', false).addClass('inptbkg');
				$('#unitarr' + id).attr('disabled', false).css('visibility', 'visible').addClass('inptbkg');
			} else {
				$('#thbunit' + id).attr('disabled', true).removeClass('inptbkg');
				$('#unitarr' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
			}

		} else {
			$('#multiplicator' + id).attr('disabled', true).removeClass('inptbkg');
			$('#calcOpt' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
			$('#nrdays' + id).attr('disabled', true).removeClass('inptbkg');
			$('#nrhrs' + id).attr('disabled', true).removeClass('inptbkg').val('').attr('placeholder', '');
			$('#incomeBase' + id).attr('disabled', true).val('');
			$('#incomeBase' + id).attr('selected', false);
			$('#incomeBase' + id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'hidden');
		}

		if ($(that).is(':not(:checked)')) {
			$('#multiplicator' + id).attr('disabled', true).removeClass('inptbkg').val('');
			$('#calcOpt' + id).attr('disabled', true).css('visibility', 'hidden').removeClass('inptbkg');
			$('#nrdays' + id).attr('disabled', true).removeClass('inptbkg').val('');
			$('#nrhrs' + id).attr('disabled', true).removeClass('inptbkg').val('').attr('placeholder', '');
			$('#incomeBase' + id).attr('disabled', true).val('');
			$('input[name="income_base[' + id + ']"]').val('');
			$('#incomeBase' + id).attr('selected', false);
			$('#incomeBase' + id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'hidden');
		}
	}

	function timesOption(that, id) {

		if ($(that).attr('checked', true)) {

			$('#thbunit' + id).attr('disabled', false).addClass('inptbkg');
			$('#unitarr' + id).attr('disabled', false).css('visibility', 'visible').addClass('inptbkg');

			//==== For Hrs 
			if ($('#hrs' + id).prop('checked')) {

				$('#calcOpt' + id).attr('disabled', false).css('visibility', 'visible').addClass('inptbkg');
				$('#multiplicator' + id).attr('disabled', false).addClass('inptbkg');
				$('#nrhrs' + id).attr('disabled', false).addClass('inptbkg').attr('placeholder', '000:00');
				$('#incomeBase' + id).attr('disabled', false);
				$('#incomeBase' + id + ' option[value="56"]').attr('selected', true);
				$('input[name="income_base[' + id + ']"]').val(56);
				$('#incomeBase' + id).closest('div.SumoSelect').removeClass('disabled');
				$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'visible');
				$(".hourFormat").mask("999:99", {
					placeholder: "000:00"
				});

			} else {

				$('#multiplicator' + id).attr('disabled', true).removeClass('inptbkg');
				$('#calcOpt' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
				$('#nrdays' + id).attr('disabled', true).removeClass('inptbkg').val('');
				$('#nrhrs' + id).attr('disabled', true).removeClass('inptbkg').val('').attr('placeholder', '');
				$('#incomeBase' + id).attr('disabled', true).val('');
				$('#incomeBase' + id).attr('selected', false);
				$('#incomeBase' + id).closest('div.SumoSelect').addClass('disabled');
				$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'hidden');
			}


		} else {
			$('#thbunit' + id).attr('disabled', true).removeClass('inptbkg');
			$('#unitarr' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
		}

		if ($(that).is(':not(:checked)')) {

			$('#thbunit' + id).attr('disabled', true).removeClass('inptbkg').val('');
			$('#unitarr' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
		}
	}


	function thbOption(that, id) {
		if ($(that).attr('checked', true)) {
			$('#calcOpt' + id).attr('disabled', true).css('visibility', 'hidden').removeClass('inptbkg');
			$('#nrdays' + id).attr('disabled', true).removeClass('inptbkg');
			$('#nrhrs' + id).attr('disabled', false).removeClass('inptbkg').attr('placeholder', '');
			$('#multiplicator' + id).attr('disabled', true).removeClass('inptbkg');
			$('#incomeBase' + id).attr('disabled', true);
			$('#incomeBase' + id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'hidden');
			$('#incomeBase' + id).closest('input[name="income_base[' + id + ']"]');

			$('#thbunit' + id).attr('disabled', true).removeClass('inptbkg');
			$('#unitarr' + id).attr('disabled', true).css('visibility', 'hidden').removeClass('inptbkg');

			//==== For Hrs 
			if ($('#hrs' + id).prop('checked')) {
				$('#calcOpt' + id).attr('disabled', false).css('visibility', 'visible').addClass('inptbkg');
				$('#multiplicator' + id).attr('disabled', false).addClass('inptbkg');
				$('#nrdays' + id).attr('disabled', false).removeClass('inptbkg');
				$('#nrhrs' + id).attr('disabled', false).addClass('inptbkg').attr('placeholder', '000:00');
				$('#incomeBase' + id).attr('disabled', false);
				$('#incomeBase' + id + ' option[value="56"]').attr('selected', true);
				$('input[name="income_base[' + id + ']"]').val(56);
				$('#incomeBase' + id).closest('div.SumoSelect').removeClass('disabled');
				$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'visible');
				$(".hourFormat").mask("999:99", {
					placeholder: "000:00"
				});

			} else {

				$('#multiplicator' + id).attr('disabled', true).removeClass('inptbkg');
				$('#calcOpt' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
				$('#nrdays' + id).attr('disabled', true).removeClass('inptbkg');
				$('#nrhrs' + id).attr('disabled', true).removeClass('inptbkg').val('').attr('placeholder', '');
				$('#incomeBase' + id).attr('disabled', true).val('');
				$('#incomeBase' + id).attr('selected', false);
				$('#incomeBase' + id).closest('div.SumoSelect').addClass('disabled');
				$('#incomeBase' + id).closest('div.SumoSelect').css('visibility', 'hidden');
			}

			//==== For Times 
			if ($('#times' + id).prop('checked')) {
				$('#thbunit' + id).attr('disabled', false).addClass('inptbkg');
				$('#unitarr' + id).attr('disabled', false).css('visibility', 'visible').addClass('inptbkg');
			} else {
				$('#thbunit' + id).attr('disabled', true).removeClass('inptbkg');
				$('#unitarr' + id).attr('disabled', true).val('').css('visibility', 'hidden').removeClass('inptbkg');
			}
		}
	}

	function calcoptsel(that, id) {
		if (that == 3) {
			$('#nrdays' + id).attr('readonly', false).attr('disabled', false).addClass('inptbkg');
			$('#nrhrs' + id).attr('readonly', false).attr('disabled', false).addClass('inptbkg');
		} else {

			if (that == 1) {
				var calcdays = <?= $daysCalc; ?>;
				$('#nrdays' + id).attr('readonly', false).removeClass('inptbkg');
				$('#nrdays' + id).val(calcdays);
			} else {
				$('#nrdays' + id).attr('readonly', false).removeClass('inptbkg');
				$('#nrdays' + id).val(30);
			}

		}
	}

	$(document).ready(function() {

		var posi = <?= json_encode($pos_count + 1) ?>;
		var getAttendAllowDeduct = <?= json_encode($varAllowDeduct) ?>;

		$("#addposition").click(function() {
			var addrow = '<tr><td><b><input name="positions[' + posi + '][code]" type="text" value="' + posi + '" /></b></td><td><input placeholder="<?= $lng['Thai description'] ?>" name="positions[' + posi + '][th]" type="text" /></td><td><input placeholder="<?= $lng['English description'] ?>" name="positions[' + posi + '][en]" type="text" /></td><td></td></tr>';
			if (posi == 1) {
				$("#position_table tbody").html(addrow);
			} else {
				$("#position_table tr:last").after(addrow);
			}
			posi++;
		});

		$('.xdatepick').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			orientation: 'auto bottom',
			language: lang,
			todayHighlight: true,
			startView: 'year',
			//startDate : startYear,
			//endDate   : endYear
		})

		$('.send').on('change', function() {
			var m = $(this).data('m') + 1;
			var parts = this.value.split('-');
			var d = parts[2] + '-' + parts[1] + '-' + parts[0];
			var today = moment(d);
			var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
			if (m <= 12) {
				$('.sstart' + m).val(tomorrow);
			}
		})
		$('.tend').on('change', function() {
			var m = $(this).data('m') + 1;
			var parts = this.value.split('-');
			var d = parts[2] + '-' + parts[1] + '-' + parts[0];
			var today = moment(d);
			var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
			if (m <= 12) {
				$('.tstart' + m).val(tomorrow);
			}
		})
		$('.lend').on('change', function() {
			var m = $(this).data('m') + 1;
			var parts = this.value.split('-');
			var d = parts[2] + '-' + parts[1] + '-' + parts[0];
			var today = moment(d);
			var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
			if (m <= 12) {
				$('.lstart' + m).val(tomorrow);
			}
		})
		$('.pend').on('change', function() {
			var m = $(this).data('m') + 1;
			var parts = this.value.split('-');
			var d = parts[2] + '-' + parts[1] + '-' + parts[0];
			var today = moment(d);
			var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
			if (m <= 12) {
				$('.pstart' + m).val(tomorrow);
			}
		})


		$(getAttendAllowDeduct).each(function(k, v) {

			if (v.man_att == 1) {
				//console.log(v);
				$('#incomeBase' + v.id).SumoSelect({
					placeholder: '<?= $lng['Select'] . ' ' . $lng['Income'] ?>',
					captionFormat: '<?= $lng['Income'] ?> ({0})',
					captionFormatAllSelected: '<?= $lng['All'] . ' ' . $lng['Income'] ?> ({0})',
					csvDispCount: 1,
					outputAsCSV: true,
					selectAll: true,
					okCancelInMulti: true,
					showTitle: false,
					triggerChangeCombined: true,
				});
			}
		})

		function calculateNet() {
			var data = new FormData($('#payrollForm')[0]);
			$.ajax({
				url: AROOT + "def_settings/ajax/calculate_net.php",
				type: 'POST',
				data: data,
				async: false,
				cache: false,
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data['net_from'][2])
					//$('#dump').html(data['net_from'][2]);
					$.each(data.net_from, function(i, val) {
						$('#payrollForm input[name="net_from[' + i + ']"]').val(val)
					})
					$.each(data.net_to, function(i, val) {
						$('#payrollForm input[name="net_to[' + i + ']"]').val(val)
					})



				},
				error: function(xhr, ajaxOptions, thrownError) {
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Sorry but someting went wrong'] ?> <b><?= $lng['Error'] ?></b> : ' + thrownError,
						duration: 8,
						closeConfirm: "true",
					})
				}
			});
		}
		//calculateNet()
		$(".changeRules").on('change', function() {
			calculateNet();
		})

		var fixa = <?= json_encode(count($fix_allow) + 1) ?>;
		var vara = <?= json_encode(count($var_allow) + 1) ?>;
		$("#addfix").on('click', function() {
			if (fixa <= 15) {
				var addrow = '<tr><td class="tac" style="border-right:1px #ddd solid"><b>' + fixa + '</b></td>' +
					'<td class="tac" style="vertical-align:middle"><input name="fix_allow[' + fixa + '][apply]" type="hidden" value="0" /><label><input name="fix_allow[' + fixa + '][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label></td>' +
					'<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_allow[' + fixa + '][th]" type="text" /></td>' +
					'<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_allow[' + fixa + '][en]" type="text" /></td>' +
					'<td><select name="fix_allow[' + fixa + '][tax]"><option value="Y"><?= $lng['Yes'] ?></option><option value="N"><?= $lng['No'] ?></option></select></td></tr>';
				$("#fixTable tbody").append(addrow);
				fixa++;
			}
		});

		$("#addvar").on('click', function() {
			if (vara <= 15) {
				var addrow = '<tr><td class="tac" style="border-right:1px #ddd solid"><b>' + vara + '</b></td>' +
					'<td class="tac" style="vertical-align:middle"><input name="var_allow[' + vara + '][apply]" type="hidden" value="0" /><label><input name="var_allow[' + vara + '][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label></td>' +
					'<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_allow[' + vara + '][th]" type="text" /></td>' +
					'<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_allow[' + vara + '][en]" type="text" /></td>' +
					'<td><select name="var_allow[' + vara + '][tax]"><option value="Y"><?= $lng['Yes'] ?></option><option value="N"><?= $lng['No'] ?></option></select></td></tr>';

				$("#varTable tbody").append(addrow);
				vara++;
			}
		});

		$("#payrollForm").submit(function(e) {
			e.preventDefault();
			$("#submitbtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
			var data = $(this).serialize();
			$.ajax({
				url: AROOT + "def_settings/ajax/update_default_employee_settings.php",
				type: 'POST',
				data: data,
				success: function(result) {
					//$('#dump').html(result); return false;
					if (result == 'success') {
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
							duration: 2,
						})
					} else {
						$("body").overhang({
							type: "warn",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Error'] ?> : ' + result,
							duration: 4,
							closeConfirm: true
						})
					}
					setTimeout(function() {
						$("#submitbtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
						$("#submitbtn").removeClass('flash');
						$("#sAlert").fadeOut(200);
					}, 300);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Sorry but someting went wrong'] ?> <b><?= $lng['Error'] ?></b> : ' + thrownError,
						duration: 8,
						closeConfirm: "true",
					})
				}
			});
		});

		var activeTab = localStorage.getItem('activeTab10');
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTab10', $(e.target).data('target'));
		});
		if (activeTab) {
			$('#myTab a[data-target="' + activeTab + '"]').tab('show');
		} else {
			$('#myTab a[data-target="#tab_settings"]').tab('show');
		}

		/*$('.autoheight').css('min-height', height);
		$(window).on('resize', function(){
			var height = window.innerHeight-265;
			$('.autoheight').css('min-height', height);
		});*/

		setTimeout(function() {
			$('body').on('change', 'input, textarea, select', function(e) {
				$("#submitbtn").addClass('flash');
				$("#sAlert").fadeIn(200);
			});
		}, 1000);

	});

	function get_shift_schedule() {
		var getid = $('#getteam').val();
		// run ajax to get the description 

		$.ajax({
			url: AROOT + "def_settings/ajax/get_shift_schedule_desc.php",
			type: 'POST',
			data: {
				'getid': getid
			},
			success: function(result) {
				// response 
				var obj = JSON.parse(result);

				$('#shiftplan_schedule').val(obj.desc);
				$('#teams_name').val(obj.th_name);

			},

		});

	}


	$(document).on("click", "#addPrefix", function(e) {
		e.preventDefault();
		$('#addPrefixModal').modal('toggle');
	});

	$(document).on("click", "#editPrefix", function(e) {
		e.preventDefault();


		var selectedPrefix = $('#id_prefix_select').val();
		$.ajax({
			url: AROOT + "def_settings/ajax/get_prefix_data.php",
			type: 'POST',
			data: {
				selectedPrefix: selectedPrefix
			},
			success: function(result) {

				var data = JSON.parse(result);

				$('.id_prefix').val(data.idPrefix);
				$('.id_start').val(data.startCount);
				$('.keyToUpdate').val(data.idPrefix);

				$('#editPrefixModal').modal('toggle');

			},

		});



	});


	function submitPopupModalAdd() {
		var idPrefix = $('#id_prefix').val();
		var startCount = $('#id_start').val();

		if ((idPrefix == '') && (startCount == '')) {
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Error'] ?> : Please fill the valid values',
				duration: 4,
			})
			return false;
		}


		$.ajax({
			url: AROOT + "def_settings/ajax/update_employee_default_prefix.php",
			type: 'POST',
			data: {
				idPrefix: idPrefix,
				startCount: startCount
			},
			success: function(result) {
				$("#submitBtn").removeClass('flash');
				$("#sAlert").fadeOut(200);
				if (result == 'success') {
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
						duration: 2,
					})
					setTimeout(function() {
						location.reload();
					}, 500);
				} else {
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Error'] ?> : ' + result,
						duration: 4,
					})
				}
				setTimeout(function() {
					$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
				}, 500);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Sorry but someting went wrong'] ?> <b><?= $lng['Error'] ?></b> : ' + thrownError,
					duration: 4,
				})
			}
		});

	}

	function submitPopupModalEdit() {
		var idPrefix = $('.id_prefix').val();
		var keyToUpdate = $('.keyToUpdate').val();
		var startCount = $('.id_start').val();

		$.ajax({
			url: AROOT + "def_settings/ajax/edit_employee_default_prefix.php",
			type: 'POST',
			data: {
				idPrefix: idPrefix,
				startCount: startCount,
				keyToUpdate: keyToUpdate
			},
			success: function(result) {
				$("#submitBtn").removeClass('flash');
				$("#sAlert").fadeOut(200);
				if (result == 'success') {
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
						duration: 2,
					})
					setTimeout(function() {
						location.reload();
					}, 500);
				} else {
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Error'] ?> : ' + result,
						duration: 4,
					})
				}
				setTimeout(function() {
					$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
				}, 500);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Sorry but someting went wrong'] ?> <b><?= $lng['Error'] ?></b> : ' + thrownError,
					duration: 4,
				})
			}
		});

	}


	function checkTheBox(that) {
		if ($(that).is(':checked')) {
			$('#sso_id_check').val('1');
		} else {
			$('#sso_id_check').val('0');
		}
	}

	function checkTheBoxtaxId(that) {
		if ($(that).is(':checked')) {
			$('#tax_id_check').val('1');
		} else {
			$('#tax_id_check').val('0');
		}
	}
</script>