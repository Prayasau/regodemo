<?php
//var_dump(getSystemUsers(1)); exit;
$approve_by = getSystemUsers(1);

//var_dump(explode(',',$_SESSION['rego']['sel_branches']));exit;
if (!$_SESSION['rego']['employee_info']['view']) {
	echo '<div class="msg_nopermit">You have no access to this page</div>';
	exit;
}
if (isset($_GET['id'])) {
	$_SESSION['rego']['empID'] = $_GET['id'];
}

$delDoc = 'delColor';
if ($_SESSION['rego']['employee_info']['del']) {
	$delDoc = 'delDoc';
}

if (isset($_SESSION['rego']['empID']) && $_SESSION['rego']['empID'] != '0') { // EDIT EMPLOYEE //////////////
	$empID = $_SESSION['rego']['empID'];
	$res = $dbc->query("SELECT * FROM " . $cid . "_employees WHERE emp_id = '" . $empID . "'");
	$data = $res->fetch_assoc();
	if (empty($data['image'])) {
		$data['image'] = 'images/profile_image.jpg';
	}
	$emergency_contacts = unserialize($data['emergency_contacts']);
	$hospitals = unserialize($data['hospitals']);
	$update = 1;
} else { // NEW EMPLOYEE /////////////////////////////////////////////////////////////////////////////////
	$empID = 0;
	$button_txt = ''; //$lng['Save new employee'];
	$update = 0;

	$sql = "SHOW COLUMNS FROM " . $cid . "_employees";
	$res = $dbc->query($sql);
	while ($row = $res->fetch_assoc()) {
		$data[$row['Field']] = '';
	}
	if ($sys_settings['joining_date'] != 'empty') {
		$data['joining_date'] = date('d-m-Y');
		$data['probation_date'] = date('d-m-Y', strtotime(date('d-m-Y') . '+ 4 months'));
	}
	$data['entity'] = $teams[$sys_settings['team']]['entity'];
	$data['branch'] = $teams[$sys_settings['team']]['branch'];
	$data['division'] = $teams[$sys_settings['team']]['division'];
	$data['department'] = $teams[$sys_settings['team']]['department'];
	$data['team'] = $sys_settings['team'];
	$data['teams'] = $sys_settings['team'];
	$data['team_name'] = $sys_settings['teams_name'];
	$data['shiftplan'] = $sys_settings['shiftplan_schedule'];
	$data['entity'] = '1';
	$data['branch'] = '1';
	$data['division'] = '1';
	$data['department'] = '1';
	$data['groups'] = '1';
	$data['emp_group'] = $sys_settings['emp_group'];
	$data['emp_type'] = $sys_settings['emp_type'];
	$data['emp_status'] = $sys_settings['emp_status'];
	$data['account_code'] = $sys_settings['account_code'];
	$data['position'] = $sys_settings['position'];
	if ($sys_settings['date_start'] != 'empty') {
		$data['date_position'] = date('d-m-Y');
	}
	$data['shift_team'] = '';
	$data['time_reg'] = $sys_settings['time_reg'];
	$data['selfie'] = $sys_settings['selfie'];
	$data['annual_leave'] = $sys_settings['leeve'];

	// FINANCIAL ///////////////////////////////////////////////
	$data['pay_type'] = $sys_settings['pay_type'];
	$data['calc_psf'] = $sys_settings['calc_psf'];
	$data['psf_rate_emp'] = $sys_settings['psf_rate_emp'];
	$data['psf_rate_com'] = $sys_settings['psf_rate_com'];
	$data['calc_pvf'] = $sys_settings['calc_pvf'];
	$data['pvf_rate_emp'] = $sys_settings['pvf_rate_emp'];
	$data['pvf_rate_com'] = $sys_settings['pvf_rate_com'];
	$data['calc_method'] = $sys_settings['calc_method'];
	$data['calc_tax'] = $sys_settings['calc_tax'];
	$data['pnd'] = $sys_settings['pnd'];
	$data['calc_sso'] = $sys_settings['calc_sso'];
	$data['sso_by'] = '0';
	$data['contract_type'] = $sys_settings['contract_type'];
	$data['calc_base'] = $sys_settings['calc_base'];
	$data['base_ot_rate'] = $sys_settings['base_ot_rate'];
	$data['ot_rate'] = $sys_settings['ot_rate'];
}
$prefix = explode(',', $sys_settings['id_prefix']);

if ($data['emergency_contacts'] == '') {
	$emergency_contacts[1]['name'] = '';
	$emergency_contacts[1]['relation'] = '';
	$emergency_contacts[1]['mobile'] = '';
	$emergency_contacts[1]['work'] = '';
	$emergency_contacts[2]['name'] = '';
	$emergency_contacts[2]['relation'] = '';
	$emergency_contacts[2]['mobile'] = '';
	$emergency_contacts[2]['work'] = '';
	$emergency_contacts[3]['name'] = '';
	$emergency_contacts[3]['relation'] = '';
	$emergency_contacts[3]['mobile'] = '';
	$emergency_contacts[3]['work'] = '';
}

if ($data['hospitals'] == '') {
	$hospitals[1]['name'] = '';
	$hospitals[1]['phone'] = '';
	$hospitals[1]['contact'] = '';
	$hospitals[1]['address'] = '';
	$hospitals[2]['name'] = '';
	$hospitals[2]['phone'] = '';
	$hospitals[2]['contact'] = '';
	$hospitals[2]['address'] = '';
	$hospitals[3]['name'] = '';
	$hospitals[3]['phone'] = '';
	$hospitals[3]['contact'] = '';
	$hospitals[3]['address'] = '';
}
//var_dump($data); exit;

if (empty($data['att_idcard'])) {
	$att_idcard = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';
} else {
	$att_idcard = '<a download href="' . ROOT . $cid . '/employees/' . $data['att_idcard'] . '"><i class="fa fa-download fa-lg"></i></a>';
}

if (empty($data['att_housebook'])) {
	$att_housebook = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';
} else {
	$att_housebook = '<a download href="' . ROOT . $cid . '/employees/' . $data['att_housebook'] . '"><i class="fa fa-download fa-lg"></i></a>';
}

if (empty($data['attach1'])) {
	$attach1 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';
} else {
	$attach1 = '<a download href="' . ROOT . $cid . '/employees/' . $data['attach1'] . '"><i class="fa fa-download fa-lg"></i></a>';
}

if (empty($data['attach2'])) {
	$attach2 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';
} else {
	$attach2 = '<a download href="' . ROOT . $cid . '/employees/' . $data['attach2'] . '"><i class="fa fa-download fa-lg"></i></a>';
}

if (empty($data['attach3'])) {
	$attach3 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';
} else {
	$attach3 = '<a download href="' . ROOT . $cid . '/employees/' . $data['attach3'] . '"><i class="fa fa-download fa-lg"></i></a>';
}

if (empty($data['attach4'])) {
	$attach4 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';
} else {
	$attach4 = '<a download href="' . ROOT . $cid . '/employees/' . $data['attach4'] . '"><i class="fa fa-download fa-lg"></i></a>';
}

$employees = getJsonUserEmployees($cid, $lang);
$emps = getEmployees($cid, 0);
//echo '<pre>';
//var_dump($data['emp_status']); exit;


$sql11 = "SELECT * FROM " . $cid . "_shiftplans_" . $cur_year . " ORDER BY id ASC";
if ($res11 = $dbc->query($sql11)) {
	while ($row11 = $res11->fetch_assoc()) {

		$shifttest[] = $row11;
		array_unshift($shifttest, "");
		unset($shifttest[0]);
	}
}

// echo '<pre>';
// print_r($rego_settings['all_settings']);
// echo '<pre>'; exit;

$emp_def_settings = $rego_settings['all_settings'];  //get default setting for employee...

// echo '<pre>';
// print_r($emp_def_settings);
// echo '</pre>';

// die();
?>
<h2 style="position:relative">
	<span><i class="fa fa-users fa-mr"></i> <?= $lng['Employee info'] ?>&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
	<? if ($update) {
		echo '<span>' . $data['emp_id_editable'] . ' : ' . $data[$lang . '_name'] . '</span>';
	} else {
		echo $lng['Add employee'];
	} ?>
	<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?= $lng['Data is not updated to last changes made'] ?></span>
</h2>

<? include('employee_image_inc.php') ?>

<div class="pannel main_pannel">
	<div style="padding:0 0 0 20px" id="dump"></div>

	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link active" href="#tab_personal" data-toggle="tab"><?= $lng['Personal'] ?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_contcact" data-toggle="tab"><?= $lng['Contact'] ?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_documents" data-toggle="tab"><?= $lng['Documents'] ?></a></li>
	</ul>

	<form id="infoForm" method="post" enctype="multipart/form-data" style="height:calc(100% - 30px)">

		<? if (!$update) { ?>
			<input type="hidden" name="pay_type" value="<?= $data['pay_type'] ?>">
			<input type="hidden" name="calc_psf" value="<?= $data['calc_psf'] ?>">
			<input type="hidden" name="psf_rate_emp" value="<?= $data['psf_rate_emp'] ?>">
			<input type="hidden" name="psf_rate_com" value="<?= $data['psf_rate_com'] ?>">
			<input type="hidden" name="calc_pvf" value="<?= $data['calc_pvf'] ?>">
			<input type="hidden" name="pvf_rate_emp" value="<?= $data['pvf_rate_emp'] ?>">
			<input type="hidden" name="pvf_rate_com" value="<?= $data['pvf_rate_com'] ?>">
			<input type="hidden" name="calc_method" value="<?= $data['calc_method'] ?>">
			<input type="hidden" name="calc_tax" value="<?= $data['calc_tax'] ?>">
			<input type="hidden" name="pnd" value="<?= $data['pnd'] ?>">
			<input type="hidden" name="calc_sso" value="<?= $data['calc_sso'] ?>">
			<input type="hidden" name="contract_type" value="<?= $data['contract_type'] ?>">
			<input type="hidden" name="calc_base" value="<?= $data['calc_base'] ?>">
			<input type="hidden" name="base_ot_rate" value="<?= $data['base_ot_rate'] ?>">
			<input type="hidden" name="ot_rate" value="<?= $data['ot_rate'] ?>">
			<input type="hidden" name="allow_login" value="0">
		<? } ?>

		<fieldset style="height:100%" <? if (!$_SESSION['rego']['employee_info']['edit']) {
											echo 'disabled';
										} ?>>
			<div class="tab-content" style="height:100%">

				<? if ($_SESSION['rego']['empView'] == 'active') { ?>
					<button id="submitBtn" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?= $lng['Update'] ?></button>
					<input type="hidden" name="updateEmp" value="1">
				<? } ?>

				<div class="tab-pane active" id="tab_personal">
					<table class="basicTable editTable" border="0">
						<tbody>
							<input type="hidden" name="emp_id" id="emp_id" value="<?= $data['emp_id'] ?>">
							<!-- <tr>
								<th style="width:5%"><i class="man"></i><?= $lng['Rego ID'] ?></th>
								<td>
								<? if ($sys_settings['auto_id'] && $update == 0) { ?>
									<select id="emp_prefix" style="width:auto">
										<option value="0" selected disabled>...<? //=$lng['Select']
																				?></option>
										<? foreach ($prefix as $v) { ?>
											<option <? //if($data['title'] == $k){echo 'selected';}
													?> value="<?= $v ?>"><?= $v ?></option>
										<? } ?>
									</select>
									<span id="empID" style="font-weight:600; color:#c00"></span>
									<input type="hidden" name="emp_id" id="emp_id" value="<?= $data['emp_id'] ?>">
								<? } else { ?>
									<input maxlength="10" <? if ($update) {
																echo 'readonly';
															} ?> style="font-weight:600" type="text" name="emp_id" id="emp_id" placeholder="..." value="<?= $data['emp_id'] ?>">
								<? } ?>
								</td>
							</tr> -->
							<tr>
								<th><i class="man"></i><?= $lng['Employee ID'] ?></th>
								<td><input type="text" name="emp_id_editable" placeholder="..." onchange="checkEmpIdExist(this.value)" value="<?= $data['emp_id_editable'] ?>" autocomplete="off"></td>
							</tr>
							<tr>
								<th><?= $lng['Scan ID'] ?></th>
								<td><input type="text" name="sid" placeholder="..." value="<?= $data['sid'] ?>"></td>
							</tr>
							<tr>
								<th><i class="man"></i><?= $lng['Title'] ?></th>
								<td>
									<select name="title">
										<option value="0" selected disabled><?= $lng['Select'] ?></option>
										<? foreach ($title as $k => $v) { ?>
											<option <? if ($data['title'] == $k) {
														echo 'selected';
													} ?> value="<?= $k ?>"><?= $v ?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><i class="man"></i><?= $lng['First name'] ?></th>
								<td><input type="text" name="firstname" placeholder="..." value="<?= $data['firstname'] ?>"></td>
							</tr>
							<tr>
								<th><i class="man"></i><?= $lng['Last name'] ?></th>
								<td><input type="text" name="lastname" placeholder="..." value="<?= $data['lastname'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Name in English'] ?></th>
								<td><input type="text" name="en_name" placeholder="..." value="<?= $data['en_name'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Birthdate'] ?></th>
								<td><input readonly style="cursor:pointer" class="date_year" type="text" name="birthdate" id="birthdate" placeholder="..." value="<?= $data['birthdate'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Age'] ?></th>
								<td class="pad410" id="emp_age"></td>
							</tr>
							<tr>
								<th><?= $lng['Nationality'] ?></th>
								<td><input type="text" name="nationality" placeholder="..." value="<?= $data['nationality'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Gender'] ?></th>
								<td>
									<select name="gender">
										<option value="" selected disabled><?= $lng['Select'] ?></option>
										<? foreach ($gender as $k => $v) { ?>
											<option <? if ($data['gender'] == $k) {
														echo 'selected';
													} ?> value="<?= $k ?>"><?= $v ?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?= $lng['Maritial status'] ?></th>
								<td>
									<select name="maritial">
										<option value="" selected disabled><?= $lng['Select'] ?></option>
										<? foreach ($maritial as $k => $v) { ?>
											<option <? if ($data['maritial'] == $k) {
														echo 'selected';
													} ?> value="<?= $k ?>"><?= $v ?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?= $lng['Religion'] ?></th>
								<td>
									<select name="religion">
										<option value="" selected disabled><?= $lng['Select'] ?></option>
										<? foreach ($religion as $k => $v) { ?>
											<option <? if ($data['religion'] == $k) {
														echo 'selected';
													} ?> value="<?= $k ?>"><?= $v ?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?= $lng['Military status'] ?></th>
								<td>
									<select name="military_status">
										<option value="" selected disabled><?= $lng['Select'] ?></option>
										<? foreach ($military_status as $k => $v) { ?>
											<option <? if ($data['military_status'] == $k) {
														echo 'selected';
													} ?> value="<?= $k ?>"><?= $v ?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?= $lng['Height'] ?> (cm)<? //=$lng['cm']
																?></th>
								<td><input class="sel numeric3" type="text" name="height" placeholder="..." value="<?= $data['height'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Weight'] ?> (kg)</th>
								<td><input class="sel numeric3" type="text" name="weight" placeholder="..." value="<?= $data['weight'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Blood group'] ?></th>
								<td><input type="text" name="bloodtype" placeholder="..." value="<?= $data['bloodtype'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Driving license No.'] ?></th>
								<td><input type="text" name="drvlicense_nr" placeholder="..." value="<?= $data['drvlicense_nr'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['License expiry date'] ?></th>
								<td><input type="text" readonly style="cursor:pointer" class="date_year" name="drvlicense_exp" placeholder="..." value="<?= $data['drvlicense_exp'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['ID card'] ?></th>
								<td><input class="xtax_id_number" type="text" name="idcard_nr" id="idcard_nr" placeholder="..." value="<?= $data['idcard_nr'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['ID card expiry date'] ?></th>
								<td><input style="cursor:pointer" class="date_year" name="idcard_exp" type="text" placeholder="..." value="<?= $data['idcard_exp'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Tax ID no.'] ?></th>
								<td><input class="xtax_id_number" type="text" name="tax_id" id="tax_id" placeholder="..." value="<?= $data['tax_id'] ?>"></td>

								<td class="pl-2">
								<input class="checkbox-custom-blue-2 checkbox-blue-custom-white" type="checkbox" id="tax_id_checkbox" onclick="checkTheBoxtaxId(this);" <? if ($data['tax_id_check'] == 1) {
								echo 'checked';
								} ?>> <b><?= $lng['Same as ID card no'] ?></b>
								<input type="hidden" name="tax_id_check" id="tax_id_check" value="<?= $data['tax_id_check'] ? $data['tax_id_check'] : '0'; ?>">
								</td>

							</tr>
							<tr>
								<th><?= $lng['SSO ID no.'] ?></th>
								<td><input type="text" name="sso_id" id="sso_id" placeholder="..." value="<?= $data['sso_id'] ?>"></td>

								<td class="pl-2">
									<input class="checkbox-custom-blue-2 checkbox-blue-custom-white"  type="checkbox" id="sso_id_checkbox" onclick="checkTheBox(this);" <? if ($data['sso_id_check'] == 1) {
									echo 'checked';
									} ?>> <b><?= $lng['Same as ID card no'] ?></b>
									<input type="hidden" name="sso_id_check" id="sso_id_check" value="<?= $data['sso_id_check'] ? $data['sso_id_check'] : '0'; ?>">
								</td>
							</tr>

						</tbody>
					</table>
				</div>

				<div class="tab-pane" id="tab_contcact">
					<table class="basicTable editTable" border="0">
						<tbody>
							<tr style="background:#f9fff9">
								<th><?= $lng['Registered address'] ?></th>
								<td><input style="background:transparent" type="text" name="reg_address" placeholder="..." value="<?= $data['reg_address'] ?>"></td>
								<td rowspan="8">

									<h6 style="background:#eee; padding:6px 10px; margin:0; border-radius:3px 3px 0 0"><i class="fa fa-arrow-circle-down"></i>&nbsp;&nbsp;<?= $lng['Google Map'] ?> - <span style="text-transform:none"><?= $compinfo[$lang . '_compname'] ?></span></h6>
									<div style="height:202px;" id="map-canvas"></div>
								</td>
							</tr>
							<tr style="background:#f9fff9">
								<th><?= $lng['Sub district'] ?></th>
								<td><input style="background:transparent" type="text" name="sub_district" placeholder="..." value="<?= $data['sub_district'] ?>"></td>
							</tr>
							<tr style="background:#f9fff9">
								<th><?= $lng['District'] ?></th>
								<td><input style="background:transparent" type="text" name="district" placeholder="..." value="<?= $data['district'] ?>"></td>
							</tr>
							<tr style="background:#f9fff9">
								<th><?= $lng['Province'] ?></th>
								<td><input style="background:transparent" type="text" name="province" placeholder="..." value="<?= $data['province'] ?>"></td>
							</tr>
							<tr style="background:#f9fff9">
								<th><?= $lng['Postal code'] ?></th>
								<td><input style="background:transparent" type="text" name="postnr" placeholder="..." value="<?= $data['postnr'] ?>"></td>
							</tr>
							<tr style="background:#f9fff9;">
								<th><?= $lng['Country'] ?></th>
								<td><input style="background:transparent" type="text" name="country" placeholder="..." value="<?= $data['country'] ?>"></td>
							</tr>
							<tr style="background:#f9fff9;">
								<th><?= $lng['Latitude'] ?></th>
								<td><input style="background:transparent" type="text" name="latitude" placeholder="..." value="<?= $data['latitude'] ?>"></td>
							</tr>
							<tr style="background:#f9fff9; border-bottom:1px solid #ddd">
								<th><?= $lng['Longitude'] ?></th>
								<td><input style="background:transparent" type="text" name="longitude" placeholder="..." value="<?= $data['longitude'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Current address'] ?></th>
								<td><input type="text" name="cur_address" placeholder="..." value="<?= $data['cur_address'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Personal phone'] ?></th>
								<td><input type="text" name="personal_phone" placeholder="..." value="<?= $data['personal_phone'] ?>"></td>
							</tr>
							<tr>
								<th><?= $lng['Work phone'] ?></th>
								<td><input type="text" name="work_phone" placeholder="..." value="<?= $data['work_phone'] ?>"></td>
							</tr>

							<tr>
								<? if ($data['allow_login'] == 1) {
									$intab = 'readonly';
								} else {
									$intab = '';
								} ?>
								<th><?= $lng['Personal email'] ?></th>
								<td><input type="text" name="personal_email" placeholder="..." value="<?= $data['personal_email'] ?>" <?= $intab; ?>></td>

								<td class="pl-2">
									<input type="checkbox" onclick="changesOtherChkboxP(this)" <? if ($data['peComm'] == 1) {
																									echo 'checked';
																								} ?>> <b><?= $lng['Communications'] ?></b>
									<input type="hidden" name="peComm" id="peComm11" value="<?= $data['peComm'] ? $data['peComm'] : '0'; ?>">
								</td>
							</tr>

							<tr>
								<th><?= $lng['Work email'] ?></th>
								<td><input type="text" name="work_email" placeholder="..." value="<?= $data['work_email'] ?>"></td>
								<td class="pl-2">
									<input type="checkbox" onclick="changesOtherChkboxW(this)" <? if ($data['weComm'] == 1) {
																									echo 'checked';
																								} ?>> <b><?= $lng['Communications'] ?></b>
									<input type="hidden" name="weComm" id="weComm11" value="<?= $data['weComm'] ? $data['weComm'] : '0'; ?>">
								</td>
							</tr>

							<tr>
								<th><?= $lng['Username Options'] ?></th>
								<td>
									<select name="username_option" onchange="getUsernameval(this.value);">
										<option value="" selected disabled><?= $lng['Select'] ?></option>
										<? foreach ($username_option as $k => $v) { ?>
											<option <? if ($data['username_option'] == $k) {
														echo 'selected';
													} ?> value="<?= $k ?>"><?= $v ?></option>
										<? } ?>
									</select>
								</td>
							</tr>

							<tr>
								<th><?= $lng['Username'] ?></th>
								<td><input type="text" name="username" placeholder="..." value="<?= $data['username'] ?>"></td>
							</tr>


							<tr>
								<th colspan="3" style="border:0; text-align:left; height:30px; vertical-align:bottom"><?= $lng['EMERGENCY CONTACTS'] ?></th>
							</tr>
							<tr style="border:0">
								<td colspan="3" style="padding:0">
									<table class="basicTable editTable" id="emTable" border="0">
										<thead>
											<tr style="border-bottom:1px #ccc solid; line-height:100%">
												<th><?= $lng['Name'] ?></th>
												<th><?= $lng['Relationship'] ?></th>
												<th><?= $lng['Mobile phone'] ?></th>
												<th><?= $lng['Work phone'] ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><input type="text" name="emergency_contacts[1][name]" placeholder="..." value="<?= $emergency_contacts[1]['name'] ?>"></td>
												<td><input type="text" name="emergency_contacts[1][relation]" placeholder="..." value="<?= $emergency_contacts[1]['relation'] ?>"></td>
												<td><input type="text" name="emergency_contacts[1][mobile]" placeholder="..." value="<?= $emergency_contacts[1]['mobile'] ?>"></td>
												<td><input type="text" name="emergency_contacts[1][work]" placeholder="..." value="<?= $emergency_contacts[1]['work'] ?>"></td>
											</tr>
											<tr>
												<td><input type="text" name="emergency_contacts[2][name]" placeholder="..." value="<?= $emergency_contacts[2]['name'] ?>"></td>
												<td><input type="text" name="emergency_contacts[2][relation]" placeholder="..." value="<?= $emergency_contacts[2]['relation'] ?>"></td>
												<td><input type="text" name="emergency_contacts[2][mobile]" placeholder="..." value="<?= $emergency_contacts[2]['mobile'] ?>"></td>
												<td><input type="text" name="emergency_contacts[2][work]" placeholder="..." value="<?= $emergency_contacts[2]['work'] ?>"></td>
											</tr>
											<tr>
												<td><input type="text" name="emergency_contacts[3][name]" placeholder="..." value="<?= $emergency_contacts[3]['name'] ?>"></td>
												<td><input type="text" name="emergency_contacts[3][relation]" placeholder="..." value="<?= $emergency_contacts[2]['relation'] ?>"></td>
												<td><input type="text" name="emergency_contacts[3][mobile]" placeholder="..." value="<?= $emergency_contacts[3]['mobile'] ?>"></td>
												<td><input type="text" name="emergency_contacts[3][work]" placeholder="..." value="<?= $emergency_contacts[3]['work'] ?>"></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<th colspan="3" style="border:0; text-align:left; height:30px; vertical-align:bottom"><?= $lng['AVAILABLE HOSPITALS'] ?></th>
							</tr>
							<tr style="border:0">
								<td colspan="3" style="padding:0">
									<table class="basicTable editTable" id="emTable" border="0">
										<thead>
											<tr style="border-bottom:1px #ccc solid; line-height:100%">
												<th style="min-width:250px"><?= $lng['Name'] ?></th>
												<th style="min-width:150px"><?= $lng['Phone'] ?></th>
												<th style="min-width:200px"><?= $lng['Contact person'] ?></th>
												<th style="width:80%"><?= $lng['Address'] ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><input type="text" name="hospitals[1][name]" placeholder="..." value="<?= $hospitals[1]['name'] ?>"></td>
												<td><input type="text" name="hospitals[1][phone]" placeholder="..." value="<?= $hospitals[1]['phone'] ?>"></td>
												<td><input type="text" name="hospitals[1][contact]" placeholder="..." value="<?= $hospitals[1]['contact'] ?>"></td>
												<td><input type="text" name="hospitals[1][address]" placeholder="..." value="<?= $hospitals[1]['address'] ?>"></td>
											</tr>
											<tr>
												<td><input type="text" name="hospitals[2][name]" placeholder="..." value="<?= $hospitals[2]['name'] ?>"></td>
												<td><input type="text" name="hospitals[2][phone]" placeholder="..." value="<?= $hospitals[2]['phone'] ?>"></td>
												<td><input type="text" name="hospitals[2][contact]" placeholder="..." value="<?= $hospitals[2]['contact'] ?>"></td>
												<td><input type="text" name="hospitals[2][address]" placeholder="..." value="<?= $hospitals[2]['address'] ?>"></td>
											</tr>
											<tr>
												<td><input type="text" name="hospitals[3][name]" placeholder="..." value="<?= $hospitals[3]['name'] ?>"></td>
												<td><input type="text" name="hospitals[3][phone]" placeholder="..." value="<?= $hospitals[3]['phone'] ?>"></td>
												<td><input type="text" name="hospitals[3][contact]" placeholder="..." value="<?= $hospitals[3]['contact'] ?>"></td>
												<td><input type="text" name="hospitals[3][address]" placeholder="..." value="<?= $hospitals[3]['address'] ?>"></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>



				<div class="tab-pane" id="tab_documents">
					<div style="width:0; height:0; overflow:hidden">
						<input name="att_idcard" id="att_idcard" type="file" />
						<input name="att_housebook" id="att_housebook" type="file" />
						<input name="attach1" id="attach1" type="file" />
						<input name="attach2" id="attach2" type="file" />
						<input name="attach3" id="attach3" type="file" />
						<input name="attach4" id="attach4" type="file" />
					</div>
					<table class="basicTable" border="0">
						<thead>
							<tr>
								<th colspan="2"><?= $lng['DOCUMENTS'] ?></th>
								<th style="width:1%" data-toggle="tooltip" title="<?= $lng['Upload'] ?>"><i class="fa fa-upload fa-lg"></i></th>
								<th style="width:1%" data-toggle="tooltip" title="<?= $lng['Download'] ?>"><i class="fa fa-download fa-lg"></i></th>
								<th style="width:1%" data-toggle="tooltip" title="<?= $lng['Delete'] ?>"><i class="fa fa-trash fa-lg"></i></th>
							</tr>

						</thead>
						<tbody>
							<tr>
								<th><?= $lng['ID card'] ?></th>
								<? if ($_SESSION['rego']['empView'] == 'active') { ?>
									<td id="idcard_name" style="width:95%; color:#999; font-style:italic"><?= $data['att_idcard'] ?></td>
									<td><a href="#" onClick="$('#att_idcard').click();"><i class="fa fa-upload fa-lg"></i></a></td>
									<td class="tac"><?= $att_idcard ?></td>
									<td><a href="#" data-id="att_idcard" class="<?= $delDoc ?>"><i class="fa fa-trash fa-lg"></i></a></td>
								<? } else { ?><td colspan="3"></td><? } ?>
							</tr>
							<tr>
								<th><?= $lng['Housebook'] ?></th>
								<? if ($_SESSION['rego']['empView'] == 'active') { ?>
									<td id="housebook_name" style="color:#999; font-style:italic"><?= $data['att_housebook'] ?></td>
									<td><a href="#" onClick="$('#att_housebook').click();"><i class="fa fa-upload fa-lg"></i></a></td>
									<td class="tac"><?= $att_housebook ?></td>
									<td><a href="#" data-id="att_housebook" class="<?= $delDoc ?>"><i class="fa fa-trash fa-lg"></i></a></td>
								<? } else { ?><td colspan="3"></td><? } ?>
							</tr>
							<tr>
								<th><?= $lng['Additional file'] ?></th>
								<? if ($_SESSION['rego']['empView'] == 'active') { ?>
									<td id="attach1_name" style="color:#999; font-style:italic"><?= $data['attach1'] ?></td>
									<td><a href="#" onClick="$('#attach1').click();"><i class="fa fa-upload fa-lg"></i></a></td>
									<td class="tac"><?= $attach1 ?></td>
									<td><a href="#" data-id="attach1" class="<?= $delDoc ?>"><i class="fa fa-trash fa-lg"></i></a></td>
								<? } else { ?><td colspan="3"></td><? } ?>
							</tr>
							<tr>
								<th><?= $lng['Additional file'] ?></th>
								<? if ($_SESSION['rego']['empView'] == 'active') { ?>
									<td id="attach2_name" style="color:#999; font-style:italic"><?= $data['attach2'] ?></td>
									<td><a href="#" onClick="$('#attach2').click();"><i class="fa fa-upload fa-lg"></i></a></td>
									<td class="tac"><?= $attach2 ?></td>
									<td><a href="#" data-id="attach2" class="<?= $delDoc ?>"><i class="fa fa-trash fa-lg"></i></a></td>
								<? } else { ?><td colspan="3"></td><? } ?>
							</tr>
							<tr>
								<th><?= $lng['Additional file'] ?></th>
								<? if ($_SESSION['rego']['empView'] == 'active') { ?>
									<td id="attach3_name" style="color:#999; font-style:italic"><?= $data['attach3'] ?></td>
									<td><a href="#" onClick="$('#attach3').click();"><i class="fa fa-upload fa-lg"></i></a></td>
									<td class="tac"><?= $attach3 ?></td>
									<td><a href="#" data-id="attach3" class="<?= $delDoc ?>"><i class="fa fa-trash fa-lg"></i></a></td>
								<? } else { ?><td colspan="3"></td><? } ?>
							</tr>
							<!-- 							<tr>
								<th><?= $lng['Additional file'] ?></th>
								<td id="attach4_name" style="color:#999; font-style:italic"><?= $data['attach4'] ?></td>
								<td><a href="#" onClick="$('#attach4').click();"><i class="fa fa-upload fa-lg"></i></a></td>
								<td class="tac"><?= $attach4 ?></td>
								<td><a href="#" data-id="attach4" class="<?= $delDoc ?>"><i class="fa fa-trash fa-lg"></i></a></td>
							</tr> -->
						</tbody>
					</table>
				</div>

			</div>
		</fieldset>
	</form>

</div>

<!-- CHOOSE WORK EMAIL OR OTHER EMAIL POPUP -->



<div class="openHelp"><i class="fa fa-question-circle fa-lg"></i></div>
<div id="help">
	<div class="closeHelp"><i class="fa fa-arrow-circle-right"></i></div>
	<div class="innerHelp">
		<?= $helpfile ?>
	</div>
</div>

<? include('employee_new_edit_script.php') ?>

<script>
	function checkEmpIdExist(emp_id_editable) {

		$.ajax({
			url: "ajax/get_employee_id_editable.php",
			data: {
				emp_id_editable: emp_id_editable
			},
			success: function(result) {
				if (result == 1) {
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i> <?= $lng['Employee'] . ' ' . $lng['ID exist already'] ?>',
						duration: 2,
					})
					$('input[name="emp_id_editable"]').val('').focus();
					//$('#submitBtn').attr('disabled',true);
				} else {
					//$('#submitBtn').attr('disabled',false);
				}
			}
		})
	}

	function getUsernameval(that) {
		var val = that;
		if (val == 1) {
			var pe = $('input[name="personal_email"]').val();
			$('input[name="username"]').val(pe).attr('readonly', true);
		} else if (val == 2) {
			var we = $('input[name="work_email"]').val();
			$('input[name="username"]').val(we).attr('readonly', true);
		} else if (val == 3) {
			$('input[name="username"]').val('').attr('readonly', false).focus();
		} else {
			$('input[name="username"]').attr('readonly', true);
		}
	}

	$(document).ready(function() {

		var update = <?= json_encode($update) ?>;
		var emp_id = <?= json_encode($_SESSION['rego']['empID']) ?>;
		var employees = <?= json_encode($employees) ?>;
		var teams = <?= json_encode($teams) ?>;
		var entities = <?= json_encode($entities) ?>;
		var branches = <?= json_encode($branches) ?>;
		var divisions = <?= json_encode($divisions) ?>;
		var departments = <?= json_encode($departments) ?>;
		var groups = <?= json_encode($groups) ?>;

		/*$('#headBranch').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
		});	
		$('#headDepartment').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
		});	
		$('#lineManager').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
		});	
		$('#teamSupervisor').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
		});	
		$('#leaveApprove').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
		});*/

		$('#empTeam').on('change', function(e) {
			//alert($(this).val());
			if ($(this).val() == '') {
				$('#empEntity').val('')
				$('#empBranch').val('')
				$('#empDivision').val('')
				$('#empDepartment').val('')
				$('#txtEntity').html('...')
				$('#txtBranch').html('...')
				$('#txtDivision').html('...')
				$('#txtDepartment').html('...')
				$('#txtGroups').html('...')
			} else {

				$('#empEntity').val(teams[$(this).val()]['entity'])
				$('#empBranch').val(teams[$(this).val()]['branch'])
				$('#empDivision').val(teams[$(this).val()]['division'])
				$('#empDepartment').val(teams[$(this).val()]['department'])
				$('#txtEntity').html(entities[teams[$(this).val()]['entity']][lang])
				$('#txtBranch').html(branches[teams[$(this).val()]['branch']][lang])
				$('#txtDivision').html(divisions[teams[$(this).val()]['division']][lang])
				$('#txtDepartment').html(departments[teams[$(this).val()]['department']][lang])
				$('#txtGroups').html(groups[teams[$(this).val()]['groups']][lang])
			}
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})

		$('#emp_prefix').on('change', function(e) {
			$.ajax({
				url: "ajax/get_employee_id.php",
				data: {
					prefix: this.value
				},
				success: function(result) {
					//$('#dump').html(result); return false;
					$('#emp_id').val(result);
					$('#empID').html(result);
				}
			})
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})

		$("#infoForm").on('submit', function(e) { // SUBMIT EMPLOYEE FORM ///////////////////////////////////
			//e.preventDefault();
			var err = 0;
			if ($('input[name="emp_id"]').val() == '') {
				err = 1;
			}
			if ($('input[name="emp_id_editable"]').val() == '') {
				err = 1;
			}
			if ($('select[name="title"]').val() == null) {
				err = 1;
			}
			if ($('input[name="firstname"]').val() == '') {
				err = 1;
			}
			if ($('input[name="lastname"]').val() == '') {
				err = 1;
			}


			if (err) {
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Please fill in required fields'] ?>',
					duration: 4,
				})
				return false;
			}
			var data = new FormData(this);
			$.ajax({
				url: "ajax/update_employees.php",
				type: 'POST',
				data: data,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result) {
					//$('#dump').html(result); return false;
					//$("#submitBtn").removeClass('flash');
					//$("#sAlert").fadeOut(200); 
					//return false
					if ($.trim(result) == 'success') {
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?= $lng['Data updated successfully'] ?>',
							duration: 3,
							callback: function(value) {
								location.reload();
							}
						})
						/*if(!update){
							setTimeout(function(){location.reload();},1000);
						}*/
					} else {
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Error'] ?> : ' + result,
							duration: 4,
						})
					}
					$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['Sorry but someting went wrong'] ?> <b><?= $lng['Error'] ?></b> : ' + thrownError,
						duration: 4,
					})
				}
			});
		})

		// PERSONAL FORM /////////////////////////////////////////////////////////////////////////////
		$('input, textarea').on('keyup', function(e) {
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})
		$('select').on('change', function(e) {
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})

		$('input[name="firstname"],input[name="lastname"]').on('change', function() {
			$('input[name="bank_account_name"]').val($('input[name="firstname"]').val() + ' ' + $('input[name="lastname"]').val());
		})

		// DOCUMENTS ///////////////////////////////////////////////////////////////////////////////
		$("#att_idcard").change(function() {
			readAttURL(this, '#idcard_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#att_housebook").change(function() {
			readAttURL(this, '#housebook_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach1").change(function() {
			readAttURL(this, '#attach1_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach2").change(function() {
			readAttURL(this, '#attach2_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach3").change(function() {
			readAttURL(this, '#attach3_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach4").change(function() {
			readAttURL(this, '#attach4_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});

		$('.delDoc').confirmation({
			container: 'body',
			rootSelector: '.delDoc',
			singleton: true,
			animated: 'fade',
			placement: 'left',
			popout: true,
			html: true,
			title: '<?= $lng['Are you sure'] ?>',
			btnOkClass: 'btn btn-danger',
			btnOkLabel: '<?= $lng['Delete'] ?>',
			btnCancelClass: 'btn btn-success',
			btnCancelLabel: '<?= $lng['Cancel'] ?>',
			onConfirm: function() {
				$.ajax({
					url: "ajax/delete_document.php",
					data: {
						emp_id: emp_id,
						doc: $(this).data('id')
					},
					success: function(result) {
						//$('#dump').html(result); return false;
						location.reload();
					}
				});
			}
		});

		$("#emp_id").on('change', function(e) {
			$.ajax({
				url: "ajax/check_employee_id.php",
				data: {
					emp_id: this.value
				},
				success: function(data) {
					if (data == 1) {
						$("#emp_id").focus().select();
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?= $lng['ID exist already'] ?>',
							duration: 4,
						})
					}
				}
			});
		})


		var activeTabEmpInfo = localStorage.getItem('activeTabEmpInfo');
		if (activeTabEmpInfo) {
			$('.nav-link[href="' + activeTabEmpInfo + '"]').tab('show');
		} else {
			$('.nav-link[href="#tab_personal"]').tab('show');
		}
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTabEmpInfo', $(e.target).attr('href'));
		});

	})


	function getShiftSchedule() {
		var teamVal = $('#empTeam').val();
		var cid = "<?php echo $cid ?>";
		var cur_year = "<?php echo $cur_year ?>";

		// alert(teamVal);
		// alert(cid);
		// alert(cur_year);


		$.ajax({
			url: "ajax/get_shuedule_description.php",
			data: {
				'teamVal': teamVal,
				'cid': cid,
				'cur_year': cur_year
			},
			type: 'POST',
			success: function(response) {

				var data = JSON.parse(response);
				$('#shiftplan').val(data.shift_schedule_desc);
				$('#teams').val(data.team_code);
			},
		});
	}

	function getTeamName() {
		var teams = $("#empTeam option:selected").text();

		var teamVal = $('#empTeam').val();
		var cid = "<?php echo $cid ?>";
		var cur_year = "<?php echo $cur_year ?>";

		$.ajax({
			url: "ajax/getTeamNameVal.php",
			data: {
				'teamVal': teamVal,
				'cid': cid,
				'cur_year': cur_year
			},
			type: 'POST',
			success: function(response) {

				var data = JSON.parse(response);
				var test3434 = $.trim(response);

				var aade = test3434.replace(/\"/g, "");
				console.log(aade);
				var teamName = $('#team_name').val(aade);

			},
		});

	}



	// GET selected team on load 

	$(document).ready(function() {

		var teamVal = $('#empTeam').val();
		var cid = "<?php echo $cid ?>";
		var cur_year = "<?php echo $cur_year ?>";

		$.ajax({
			url: "ajax/get_shuedule_description.php",
			data: {
				'teamVal': teamVal,
				'cid': cid,
				'cur_year': cur_year
			},
			type: 'POST',
			success: function(response) {

				var data = JSON.parse(response);
				$('#shiftplan').val(data.shift_schedule_desc);
				$('#teams').val(data.team_code);
				$('#team_name').val(data.team_name);
			},
		});
	});


	function changesOtherChkboxP(that) {

		if ($(that).is(':checked')) {

			$('#peComm11').val('1');
			//$('#weComm11').val('0').attr('disabled', true);	

		} else {

			$('#peComm11').val('0');
			//$('#weComm11').val('0').attr('disabled', false);	
		}
	}

	function checkTheBox(that) {

		var idCardValue = $('#idcard_nr').val();

		if ($(that).is(':checked')) {

			$('#sso_id_check').val('1');
			$('#sso_id').val(idCardValue);
			$('#sso_id').attr('readonly', true);

		} else {

			$('#sso_id_check').val('0');
			$('#sso_id').val('');
			$('#sso_id').attr('readonly', false);
		}
	}

	function checkTheBoxtaxId(that) {

		var idCardValue = $('#idcard_nr').val();

		if ($(that).is(':checked')) {

			$('#tax_id_check').val('1');
			$('#tax_id').val(idCardValue);
			$('#tax_id').attr('readonly', true);


		} else {

			$('#tax_id_check').val('0');
			$('#tax_id').val('');
			$('#tax_id').attr('readonly', false);


		}
	}


	function changesOtherChkboxW(that) {

		if ($(that).is(':checked')) {

			//$('#peComm11').val('0').attr('disabled', true);
			$('#weComm11').val('1');

		} else {

			//$('#peComm11').val('0').attr('disabled', false);
			$('#weComm11').val('0');
		}
	}


	$("#idcard_nr").on("keyup", function(e) {

		var typedVal = $(this).val();

		if ($('#tax_id_checkbox').is(':checked')) {
			$('#tax_id').val(typedVal);
		}
		if ($('#sso_id_checkbox').is(':checked')) {
			$('#sso_id').val(typedVal);
		}



	})
</script>

<script type="text/javascript">
	$(document).ready(function() {

		var latVal = $('input[name="latitude"]').val();
		var longVal = $('input[name="longitude"]').val();

		function addInfoWindow(marker, message) {
			var infoWindow = new google.maps.InfoWindow({
				content: message
			});
			google.maps.event.addListener(marker, 'click', function() {
				infoWindow.open(map, marker);
			});
		}

		function initialize() {
			var myLatlng = new google.maps.LatLng(latVal, longVal);
			var mapOptions = {
				scrollwheel: false,
				navigationControl: false,
				mapTypeControl: false,
				scaleControl: false,
				draggable: true,
				zoom: 19,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: myLatlng
			}
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			var marker, i, myinfo;

			marker = new google.maps.Marker({
				position: new google.maps.LatLng(latVal, longVal),
				map: map,
				title: 'Wartiz'
			});
			var infowindow = new google.maps.InfoWindow()
			google.maps.event.addListener(marker, 'click', (function(marker, content, infowindow) {
				return function() {
					infowindow.setContent(content);
					infowindow.open(map, marker);
				};
			})(marker, content, infowindow));


			$(window).resize(function() {
				google.maps.event.trigger(map, "resize");
			});
			google.maps.event.addListener(map, "idle", function() {
				google.maps.event.trigger(map, 'resize');
			});
		}
		initialize();


	});
</script>