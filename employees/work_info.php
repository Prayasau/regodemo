<?php
	//var_dump(getSystemUsers(1)); exit;
	$approve_by = getSystemUsers(1);
	
	//var_dump(explode(',',$_SESSION['rego']['sel_branches']));exit;
	if(!$_SESSION['rego']['employee_info']['view']){ 
		echo '<div class="msg_nopermit">You have no access to this page</div>'; exit;
	}
	if(isset($_GET['id'])){$_SESSION['rego']['empID'] = $_GET['id'];}
	
	$delDoc = 'delColor';
	if($_SESSION['rego']['employee_info']['del']){$delDoc = 'delDoc';}

	if(isset($_SESSION['rego']['empID']) && $_SESSION['rego']['empID'] != '0'){ // EDIT EMPLOYEE //////////////
		$empID = $_SESSION['rego']['empID'];

		$ecdata = array();
		$resec = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$empID."' ORDER BY id DESC");
		if($resec->num_rows > 0){
			while($ecdatas = $resec->fetch_assoc()){
				$ecdata[] = $ecdatas;
			}
		}



		$res = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id = '".$empID."'");
		$data = $res->fetch_assoc();
		if(empty($data['image'])){$data['image'] = 'images/profile_image.jpg';}
		$emergency_contacts = unserialize($data['emergency_contacts']);
		$hospitals = unserialize($data['hospitals']);
		$update = 1;
	}else{ // NEW EMPLOYEE /////////////////////////////////////////////////////////////////////////////////
		$empID = 0;
		$button_txt = '';//$lng['Save new employee'];
		$update = 0;

		$sql = "SHOW COLUMNS FROM ".$cid."_employees";
		$res = $dbc->query($sql);
		while($row = $res->fetch_assoc()){
			 $data[$row['Field']] = '';
		}
		if($sys_settings['joining_date'] != 'empty'){
			$data['joining_date'] = date('d-m-Y');
			$data['probation_date'] = date('d-m-Y', strtotime(date('d-m-Y').'+ 4 months'));
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
		$data['organization'] = '1';
		$data['emp_group'] = $sys_settings['emp_group'];
		$data['emp_type'] = $sys_settings['emp_type'];
		$data['emp_status'] = $sys_settings['emp_status'];
		$data['account_code'] = $sys_settings['account_code'];
		$data['position'] = $sys_settings['position'];
		if($sys_settings['date_start'] != 'empty'){
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

	if($data['emergency_contacts'] == ''){
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

	if($data['hospitals'] == ''){
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

	if(empty($data['att_idcard'])){$att_idcard = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$att_idcard = '<a download href="'.ROOT.$cid.'/employees/'.$data['att_idcard'].'"><i class="fa fa-download fa-lg"></i></a>';}
	
	if(empty($data['att_housebook'])){$att_housebook = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$att_housebook = '<a download href="'.ROOT.$cid.'/employees/'.$data['att_housebook'].'"><i class="fa fa-download fa-lg"></i></a>';}
	
	if(empty($data['attach1'])){$attach1 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach1 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach1'].'"><i class="fa fa-download fa-lg"></i></a>';}
	
	if(empty($data['attach2'])){$attach2 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach2 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach2'].'"><i class="fa fa-download fa-lg"></i></a>';}
	
	if(empty($data['attach3'])){$attach3 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach3 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach3'].'"><i class="fa fa-download fa-lg"></i></a>';}
	
	if(empty($data['attach4'])){$attach4 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach4 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach4'].'"><i class="fa fa-download fa-lg"></i></a>';}
	
	$employees = getJsonUserEmployees($cid, $lang);
	$emps = getEmployees($cid, 0);
	//echo '<pre>';
	//var_dump($data['emp_status']); exit;


	$sql11 = "SELECT * FROM ".$cid."_shiftplans_".$cur_year." ORDER BY id ASC";
	if($res11 = $dbc->query($sql11)){
		while($row11 = $res11->fetch_assoc()){

				$shifttest[] =$row11;
				array_unshift($shifttest,"");
				unset($shifttest[0]);
		}
	}

	// echo '<pre>';
	// print_r($rego_settings['all_settings']);
	// echo '<pre>'; exit;

	$emp_def_settings = $rego_settings['all_settings'];  //get default setting for employee...
	$fix_allow = getFixAllowances($sys_settings);
	$getNewFixAllowDeduct = getNewFixAllowDeduct();

	$fixalldedarr = array();
	foreach ($getNewFixAllowDeduct as $key => $value) {
		foreach ($value as $k => $v) {
			$fixalldedarr[$v['id']] = $v[$lang];
		}
	}


?>
<style type="text/css">
	select.orgSel {
	    font-weight: 600;
	}

	.tab {
	  display: none;
	}	
	.tab2 {
	  display: none;
	}

	#modalOpenResponsibilities table.basicTable tbody td{
		padding: 0px !important;
	}

</style>
	<h2 style="position:relative">
		<span><i class="fa fa-users fa-mr"></i> <?=$lng['Work info']?>&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i></span>
		<? if($update){ echo '<span>'.$data['emp_id_editable'].' : '.$data[$lang.'_name'].'</span>';}else{echo $lng['Add employee'];}?>
		<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
	</h2>
	
	<? include('employee_image_inc.php')?>

	<div class="pannel main_pannel">
		<div style="padding:0 0 0 20px" id="dump"></div>	
		
		<ul class="nav nav-tabs">
			
			<li class="nav-item "><a class="nav-link checkWorkTabForUpdateButton active" href="#tab_work" data-toggle="tab"><?=$lng['Work']?></a></li>
			<li class="nav-item "><a class="checkWorkTabForUpdateButton nav-link" href="#tab_time" data-toggle="tab"><?=$lng['Time']?></a></li>
			<li class="nav-item "><a class="checkWorkTabForUpdateButton nav-link" href="#tab_leave" data-toggle="tab"><?=$lng['Leave']?></a></li>
			<li class="nav-item "><a class="checkWorkTabForUpdateButton nav-link" href="#tab_medical" data-toggle="tab"><?=$lng['Medical']?></a></li>
			<li class="nav-item "><a class="checkWorkTabForUpdateButton nav-link" href="#tab_discipline" data-toggle="tab"><?=$lng['Discipline']?></a></li>
		</ul>

		<form id="infoForm" method="post" enctype="multipart/form-data" style="height:calc(100% - 30px)">
		
		<? if(!$update){ ?>
			<input type="hidden" name="pay_type" value="<?=$data['pay_type']?>">
			<input type="hidden" name="calc_psf" value="<?=$data['calc_psf']?>">
			<input type="hidden" name="psf_rate_emp" value="<?=$data['psf_rate_emp']?>">
			<input type="hidden" name="psf_rate_com" value="<?=$data['psf_rate_com']?>">
			<input type="hidden" name="calc_pvf" value="<?=$data['calc_pvf']?>">
			<input type="hidden" name="pvf_rate_emp" value="<?=$data['pvf_rate_emp']?>">
			<input type="hidden" name="pvf_rate_com" value="<?=$data['pvf_rate_com']?>">
			<input type="hidden" name="calc_method" value="<?=$data['calc_method']?>">
			<input type="hidden" name="calc_tax" value="<?=$data['calc_tax']?>">
			<input type="hidden" name="pnd" value="<?=$data['pnd']?>">
			<input type="hidden" name="calc_sso" value="<?=$data['calc_sso']?>">
			<input type="hidden" name="contract_type" value="<?=$data['contract_type']?>">
			<input type="hidden" name="calc_base" value="<?=$data['calc_base']?>">
			<input type="hidden" name="base_ot_rate" value="<?=$data['base_ot_rate']?>">
			<input type="hidden" name="ot_rate" value="<?=$data['ot_rate']?>">
			<input type="hidden" name="allow_login" value="0">

		<? } ?>

			<input type="hidden" name="emp_id" id="emp_id" value="<?=$data['emp_id']?>">
			<fieldset style="height:100%" <? if(!$_SESSION['rego']['employee_info']['edit']){echo 'disabled';} ?>>
				<div class="tab-content" style="height:100%">

					<?if($_SESSION['rego']['empView'] == 'active'){ ?>
						<button id="submitBtn" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>
						<input type="hidden" name="updateEmp" value="1">
					<? } ?>

					<div class="tab-pane active" id="tab_work">
						<div class="tab-content-left">
							<table class="basicTable editTable" border="0">
								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=$lng['EMPLOYMENT DATA']?><a class="text-success float-right" id="openEmployementDataPopup"><i class="fa fa-edit font-weight-bold  fa-lg"></i></a></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Joining date']?></th>
										<td><input readonly style="cursor:pointer" class="datepick" type="text" name="joining_date" id="joining_date" placeholder="..." value="<? if(!empty($data['joining_date'])){echo date('d-m-Y', strtotime($data['joining_date']));}?>"></td>
									</tr>

									<tr>
										<th><?=$lng['Service years']?></th>
										<td class="pad410" id="serv_years"></td>
									</tr>
									
									<tr>
										<th><?=$lng['Employment End Date']?></th>
										<td>
											<input type="text" style="cursor:pointer;width:140px;" name="resign_date" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('d-m-Y', strtotime($data['resign_date']));}?>" readonly="readonly">
												
										</td>
									</tr>
		
									<tr>
										<th><?=$lng['Employee status']?></th><td>
											<select name="emp_status" style="pointer-events: none;width:140px;">
												<? foreach($emp_status as $k=>$v){ ?>
													<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>

								</tbody>

								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=$lng['Organization']?>
											<a class="text-success float-right" id="OrgModalsel"><i class="fa fa-edit font-weight-bold  fa-lg"></i></a>
										</th>
									</tr>
								</thead>
								<tbody>

									<!-- <tr>
										<th><?=$lng['Organization']?></th>
										<td style="color:#999;">
											<select name="organization" id="empTeamOrg" >
												<? foreach($organization as $k=>$v){ ?>
													<option value="<?=$k?>" <?if($k == $data['organization']){echo 'selected';}?>><?=$lng['Organization'] .' → '.$k?></option>
												<? } ?>
											</select>
										</td>
									</tr>  -->
									<tr>
										<th><?=$lng['Company']?></th>
										<td style="color:#999; padding:4px 10px"><span id="txtEntity"><?=$entities[$data['entity']][$lang]?></span>
											<input type="hidden" id="empEntity" name="entity" value="<?=$data['entity']?>">
										</td>
									</tr>
									<tr>
										<th><?=$parameters[1][$lang]?></th>
										<td style="color:#999; padding:4px 10px"><span id="txtBranch"><?=$branches[$data['branch']][$lang]?></span>
											<input type="hidden" id="empBranch" name="branch" value="<?=$data['branch']?>">
										</td>
									</tr>
									<tr>
										<th><?=$parameters[2][$lang]?></th>
										<td style="color:#999; padding:4px 10px"><span id="txtDivision"><?=$divisions[$data['division']][$lang]?></span>
											<input type="hidden" id="empDivision" name="division" value="<?=$data['division']?>">
										</td>
									</tr>
									<tr>
										<th><?=$parameters[3][$lang]?></th>
										<td style="color:#999; padding:4px 10px"><span id="txtDepartment"><?=$departments[$data['department']][$lang]?></span>
											<input type="hidden" id="empDepartment" name="department" value="<?=$data['department']?>">
										</td>
									</tr>
									
									<tr>
										<th><?=$parameters[4][$lang]?></th>
										<td>
											<input type="hidden" name="teams" id="teams" value="<?php echo $data['teams'];?>">
											<input type="hidden" name="team_name" id="team_name" value="<?php echo $data['team_name'];?>" />

											<select name="team" id="empTeam" onchange="getShiftSchedule();getTeamName();" style="pointer-events: none; color:#999; ">
												
												<?php  if(isset($shifttest)){
														$teamsbyacc = explode(',', $_SESSION['rego']['sel_teams']);
														$count = 1;
														foreach($shifttest as $k=>$v){ 

															if(in_array($k, $teamsbyacc)){
															?>

															<option <? if($data['team'] == $k){echo 'selected';}?> value="<?=$k?>"><?php echo strtoupper($v['id'])?> - <?php echo $v['name']?></option>
															
												<?php } } } ?>
											</select>
										</td>
									</tr>
									
								</tbody>
								
						
							</table>
						</div>
						<div class="tab-content-right">
							<table class="basicTable editTable" border="0">
								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=$lng['RESPONSIBILITIES SECTION']?> 

										<!-- <b style="color:#b00;float: right;"><?=$lng['Please change this section in tab Benefits']?></b> -->
										<a class="text-success float-right" id="openResponsibilitiesPopup"><i class="fa fa-edit font-weight-bold  fa-lg"></i></a>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Position']?></th>
										<td>
											<select class="disabledropdown"  name="position" id="position" style="cursor:pointer;width:140px;-webkit-appearance: none;-moz-appearance: none;text-indent: 0.01px;text-overflow: '';">
												<!-- <option value="">...</option> -->
												<? foreach($positions as $k=>$v){ ?>
													<option <? if($ecdata[0]['position'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
											
										</td>
									</tr>
									<tr>
										<th><?=$lng['Date start Position']?></th>
										<td><input readonly type="text" name="date_position" style="cursor:pointer;-webkit-appearance: none;-moz-appearance: none;text-indent: 0.01px;text-overflow: '';" class=" disabledropdown datepick" placeholder="..." value="<?=$data['date_position']?>"></td>
									</tr>
									<tr>
										<th><?=$lng['Head of Location']?></th>
										<td>
											<select name="head_branch" class="disabledropdown" style="-webkit-appearance: none;-moz-appearance: none;text-indent: 0.01px;text-overflow: '';">
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th><?=$lng['Head of division']?></th>
										<td>
											<select name="head_division" class=" disabledropdown" style="-webkit-appearance: none;-moz-appearance: none;text-indent: 0.01px;text-overflow: '';">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th><?=$lng['Head of department']?></th>
										<td>
											<select name="head_department" class=" disabledropdown" style="-webkit-appearance: none;-moz-appearance: none;text-indent: 0.01px;text-overflow: '';">
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th><?=$lng['Team supervisor']?></th>
										<td>
											<select name="team_supervisor" class=" disabledropdown" style="-webkit-appearance: none;-moz-appearance: none;text-indent: 0.01px;text-overflow: '';">
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option <? if($ecdata[0]['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
				
									<tr>
										<td colspan="2" style="height:10px"></td>
									</tr>
								</tbody>
								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=strtoupper($lng['Company User Responsibilities'])?></th>
									</tr>
								</thead>
								
							</table>
						</div>
					</div>


					<div class="tab-pane" id="tab_time">
						<div class="tab-content-left">

							<table class="basicTable editTable" border="0">
								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=$lng['TIME DATA']?></th>
									</tr>
								</thead>
								<tbody>
							

									<tr>
										<th><?=$lng['Shift schedule']?></th>
										<td>
											<?php 
												if(isset($_SESSION['RGadmin']) )
												{ ?> 
													<input type="text" name="shiftplan" id="shiftplan" value="<?=$data['shiftplan']?>" readonly="readonly" >
												<?php }
												else
												{ ?>
													<input type="text" name="shiftplan" id="shiftplan" value="" readonly="readonly" >

												<?php }
											?>
			
										</td>
									</tr>
									<tr>
										<th><?=$lng['Time registration']?></th>
										<td>
											<select name="time_reg">
												<option <? if($data['time_reg'] == 0){echo 'selected';}?> value="0"><?=$lng['No']?></option>
												<option <? if($data['time_reg'] == 1){echo 'selected';}?> value="1"><?=$lng['Yes']?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th><?=$lng['Take selfie']?></th>
										<td>
											<select name="selfie">
												<option <? if($data['selfie'] == 0){echo 'selected';}?> value="0"><?=$lng['No']?></option>
												<option <? if($data['selfie'] == 1){echo 'selected';}?> value="1"><?=$lng['Yes']?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th><?=$lng['Time registration approved by']?></th>
										<td>
											
										</td>
									</tr>
									<tr>
										<td colspan="2" style="height:10px"></td>
									</tr>
								</tbody>
								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=$lng['Location Data']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Work From Home']?></th>
										<td>
											<select required name="workFromHome" id="workFromHome">
												 	
												  <option value="0">No</option>
												  <option value="1">Yes</option>
											</select>
										</td>
									</tr>								
									<tr>
										<th><?=$lng['Ping Location']?></th>
										<td>
											<button onclick="pingEmployeeLocation(this);"style="padding-top: 1px;padding-bottom: 1px;padding-left: 9px;padding-right:9px;margin-left: 10px;"id="exportPlanning" type="button" class="btn btn-primary"><i class="fa fa-map-marker"></i>&nbsp; Ping Employee</button>
										</td>
									</tr>
									
								</tbody>
							</table>

						</div>
						<div class="tab-content-right">

						</div>
					</div>

					<div class="tab-pane" id="tab_leave">
						<div class="tab-content-left">
							<table class="basicTable editTable" border="0">
								<thead>
									<tr style="line-height:100%">
										<th colspan="2"><?=$lng['LEAVE DATA']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Annual leave (days)']?></th>
										<td><input class="sel numeric2" type="text" name="annual_leave" placeholder="__" value="<?=$data['annual_leave'] ? $data['annual_leave'] : $emp_def_settings['leeve'];?>"></td>
									</tr>
									<tr>
										<th><?=$lng['Leave approved by']?></th>
										<td>
											<select name="leave_approve">
												<option value="">...</option>
												<? foreach($approve_by as $k=>$v){ ?>
													<option <? if($data['leave_approve'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>

						</div>
						<div class="tab-content-right">

						</div>
					</div>

					<div class="tab-pane" id="tab_medical">
						<table style="width:100%; height:100%">
							<tr>
								<td style="width:50%; padding-right:15px; vertical-align:top">
									<div id="meTable" style="display:none">
										<table id="medical_table" class="dataTables nowrap hoverable selectable">
											<thead>
												<tr>
													<th><?=$lng['Date']?></th>
													<th data-sortable="false" style="width:80%"><?=$lng['Condition']?></th>
													<th data-sortable="false"><?=$lng['Certificate']?></th>
													<th data-visible="false">x</th>
												</tr>
										 </thead>
										</table>
										<button id="addMedical" class="btn btn-primary btn-xs" style="margin:8px 0 0 0" type="button"><i class="fa fa-plus fa-mr"></i><?=$lng['Add Medical']?></button>
									</div>
								</td>
								<td id="meColor" style="width:50%; background:rgba(200,255,200,0.1); padding:0px; vertical-align:top">
									<div style="overflow-y:auto; height:100%; border:1px solid #eee; padding:1px 5px 5px; position:relative">
										
										<table id="meRecord" class="basicTable">
											<thead>
												<tr style="cursor:pointer; background:transparent">
													<th><i style="width:8px" class="fa fa-caret-right fa-lg"></i>&nbsp; <?=$lng['Medical record']?></th>
												</tr>
											</thead>
										</table>
										
										<div id="recDiv" style="display:xnone; padding-bottom:5px; border-bottom:1px solid #ccc">
										<form id="recordForm" style="height:100%">
											<input name="emp_id" type="hidden" value="<?=$empID?>">
											<table id="medicalTable" class="basicTable nowrap inputs" style="width:100%; display:xnone">
												<tbody>
													<tr>
														<th><?=$lng['Medical contact']?></th>
														<td><input type="text" name="med_contact" placeholder="..." value="<?=$data['med_contact']?>"></td>
													</tr>
													<tr>
														<th><?=$lng['Phone']?></th>
														<td><input type="text" name="med_phone" placeholder="..." value="<?=$data['med_phone']?>"></td>
													</tr>
													<tr>
														<th><?=$lng['Smoker']?></th>
														<td colspan="3">
															<select name="med[smoker" style="width:100%">
																<!--<option selected disabled><? //=$lng['Select']?></option>-->
																<? foreach($yesno as $k=>$v){ ?>
																	<option <? if($data['med_smoker'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
																<? } ?>
															</select>
														</td>
													</tr>
													<tr>
														<th><?=$lng['Medical alert']?></th>
														<td colspan="3"><textarea data-autoresize style="resize:vertical" name="med_alert" rows="2" placeholder="..."><?=$data['med_alert']?></textarea></td>
													</tr>
													<tr>
														<th><?=$lng['Allergies']?></th>
														<td colspan="3"><textarea data-autoresize style="resize:vertical" name="med_allergies" rows="2" placeholder="..."><?=$data['med_allergies']?></textarea></td>
													</tr>
													<tr>
														<th><?=$lng['Disabilities']?></th>
														<td colspan="3"><textarea data-autoresize style="resize:vertical" name="med_disabilities" rows="2" placeholder="..."><?=$data['med_disabilities']?></textarea></td>
													</tr>
													<tr>
														<th><?=$lng['Medication']?></th>
														<td colspan="3"><textarea data-autoresize style="resize:vertical" name="med_medication" rows="2" placeholder="..."><?=$data['med_medication']?></textarea></td>
													</tr>
													<tr style="border:0">
														<td colspan="2" style="padding:4px 8px !important"><b style="display:block; margin-bottom:3px"><?=$lng['Attachments']?></b>
															<div id="meAttach">
															<? if($medical_attach){ foreach($medical_attach as $k=>$v){ ?>
																<div class="attachDiv">
																	<a target="_blank" href="<?=ROOT.$cid.'/medical/'.$v?>" class="link"><?=$v?></a>
																	<a data-key="<?=$k?>" class="icon delAttach"><i class="fa fa-trash"></i></a>
																</div>
															<? } } ?>
															</div>
															<div id="attachRecord" style="clear:both">
																<input style="margin:0 0 5px 0" class="attachBtn" name="attachment[]" type="file" />
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</form>
										</div>
										
										<table id="meHistory" class="basicTable">
											<thead>
												<tr style="cursor:default; background:transparent">
													<th colspan="4"><i style="width:8px" class="fa fa-caret-down fa-lg"></i>&nbsp; <?=$lng['Medical history']?> <span id="hiAction"></span></th>
												</tr>
											</thead>
										</table>
										<div id="hisDiv" style="display:none">
											<form id="historyForm">
												<input type="hidden" name="id" id="hiID" value="0">
												<input type="hidden" name="emp_id" value="<?=$empID?>">
												<table id="medHist" class="basicTable nowrap inputs" style="margin-top:5px">
													<tbody>
														<tr>
															<th><i class="man"></i><?=$lng['Date']?></th>
															<td><input readonly style="cursor:pointer" type="text" name="date_from" placeholder="..." class="datepick"></td>
															<th><?=$lng['Until']?></th>
															<td><input readonly style="cursor:pointer" type="text" name="date_until" placeholder="..." class="datepick"></td>
														</tr>
														<tr>
															<th><i class="man"></i><?=$lng['Condition']?></th>
															<td><input type="text" name="emp_condition" placeholder="..."></td>
														</tr>
														<tr>
															<th><?=$lng['Certificate']?></th>
															<td colspan="3" style="padding:2px 0 0 10px !important">
																<input style="margin:0; display:none" name="certificate" id="certificate" type="file" />
																<button id="certificateBtn" onClick="$('#certificate').click()" style="float:right" class="btn btn-default btn-xs" type="button"><?=$lng['Choose file']?></button>
																<a target="_blank" href="#" style="float:left; padding-top:2px" id="empCertificate"></a>
															</td>
														</tr>
														<tr>
															<th><?=$lng['Doctor']?></th>
															<td colspan="3"><input type="text" name="doctor" placeholder="..."></td>
														</tr>
														<tr>
															<th><?=$lng['Remarks']?></th>
															<td colspan="3"><textarea data-autoresize style="resize:vertical" rows="2" name="remarks" rows="2" placeholder="..."></textarea></td>
														</tr>
														<tr style="border:0">
															<td colspan="4" style="padding:4px 10px !important"><b style="display:block; margin-bottom:3px"><?=$lng['Attachments']?></b>
																<div id="hiAttach"></div>
																<div id="attachHistory" style="clear:both">
																	<input style="margin:0 0 5px 0" class="attachBtn" name="attachment[]" type="file" />
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</form>
										</div>
										<!--<div style="position:absolute; top:5px; right:5px; padding:0 0 0 10px; background:#fff">-->
										<!-- <button id="meBtn" style="position:absolute; top:0px; right:5px;" class="btn btn-primary" type="button"><i class="fa fa-save fa-mr"></i> <?=$lng['Update']?> <?=$lng['Record']?></button> --><!--</div>-->
										
									</div>
								</td>
							</tr>
						</table>

					</div>

					<div class="tab-pane" id="tab_discipline">
						
						<table style="width:100%; height:100%">
							<tr>
								<td style="width:50%; padding-right:15px; vertical-align:top">
									<div id="diTable" style="display:none">
										<table id="discipline_table" class="dataTables nowrap hoverable selectable">
											<thead>
												<tr>
													<th><?=$lng['Date']?></th>
													<th data-sortable="false"><?=$lng['Type of warning']?></th>
													<th data-sortable="false" style="width:80%"><?=$lng['Type of violation']?></th>
													<th data-sortable="false"><?=$lng['Status']?></th>
													<th data-visible="false">x</th>
												</tr>
										 </thead>
										</table>
										<button id="addDiscipline" class="btn btn-primary btn-xs" style="margin:8px 0 0 0" type="button"><i class="fa fa-plus fa-mr"></i><?=$lng['Add Discipline']?></button>
									</div>
								</td>
								<td id="diColor" style="width:50%; background:rgba(200,255,200,0.1); padding:0px; vertical-align:top">
									<div style="overflow-y:auto; height:100%; border:1px solid #eee; padding:1px 5px 5px; position:relative">
									<form id="disciplineForm">
										<input type="hidden" name="id" id="diID" value="0">
										<input type="hidden" name="field" value="discipline">
										<input type="hidden" name="emp_id" value="<?=$empID?>">
										<table id="disciplineTable" class="basicTable nowrap" style="width:100%; display:none">
											<thead>
												<tr style="background:transparent">
													<th colspan="2"><?=$lng['Warning']?> <span id="diAction"></span></th>
												</tr>
											</thead>	
											<tbody>
												<tr>
												<th><i class="man"></i><?=$lng['Date']?></th>
													<td style="padding:0">
														<input readonly style="cursor:pointer" class="datepick"  type="text" name="date" placeholder="..." value="<? //=$birthdate?>">
													</td>
												</tr>
												<tr>
													<th><i class="man"></i><?=$lng['Type of warning']?></th>
													<td colspan="3" style="padding:0">
														<select name="warning">
															<option value="0" selected disabled><?=$lng['Select']?></option>
															<? foreach($warnings as $k=>$v){ ?>
																<option value="<?=$k?>"><?=$v?></option>
															<? } ?>
														</select>
													</td>
												</tr>
												<tr>
													<th><i class="man"></i><?=$lng['Type of violation']?></th>
													<td colspan="3" style="padding:0">
														<select name="violation">
															<option value="0" selected disabled><?=$lng['Select']?></option>
															<? foreach($violations as $k=>$v){ ?>
																<option value="<?=$k?>"><?=$v?></option>
															<? } ?>
														</select>
													</td>
												</tr>
												<tr>
													<th><?=$lng['Status']?></th>
													<td style="padding:0">
														<select name="status">
															<? foreach($oc_status as $k=>$v){ ?>
																<option value="<?=$k?>"><?=$v?></option>
															<? } ?>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="2"><b><?=$lng['Description of Infraction']?></b>
														<textarea data-autoresize name="infraction" style="padding:0 8px; resize:vertical" rows="2" placeholder="..."></textarea>
													</td>
												</tr>
												<tr>
												<tr>
													<td colspan="2" style="padding:3px 8px"><b><?=$lng['Damage caused']?> (<?=$lng['THB']?>) : </b>
														<input style="width:150px" type="text" class="numeric sel" name="damage" placeholder="..." value="">
													</td>
												</tr>
												<tr>
													<td colspan="2"><b><?=$lng['Plan for Improvement']?></b><br>
														<textarea data-autoresize name="improvement" style="padding:0 8px; resize:vertical" rows="2" placeholder="..."></textarea>
													</td>
												</tr>
												<tr>
													<td colspan="2"><b><?=$lng['Consequences of Further Infractions']?></b>
														<textarea data-autoresize name="consequences" style="padding:0 8px; resize:vertical" rows="2" placeholder="..."></textarea>
													</td>
												</tr>
												<tr>
													<td colspan="2"><b><?=$lng['Employee statement']?></b><br>
														<textarea data-autoresize name="employee" style="padding:0 8px; resize:vertical" rows="2" placeholder="..."></textarea>
													</td>
												</tr>
												<tr>
													<td colspan="2"><b><?=$lng['Employer statement']?></b><br>
														<textarea data-autoresize name="employer" style="padding:0 8px; resize:vertical" rows="2" placeholder="..."></textarea>
													</td>
												</tr>
												<tr>
													<td colspan="2"><b><?=$lng['Witness']?></b><br>
														<textarea data-autoresize name="witness" style="padding:0 8px; resize:vertical" rows="2" placeholder="..."></textarea>
													</td>
												</tr>
												<tr style="border:0">
													<td colspan="2"><b style="display:block; margin-bottom:3px"><?=$lng['Attachments']?></b>
														<div id="diAttach"></div>
														<div id="attachDiscipline" style="clear:both">
															<input style="margin:0 0 5px 0" class="attachBtn" name="attachment[]" type="file" />
														</div>
													</td>
												</tr>
											</tbody>
										</table>
										<!-- <button id="diBtn" class="btn btn-primary" style="position:absolute; top:0px; right:5px; display:none" type="submit"><i class="fa fa-save fa-mr"></i> <?=$lng['Update']?> <?=$lng['Discipline']?></button> -->
									</form>
									</div>
								</td>
							</tr>
						</table>
					</div>

				</div>
			</fieldset>
		</form>
	</div>

	<div class="modal fade" id="chooseEmail" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top:110px;">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=strtoupper($lng['Choose Email'])?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span onclick="closeEmailModal();" aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs" style="padding:10px 0">
					
						<table class="basicTable inputs" border="0" style="width: 100%;">
							<tbody>
								<tr>
									<td>
										<th><?=$lng['Select']?></th>
									</td>
									<td>
										<select style="width: 92%;" id="chooseEmailSelect" name="chooseEmailSelect"></select>
									</td>
								</tr>
	
							</tbody>
						</table>

						<div class="clear" style="height:15px"></div>

						<button id="pingEmployee" class="btn btn-primary btn-fr mr-4" type="button" onclick="pingEmployeeAjax();"><i class="fa fa-map-marker"></i>&nbsp; <?=$lng['Ping Employee']?></button>
						
						<button class="btn btn-primary mr-1 btn-fr" type="button" data-dismiss="modal" onclick="closeEmailModal()"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
						<div class="clear"></div>

				</div>
			</div>
		</div>
	</div>

	<!-- Modal organization selection -->
	<div class="modal fade" id="modalorganization" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-building-o"></i>&nbsp; <?=$lng['Organization Chart']?></h5>
					<button type="button" class="close closeEditEmploymentDataPopup" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2 class="text-danger text-center font-italic">
						<?=$lng['Reduce the number until 1 remains for each item']?>
					</h2>
					<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto;">
						<thead>
							<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
								
								<?if(count($entities) > 1){ ?>
									<th style="color:#fff"><?=$lng['Company']?></th>
								<? } ?>
								<? if($parameters[1]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[1][$lang]?></th>
								<? } ?>
								<? if($parameters[2]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[2][$lang]?></th>
								<? } ?>
								<? if($parameters[3]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[3][$lang]?></th>
								<? } ?>
								<? if($parameters[4]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[4][$lang]?></th>
								<? } ?>

							
							</tr>
						</thead>
						<tbody>
							<tr style="background:#f9f9f9">
									
								<?if(count($entities) > 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="entities" id="userEntities">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($entities as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>
										
									</td>
								<? } ?>
								
								<? if($parameters[1]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="branches"  id="userBranches">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($branches as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[2]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="divisions" id="userDivisions">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($divisions as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[3]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="departments" id="userDepartments">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($departments as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[4]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="teams"  id="userTeams">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($teams as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v['code'].' - '.$v[$lang]?></option>
										<? } ?>
										</select>		
									</td>
								<? } ?>
							</tr>
						</tbody>
						<tbody id="accessBodyorg">

							<tr>
								<?if(count($entities) > 1){ ?>
									<td><?=$entities[$data['entity']][$lang]?></td>
								<? } ?>

								<? if($parameters[1]['apply_param'] == 1){ ?>
									<td><?=$branches[$data['branch']][$lang]?></td>
								<? } ?>

								<? if($parameters[2]['apply_param'] == 1){ ?>
									<td><?=$divisions[$data['division']][$lang]?></td>
								<? } ?>

								<? if($parameters[3]['apply_param'] == 1){ ?>
									<td><?=$departments[$data['department']][$lang]?></td>
								<? } ?>

								<? if($parameters[4]['apply_param'] == 1){ ?>
									<td><?=$teams[$data['team']][$lang]?></td>
								<? } ?>
							</tr>

						</tbody>
					</table>

				</div>
				<div class="modal-footer" style="display: block !important;">
		        	<button type="button" class="btn btn-primary btn-fr" data-dismiss="modal"><?=$lng['Cancel']?></button>
		        	<span id="spnmsg" class="text-danger text-left font-weight-bold p-4"></span>
		        	<button type="button" class="btn btn-primary btn-fl ConfirmSelection" id="confirmbtn" disabled="disabled"><?=$lng['Confirm']?></button>
		      	</div>
			</div>
		</div>
	</div>


<div class="modal fade" id="modalOpenResponsibilities" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords('Edit Responsibilities')?></h5>
					<button type="button" class="close closeEditEmploymentDataPopup" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="careerForm">

						<input type="hidden" name="emp_id" value="<?=$empID?>">
						<input type="hidden" name="career_id_curr" value="<?=isset($ecdata) ? $ecdata[0]['id'] : '';?>">

						
						<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Select Start Date']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Start Date']?></th>
										<td><input type="text" id="sdates" class="" name="start_date_new" autocomplete="off"></td>
										<td><input type="text" class="datepick1" name="start_date_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['start_date'])){echo date('d-m-Y', strtotime($ecdata[0]['start_date']));}?>"></td>
									</tr>

									<tr>
										<th><?=$lng['End date']?></th>
										<td><input type="text" name="end_date_new" autocomplete="off" readonly></td>
										<td><input type="text" name="end_date_curr" id="end_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['end_date'])){echo date('d-m-Y', strtotime($ecdata[0]['end_date']));}?>" readonly></td>
									</tr>

									<tr>
										<th><?=$lng['Position']?></th>
										<td>
											<select name="position_new">
												<option value="">...</option>
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" ><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="position_curr">
												<option value="">...</option>
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" <?if($v['id'] == $ecdata[0]['position']){echo 'selected';}?>><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>


								</tbody>
							</table>
						</div>
						<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['RESPONSIBILITIESS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Head of Location']?></th>
										<td>
											<select name="head_branch_new" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_branch_cur" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									

									<tr>
										<th><?=$lng['Head of division']?></th>
										<td>
											<select name="head_division_new">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_division_cur">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Head of department']?></th>
										<td>
											<select name="head_department_new" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_department_curr" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Team supervisor']?></th>
										<td>
											<select name="team_supervisor_new" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="team_supervisor_curr" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option <? if($ecdata[0]['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
			
								</tbody>
							</table>
						</div>

						<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Other']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<th><?=$lng['Other benefits']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['other_benifits'] : '';?></textarea>
										</td>
									</tr>

									<tr>
										<th><?=$lng['Remarks']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['remarks'] : '';?></textarea>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Attachments']?></th>
										<td>
											<input type="file" name="attachment_new[]">
										</td>
										<td>
											<input type="file" name="attachment_curr[]">
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn" onclick="nextPrev(1)"><?=$lng['Next']?></button>
						    </div>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>


	<div class="modal fade" id="modalOpenEmploymentData" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Edit Employment Data'])?></h5>
					<button  type="button" class="close closeEditEmploymentDataPopup" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="employementDataForm">

						<input type="hidden" name="emp_id" value="<?=$empID?>">

						
						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Select Joining Date']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Joining date']?></th>
										<td><input  class="datepick" type="text" name="joining_date_2" id="joining_date_2" placeholder="..." value="<? if(!empty($data['joining_date'])){echo date('d-m-Y', strtotime($data['joining_date']));}?>"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
		<!-- 							<tr>
										<th>No end of employment</th>
										<td>
											<input type="radio" id="noEndOfEmployment" class="ml-2 mt-2 checkbox-custom-blue-2" name="endofemployment" value="0" >
										</td>
									</tr>	 -->					
									<tr>
										<th>End of employment</th>
										<td>
											<input type="checkbox" id="endOfEmployment" class="ml-2 mt-1 checkbox-custom-blue-2" name="endofemployment" value="1" checked="checked">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab2 dateTab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Employment End Date']?></th>
										<td>

										<input class="datepick"  type="text" style="width:140px;" id="resign_date2" name="resign_date2" placeholder="..." value="" >

										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab2 nextToNextTab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Employee status']?></th>
										<td>
											<select id="emp_status2val"  name="emp_status2" style="width:140px;display: none;">
												<? foreach($emp_status2 as $k=>$v){ ?>
													<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>

											<select id="emp_status3val" name="emp_status3" style="width:140px;display: none;">
												<? foreach($emp_status3 as $k=>$v){ ?>
													<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab2 noticeDateDiv">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Notice date</th>
										<td>

										<input class="datepick"  type="text" style="width:140px;" id="notice_day_field" name="notice_day_field" placeholder="..." value="<? if(!empty($data['notice_date'])){echo date('d-m-Y', strtotime($data['notice_date']));}?>" >

										</td>
									</tr>								

									<tr>
										<th>Last working day</th>
										<td>

										<input class="datepick"  type="text" style="width:140px;pointer-events: none;" id="last_working_day" name="last_working_day" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('d-m-Y', strtotime($data['resign_date']));}?>" >

										</td>
									</tr>									
									<tr>
										<th>End of employment reason</th>
										<td>

										<input type="text" style="width:140px;" id="end_of_employment_reason" name="end_of_employment_reason" placeholder="..." value="<? if(!empty($data['resign_reason'])){echo $data['resign_reason'];}?>" >

										</td>
									</tr>									
									<tr>
										<th>Last month in payroll</th>
										<td>

											<input type="text" style="width:140px;" id="last_month_payroll" name="last_month_payroll" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('m', strtotime($data['resign_date']));}?>" >

										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: center;color: red;font-weight: 600;">Other data on end of contract can be filled in section End contract</td>
									</tr>
								</tbody>
							</table>
						</div>



		

						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl prevBtn2" id="prevBtn2" onclick="backPrev2(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr nextBtn2" id="nextBtn2" onclick="nextPrev2(1)"><?=$lng['Next']?></button>
						    </div>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>

	<? include('employee_new_edit_script.php')?>

	<script>

	function checkEmpIdExist(emp_id_editable){

		$.ajax({
			url: "ajax/get_employee_id_editable.php",
			data: {emp_id_editable: emp_id_editable},
			success: function(result){
				if(result == 1){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i> <?=$lng['Employee'].' '.$lng['ID exist already']?>',
						duration: 2,
					})
					$('input[name="emp_id_editable"]').val('').focus();
					//$('#submitBtn').attr('disabled',true);
				}else{
					//$('#submitBtn').attr('disabled',false);
				}
			}
		})
	}

	function getUsernameval(that)
	{
		var val = that;
		if(val == 1){
			var pe = $('input[name="personal_email"]').val();
			$('input[name="username"]').val(pe).attr('readonly',true);
		}else if(val == 2){
			var we = $('input[name="work_email"]').val();
			$('input[name="username"]').val(we).attr('readonly',true);
		}else if(val == 3){
			$('input[name="username"]').val('').attr('readonly',false).focus();
		}else{
			$('input[name="username"]').attr('readonly',true);
		}
	}

	
	$(document).ready(function() {
		
		var update = <?=json_encode($update)?>;
		var emp_id = <?=json_encode($_SESSION['rego']['empID'])?>;
		var employees = <?=json_encode($employees)?>;
		var teams = <?=json_encode($teams)?>;
		var entities = <?=json_encode($entities)?>;
		var branches = <?=json_encode($branches)?>;
		var divisions = <?=json_encode($divisions)?>;
		var departments = <?=json_encode($departments)?>;
		var groups = <?=json_encode($groups)?>;
		var organization = <?=json_encode($organization)?>;
		var parameters = <?=json_encode($parameters)?>;
		var eCount = <?=count($entities)?>;
		
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

		$(document).on("click", "#OrgModalsel", function(e){
			$('#modalorganization').modal('toggle');
		})

		$(document).on("change", ".orgSel", function(e){

			var entity = '';
			var branch = '';
			var division = '';
			var department = '';
			var team = '';
			var btnactive = [];

			if(eCount > 1){ 
				entity = $('#modalorganization #userEntities').val();
			}

			if(parameters[1]['apply_param'] == 1){ 
				branch = $('#modalorganization #userBranches').val();
				if(branch >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
			}

			if(parameters[2]['apply_param'] == 1){ 
				division = $('#modalorganization #userDivisions').val();
				if(division >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
			}

			if(parameters[3]['apply_param'] == 1){ 
				department = $('#modalorganization #userDepartments').val();
				if(department >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
			}

			if(parameters[4]['apply_param'] == 1){ 
				team = $('#modalorganization #userTeams').val();
				if(team >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
			} 

			//console.log(btnactive);
			//$('#modalorganization span#spnmsg').addClass('text-danger').text('Selection incomplete');


			if($.inArray(0, btnactive) !== -1) {
				$('#modalorganization #confirmbtn').attr('disabled', true);
			}else{ 
				$('#modalorganization #confirmbtn').attr('disabled', false);
			}

			$.ajax({
				url: "ajax/get_orgnization_selection.php",
				type: "POST", 
				data: {entity:entity, branch:branch, division:division, department:department, team:team},
				success: function(result){

					$('#modalorganization #usersAccess tbody#accessBodyorg tr').remove();
					$('#modalorganization #usersAccess tbody#accessBodyorg').html(result);

					var remainingRows = $('#modalorganization #usersAccess tbody#accessBodyorg tr').length;
					
					if(remainingRows == 1) {
						$('#modalorganization #confirmbtn').attr('disabled', false);
						$('#modalorganization span#spnmsg').removeClass('text-danger').addClass('text-success').text('Selection Complete');
					}else{ 
						$('#modalorganization #confirmbtn').attr('disabled', true);
						$('#modalorganization span#spnmsg').addClass('text-danger').removeClass('text-success').text('Selection incomplete');
					}
				}
			})



		})


		var meTable = $('#medical_table').DataTable({
			scrollY: false,
			scrollX: false,
			lengthChange: false,
			searching: false,
			ordering: true,
			paging: false,
			filter: false,
			info: false,
			<?=$dtable_lang?>
			processing: false,
			serverSide: true,
			order: [0, 'desc'],
			ajax: {
				url: ROOT+"employees/ajax/server_get_medical.php",
				type: 'POST',
				"data": function(d){
					d.emp_id = emp_id;
				}
			},
			columnDefs: [
				  //{"targets": [1], "class": 'pad1' },
				  //{"targets": [3], "width": '80%' },
				  //{"targets": sCols, "visible": true },
			],
			initComplete : function( settings, json ) {
				$('#meTable').fadeIn(400);
				meTable.columns.adjust().draw();
			}
		});
		
		$(document).on('click','#medical_table tbody tr', function(){
			var id = meTable.row(this).data()[3];
			$.ajax({
				url: "ajax/get_employee_benefit.php",
				type: "POST", 
				data: {id: id, field: 'medical'},
				dataType: 'json',
				success: function(data){
					$('#hiAction').html('- Edit');
					$("#hiID").val(data.id);
					$('#historyForm input[name="date_from"]').val(data.date_from)
					$('#historyForm input[name="date_until"]').val(data.date_until)
					$('#historyForm input[name="emp_condition"]').val(data.emp_condition)
					$('#historyForm #empCertificate').html(data.certificate)
					$('#historyForm #empCertificate').attr('href', '<?=ROOT.$cid?>/medical/'+data.certificate)
					$('#historyForm input[name="doctor"]').val(data.doctor)
					$('#historyForm textarea[name="remarks"]').val(data.remarks)
					$('#hiAttach').empty();
					$.each(data.attachment, function(i,val){
						$('#hiAttach').append(
							'<div class="attachDiv">'+
								'<a target="_blank" href="<?=ROOT.$cid?>/medical/'+val+'"class="link">'+val+'</a>'+
								'<a data-key="'+i+'" class="icon delAttach"><i class="fa fa-trash"></i></a>'+
							'</div>'
						)
					})
					$("#meColor").css('background', 'rgba(200,255,200,0.1)');
					$('#meRecord thead tr th i').removeClass('fa-caret-right').addClass('fa-caret-down')
					$('#recDiv').slideUp(200);
					$('#meHistory thead tr th i').removeClass('fa-caret-down').addClass('fa-caret-right')
					$('#hisDiv').slideDown(200);
					$('#meBtn').hide()
					$('#hiBtn').show()
					autosize.destroy(document.querySelectorAll('textarea'));
					autosize(document.querySelectorAll('textarea'));
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})

		$("#addMedical").on('click', function(e){
			$('#meRecord thead tr th i').removeClass('fa-caret-right').addClass('fa-caret-down')
			$('#recDiv').slideUp(200);
			$('#meHistory thead tr th i').removeClass('fa-caret-down').addClass('fa-caret-right')
			$('#hisDiv').slideDown(200);
			$("#historyForm").trigger('reset');
			$('#hiAttach').empty();
			$('#hiAction').html('- New');
			$('#empCertificate').html('');
			$('#empCertificate').attr('href', '#');
			$('#certificateBtn').html('Choose file');
			$("#hiID").val(0);
			$("#meColor").css('background', 'rgba(255,200,200,0.08)');
			$("table#medical_table tr").removeClass("selected");
			$('#meBtn').hide()
			$('#hiBtn').show()
		})


		$("#meBtn").on('click', function(e){
			$("#recordForm").submit();
		})
		$("#recordForm").on('submit', function(e){
			e.preventDefault();
			$("#meBtn i.mBut").removeClass('fa-save').addClass('fa-repeat fa-spin');
			var formData = new FormData(this);
			$.ajax({
				url: "ajax/update_medical_record.php",
				type: "POST", 
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				success: function(data){
					//$("#dump").html(data); return false;
					if(data.result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
						})
						$('#sAlert').fadeOut(200);
						if(data.attachment != ''){
							$('#meAttach').empty();
							$('#attachRecord').empty();
							$('#attachRecord').append('<input style="margin:0 0 5px 0" class="attachBtn" name="attachment[]" type="file" />');
							$.each(data.attachment, function(i, val){
								$('#meAttach').append(
									'<div class="attachDiv">'+
										'<a target="_blank" href="<?=ROOT.$cid?>/medical/'+val+'"class="link">'+val+'</a>'+
										'<a data-key="'+i+'" class="icon delAttach"><i class="fa fa-trash"></i></a>'+
									'</div>'
								)
							})
						}
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
							duration: 4,
						})
					}
					setTimeout(function(){
						$("#meBtn i.mBut").removeClass('fa-repeat fa-spin').addClass('fa-save');
						$("#meBtn").removeClass('flash');
					},500);
				},
				error:function (xhr, ajaxOptions, thrownError){
					$(".submitbtn").removeClass('flash');
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
					setTimeout(function(){
						$("#meBtn i.mBut").removeClass('fa-repeat fa-spin').addClass('fa-save');
						$("#meBtn").removeClass('flash');
					},500);
				}
			});
		})


		//================DISCIPLINE FORM ==============
		var diTable = $('#discipline_table').DataTable({
			scrollY: false,
			scrollX: false,
			lengthChange: false,
			searching: false,
			ordering: false,
			paging: false,
			filter: false,
			info: false,
			<?=$dtable_lang?>
			processing: false,
			serverSide: true,
			//order: [0, 'desc'],
			ajax: {
				url: "ajax/server_get_discipline.php",
				type: 'POST',
				"data": function(d){
					d.emp_id = emp_id;
				}
			},
			columnDefs: [
				  //{"targets": [1], "class": 'pad1' },
				  //{"targets": [3], "width": '80%' },
				  //{"targets": sCols, "visible": true },
			],
			initComplete : function( settings, json ) {
				$('#diTable').fadeIn(200);
				diTable.columns.adjust().draw();
			}
		});
		$(document).on('click','#discipline_table tbody tr', function(){
			var id = diTable.row(this).data()[4];
			$.ajax({
				url: "ajax/get_employee_benefit.php",
				type: "POST", 
				data: {id: id, field: 'discipline'},
				dataType: 'json',
				success: function(data){
					//$("#dump").html(data); //return false;
					$('#diID').val(data.id);
					$('#disciplineForm input[name="date"]').val(data.date)
					$('#disciplineForm select[name="status"]').val(data.status)
					$('#disciplineForm select[name="warning"]').val(data.warning)
					$('#disciplineForm select[name="violation"]').val(data.violation)
					$('#disciplineForm textarea[name="infraction"]').val(data.infraction)
					$('#disciplineForm textarea[name="improvement"]').val(data.improvement)
					$('#disciplineForm textarea[name="consequences"]').val(data.consequences)
					$('#disciplineForm textarea[name="employee"]').val(data.employee)
					$('#disciplienForm textarea[name="employer"]').val(data.employer)
					$('#disciplineForm textarea[name="witness"]').val(data.witness)
					$('#diAttach').empty();
					$.each(data.attachment, function(i,val){
						$('#diAttach').append(
							'<div class="attachDiv">'+
								'<a target="_blank" href="<?=ROOT.$cid?>/discipline/'+val+'"class="link">'+val+'</a>'+
								'<a data-key="'+i+'" class="icon delAttach"><i class="fa fa-trash"></i></a>'+
							'</div>'
						)
					})
					$("#diColor").css('background', 'rgba(200,255,200,0.1)');
					$("#disciplineTable").show();
					$("#diBtn").show();
					$("#diAction").html('- Edit');
					autosize.destroy(document.querySelectorAll('textarea'));
					autosize(document.querySelectorAll('textarea'));
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})
		$("#addDiscipline").on('click', function(e){
			$("#disciplineForm").trigger('reset');
			$('#diAttach').empty();
			$("#diID").val(0);
			$("#disciplineTable").show();
			$("#diBtn").show();
			$("#diAction").html('- New');
			$("#diColor").css('background', 'rgba(255,200,200,0.08)');
			$("table#discipline_table tr").removeClass("selected");
		})
		$("#disciplineForm").on('submit', function(e){
			e.preventDefault();
			var err = 0;		
			if($('#disciplineForm input[name="position"]').val() == ""){err = 1}
			if($('#disciplineForm input[name="start_date"]').val() == ""){err = 1}
			if(err){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
					duration: 4,
				})
				return false;
			}
			$("#diBtn i").removeClass('fa-save').addClass('fa-repeat fa-spin');
			var formData = new FormData($('#disciplineForm')[0]);
			$.ajax({
				url: "ajax/update_benefits.php",
				type: "POST", 
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				success: function(data){
					//$("#dump").html(data); return false;
					if(data.result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
						})
						$('#sAlert').fadeOut(200);
						diTable.ajax.reload(null, false);
						if(data.attach != ''){
							$('#diAttach').empty();
							$('#attachDiscipline').empty();
							$('#attachDiscipline').append('<input style="margin:0 0 5px 0" class="attachBtn" name="attachment[]" type="file" />');
							$.each(data.attachment, function(i,val){
								$('#diAttach').append(
									'<div class="attachDiv">'+
										'<a target="_blank" href="<?=ROOT.$cid?>/discipline/'+val+'"class="link">'+val+'</a>'+
										'<a data-key="'+i+'" class="icon delAttach"><i class="fa fa-trash"></i></a>'+
									'</div>'
								)
							})
						}
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
							duration: 4,
						})
					}
					setTimeout(function(){
						$("#diBtn i").removeClass('fa-repeat fa-spin').addClass('fa-save');
						$("#diBtn").removeClass('flash');
					},500);
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
					setTimeout(function(){
						$("#diBtn i").removeClass('fa-repeat fa-spin').addClass('fa-save');
						$("#diBtn").removeClass('flash');
					},500);
				}
			});
		})
		$(document).on('change', "#disciplineForm .attachBtn", function(e){
			readFileURL(this, '#attachDiscipline');
			$("#diBtn").addClass('flash');
			$('#sAlert').fadeIn(200);
		})
		$(document).on("click", "#disciplineForm .delAttach", function(e){
			var key = $(this).data('key')
			var app = $(this);
			$.ajax({
				url: "ajax/delete_benefit_attach.php",
				data: {id: $("#diID").val(), key: key, field: 'discipline'},
				success: function(result){
					//$('#dump').html(result);
					app.parent().remove();
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?>&nbsp;&nbsp;<b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});
		$('#disciplineForm input, #disciplineForm textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#diBtn").addClass('flash');
		})
		$('#disciplineForm select').on('change', function(e){
			$('#sAlert').fadeIn(200);
			$("#diBtn").addClass('flash');
		})
		$('#disciplineForm .datepick').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: lang,//lang+'-th',
			todayHighlight: true,
		}).on('changeDate', function(ev){
			$('#sAlert').fadeIn(200);
			$("#diBtn").addClass('flash');
		});

		//================DISCIPLINE FORM END ==============


		$('.ConfirmSelection').on('click', function(e){

			var orgval = $('#modalorganization #usersAccess tbody#accessBodyorg tr').data('id');
			
			if(orgval == ''){
				$('#empEntity').val('')
				$('#empBranch').val('')
				$('#empDivision').val('')
				$('#empDepartment').val('')
				$('#teams').val('')

				$('#txtEntity').html('...')
				$('#txtBranch').html('...')
				$('#txtDivision').html('...')
				$('#txtDepartment').html('...')
				$('#team_name').val('MAIN')
				$('#teams').val('main')
				//$('#txtGroups').html('...')
			}else{
				
				$('#empTeam option').attr('selected',false)


				$('#empEntity').val(organization[orgval]['company'])
				$('#txtEntity').html(entities[organization[orgval]['company']][lang])

				if(parameters[1]['apply_param'] == 1){
					$('#empBranch').val(organization[orgval]['locations'])
					$('#txtBranch').html(branches[organization[orgval]['locations']][lang])
				}
				if(parameters[2]['apply_param'] == 1){
					$('#empDivision').val(organization[orgval]['divisions'])
					$('#txtDivision').html(divisions[organization[orgval]['divisions']][lang])
				}
				if(parameters[3]['apply_param'] == 1){
					$('#empDepartment').val(organization[orgval]['departments'])
					$('#txtDepartment').html(departments[organization[orgval]['departments']][lang])
				}
				if(parameters[4]['apply_param'] == 1){
					$('#teams').val(teams[organization[orgval]['teams']][lang])
					$('#team_name').val(teams[organization[orgval]['teams']][lang])
					$('#empTeam option[value="'+organization[orgval]['teams']+'"]').attr('selected',true)
				}

				
				//$('#txtGroups').html(groups[teams[$(this).val()]['groups']][lang])
			}

			$('#modalorganization').modal('hide');
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})


		
		$('#empTeamOrg').on('change', function(e){
			//alert($(this).val());
			if($(this).val() == ''){
				$('#empEntity').val('')
				$('#empBranch').val('')
				$('#empDivision').val('')
				$('#empDepartment').val('')
				$('#teams').val('')

				$('#txtEntity').html('...')
				$('#txtBranch').html('...')
				$('#txtDivision').html('...')
				$('#txtDepartment').html('...')
				$('#team_name').val('MAIN')
				$('#teams').val('main')
				//$('#txtGroups').html('...')
			}else{
				
				$('#empTeam option').attr('selected',false)
				
				/*$('#empEntity').val(teams[$(this).val()]['entity'])
				$('#empBranch').val(teams[$(this).val()]['branch'])
				$('#empDivision').val(teams[$(this).val()]['division'])
				$('#empDepartment').val(teams[$(this).val()]['department'])
				$('#txtEntity').html(entities[teams[$(this).val()]['entity']][lang])
				$('#txtBranch').html(branches[teams[$(this).val()]['branch']][lang])
				$('#txtDivision').html(divisions[teams[$(this).val()]['division']][lang])
				$('#txtDepartment').html(departments[teams[$(this).val()]['department']][lang])
				$('#txtGroups').html(groups[teams[$(this).val()]['groups']][lang])*/


				$('#empEntity').val(organization[$(this).val()]['company'])
				$('#txtEntity').html(entities[organization[$(this).val()]['company']][lang])

				if(parameters[1]['apply_param'] == 1){
					$('#empBranch').val(organization[$(this).val()]['locations'])
					$('#txtBranch').html(branches[organization[$(this).val()]['locations']][lang])
				}
				if(parameters[2]['apply_param'] == 1){
					$('#empDivision').val(organization[$(this).val()]['divisions'])
					$('#txtDivision').html(divisions[organization[$(this).val()]['divisions']][lang])
				}
				if(parameters[3]['apply_param'] == 1){
					$('#empDepartment').val(organization[$(this).val()]['departments'])
					$('#txtDepartment').html(departments[organization[$(this).val()]['departments']][lang])
				}
				if(parameters[4]['apply_param'] == 1){
					$('#teams').val(teams[organization[$(this).val()]['teams']][lang])
					$('#team_name').val(teams[organization[$(this).val()]['teams']][lang])
					$('#empTeam option[value="'+organization[$(this).val()]['teams']+'"]').attr('selected',true)
				}

				
				//$('#txtGroups').html(groups[teams[$(this).val()]['groups']][lang])
			}
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})

		$('#emp_prefix').on('change', function(e){
			$.ajax({
				url: "ajax/get_employee_id.php",
				data: {prefix: this.value},
				success: function(result){
					//$('#dump').html(result); return false;
					$('#emp_id').val(result);
					$('#empID').html(result);
				}
			})
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})

		$("#infoForm").on('submit', function(e){ // SUBMIT EMPLOYEE FORM ///////////////////////////////////
			//e.preventDefault();
			var err = 0;
			if($('input[name="emp_id"]').val() == ''){err = 1;}
			//if($('input[name="emp_id_editable"]').val() == ''){err = 1;}
			//if($('select[name="title"]').val() == null){err = 1;}
			//if($('input[name="firstname"]').val() == ''){err = 1;}
			//if($('input[name="lastname"]').val() == ''){err = 1;}

			
			if(err){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
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
				success: function(result){
					//$('#dump').html(result); return false;
					//$("#submitBtn").removeClass('flash');
					//$("#sAlert").fadeOut(200); 
					//return false
					if($.trim(result) == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 3,
							callback: function(value){
								location.reload();
							}
						})
						/*if(!update){
							setTimeout(function(){location.reload();},1000);
						}*/
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
						})
					}
					$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})
		
	// PERSONAL FORM /////////////////////////////////////////////////////////////////////////////
		$('input, textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})
		$('select').on('change', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})

		$('input[name="firstname"],input[name="lastname"]').on('change', function(){
			$('input[name="bank_account_name"]').val($('input[name="firstname"]').val()+' '+$('input[name="lastname"]').val());
		})

	// DOCUMENTS ///////////////////////////////////////////////////////////////////////////////
		$("#att_idcard").change(function(){
			readAttURL(this,'#idcard_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#att_housebook").change(function(){
			readAttURL(this,'#housebook_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach1").change(function(){
			readAttURL(this,'#attach1_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach2").change(function(){
			readAttURL(this,'#attach2_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach3").change(function(){
			readAttURL(this,'#attach3_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach4").change(function(){
			readAttURL(this,'#attach4_name');
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
			title: '<?=$lng['Are you sure']?>',
			btnOkClass: 'btn btn-danger',
			btnOkLabel: '<?=$lng['Delete']?>',
			btnCancelClass: 'btn btn-success',
			btnCancelLabel: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				$.ajax({
					url: "ajax/delete_document.php",
					data:{emp_id: emp_id, doc: $(this).data('id')},
					success: function(result){
						//$('#dump').html(result); return false;
						location.reload();
					}
				});
			}
		});

		$("#emp_id").on('change', function(e){
			$.ajax({
				url: "ajax/check_employee_id.php",
				data: {emp_id: this.value},
				success: function(data){
					if(data == 1){
						$("#emp_id").focus().select();
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['ID exist already']?>',
							duration: 4,
						})
					}
				}
			});
		})
		
		
		var activeTabEmpInfo = localStorage.getItem('activeTabEmpInfo');

		if(activeTabEmpInfo){
			$('.nav-link[href="' + activeTabEmpInfo + '"]').tab('show');

			// check here if tab is work then hide the update button else show the update button for other tabs 

			if(activeTabEmpInfo == '#tab_work')
			{
				$('#submitBtn').css('display','none');
			}
			else
			{
				$('#submitBtn').css('display','');
			}
			
		}else{
			$('.nav-link[href="#tab_work"]').tab('show');
		}
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTabEmpInfo', $(e.target).attr('href'));

			meTable.columns.adjust().draw();
			diTable.columns.adjust().draw();
		});

	})


		function getShiftSchedule()
		{
			var teamVal = $('#empTeam').val();
			var cid= "<?php echo $cid?>";
			var cur_year= "<?php echo $cur_year?>";

			// alert(teamVal);
			// alert(cid);
			// alert(cur_year);


		    $.ajax({
				url: "ajax/get_shuedule_description.php",
				data: {'teamVal': teamVal,'cid':cid,'cur_year':cur_year},
				type: 'POST',
				success: function(response){

					var data = JSON.parse(response);
					$('#shiftplan').val(data.shift_schedule_desc);
					$('#teams').val(data.team_code);
				},
			});
		}

		function getTeamName()
		{
			var teams = $("#empTeam option:selected").text();

			var teamVal = $('#empTeam').val();
			var cid= "<?php echo $cid?>";
			var cur_year= "<?php echo $cur_year?>";

		    $.ajax({
				url: "ajax/getTeamNameVal.php",
				data: {'teamVal': teamVal,'cid':cid,'cur_year':cur_year},
				type: 'POST',
				success: function(response){

					var data = JSON.parse(response);
					var test3434 = $.trim(response);	

					var aade = test3434.replace(/\"/g, "");
					console.log(aade);
					var teamName = $('#team_name').val(aade);
					
				},
			});
			
		}

		

		// GET selected team on load 

		$( document ).ready(function() {

			var teamVal = $('#empTeam').val();
			var cid= "<?php echo $cid?>";
			var cur_year= "<?php echo $cur_year?>";

		    $.ajax({
				url: "ajax/get_shuedule_description.php",
				data: {'teamVal': teamVal,'cid':cid,'cur_year':cur_year},
				type: 'POST',
				success: function(response){

					var data = JSON.parse(response);
					$('#shiftplan').val(data.shift_schedule_desc);
					$('#teams').val(data.team_code);
					$('#team_name').val(data.team_name);
				},
			});
		});


		function changesOtherChkboxP(that){

			if($(that).is(':checked')){

				$('#peComm11').val('1');
				//$('#weComm11').val('0').attr('disabled', true);	

			}else{

				$('#peComm11').val('0');
				//$('#weComm11').val('0').attr('disabled', false);	
			}
		}


		function changesOtherChkboxW(that){

			if($(that).is(':checked')){

				//$('#peComm11').val('0').attr('disabled', true);
				$('#weComm11').val('1');
						
			}else{

				//$('#peComm11').val('0').attr('disabled', false);
				$('#weComm11').val('0');	
			}
		}
		
	</script>


	<script type="text/javascript">

		// CODE TO DISABLE DROPDOWN DROP MENU 
		$('.disabledropdown').on('mousedown', function(e) {
		   e.preventDefault();
		   this.blur();
		   window.focus();
		});


		function closeEmailModal()
		{
			// empty the select field for email type 
			$('#chooseEmailSelect').empty();
		}
		function pingEmployeeLocation(that)
		{
			// get employee email 

			// show popup to select work email or other email 

			// send generate location link in email


			// var employeeEmail = $('#').val();
			// run ajax and get employee all emails 

			var regoID = $('#emp_id').val(); // never empty 

			$.ajax({
					url: "ajax/get_employee_email.php",
					data: {regoID: regoID},
					success: function(result){
						if(result)
						{
							var data = JSON.parse(result);
							$.each(data, function(key, value) {   

								if(key == 'personal_email') {
									var selectField = 'Personal Email';
								}else if(key == 'work_email'){
									var selectField = 'Work Email';
								}

							     $('#chooseEmailSelect').append($("<option></option>").attr("value", value).text(selectField));
								 $('#chooseEmail').modal('show');

							});
										
						}
					}
			})






		}

		function pingEmployeeAjax()
		{
			// get email 
			// check email if empty 
			// send to ajax 

			var selectedEmail  =  $('#chooseEmailSelect').val();
			var employee_id = $('#emp_id').val();

			if(selectedEmail == ''){
				// give error 
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i> Please select a valid email',
					duration: 2,
				})

			}
			else{
				// run ajax


				$.ajax({
						url: "ajax/send_location_employee_email.php",
						data: {selectedEmail: selectedEmail,employee_id:employee_id},
						success: function(result){
							if($.trim(result) == 'success')
							{
								$("body").overhang({
									type: "success",
									message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Email sent successfully']?>',
									duration: 2,
								})

								$("#submitBtn").removeClass('flash');
								$('#sAlert').fadeOut();
								closeEmailModal();	
								$('#chooseEmail').modal('hide');
							}
						}
				})

			}
		}



	$(document).ready(function() {
		
		var update = <?=json_encode($update)?>;
		var emp_id = <?=json_encode($_SESSION['rego']['empID'])?>;
		var fix_allow = <?=json_encode($fix_allow)?>;
		var incdedFix = <?=json_encode($fixalldedarr)?>;
		var ecdata = <?=json_encode($ecdata)?>;

		var dateParmeter;
		if(ecdata.length == 0){
			dateParmeter = '';
		}else{
			dateParmeter = 'new Date()';
		}

		$(document).on("click", "#openResponsibilitiesPopup", function(e){
			//alert(dateParmeter);
			$(".sdatepick1").datepicker("destroy");
			$('#modalOpenResponsibilities input#sdates').removeClass('sdatepick1').addClass('startPicker');
			$('#modalOpenResponsibilities input[name="end_date_new"]').attr('readonly',true).removeClass('sdatepick1');

			$('.startPicker').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				inline: false,
				language: lang,
				todayHighlight: true,
				startDate: dateParmeter,
				orientation: "bottom left",
				
			}).on('changeDate', function(e){

				var dval = $('#modalOpenResponsibilities input[name="start_date_new"]').val();
				$.ajax({
					url: "ajax/career_exist.php",
					type: 'POST',
					data: {dval:dval},
					success: function(result){

						if(result == 1){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
								duration: 2,
							})

							$('#modalOpenResponsibilities input[name="start_date_new"]').val('');

						}else{
							
							var changeFormat = e.format();
							var datearray = changeFormat.split("-");
							var newdatemdy = datearray[1] + '-' + datearray[0] + '-' + datearray[2];

							var days = 1;
							var newdate1 = new Date(newdatemdy);
							var deductDate = newdate1.setDate(newdate1.getDate() - days);
							var dd = new Date(deductDate);
							//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
							var end_date = ('0' + dd.getDate()).slice(-2) + '-' + ('0' + (dd.getMonth()+1)).slice(-2) + '-' + dd.getFullYear();

							var start_date_curr = $('#modalOpenResponsibilities input[name="start_date_curr"]').val();
							if(start_date_curr != ''){
								$('#modalOpenResponsibilities input[name="end_date_curr"]').val(end_date);
							}

						}
					}
				})
			})


			$('#modalOpenResponsibilities').modal('toggle');
		})		

		$(document).on("click", "#openEmployementDataPopup", function(e){
			//alert(dateParmeter);
			$(".sdatepick1").datepicker("destroy");
			$('#openEmployementDataPopup input#sdates').removeClass('sdatepick1').addClass('startPicker');
			$('#openEmployementDataPopup input[name="end_date_new"]').attr('readonly',true).removeClass('sdatepick1');

			// check date here if the joining date is already in payroll database then show a warning message  

			var joiningDateValue = $('#joining_date_2').val();
			var emp_idValue = $('#emp_id').val();

			$.ajax({
				url: "ajax/joining_date_exist.php",
				type: 'POST',
				data: {joiningDateValue:joiningDateValue,emp_idValue:emp_idValue},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp; This employee has already payroll calculations with this joining date – changes will be registered as an new start – you will need to update Benefits and responsibilities newly for this employee.',
							duration: 10,
						})
					}
				}
			})

			$('#modalOpenEmploymentData').modal('toggle');
		})


		$('.startPicker').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalOpenResponsibilities input[name="start_date_new"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalOpenResponsibilities input[name="start_date_new"]').val('');

					}else{
						
						var changeFormat = e.format();
						var datearray = changeFormat.split("-");
						var newdatemdy = datearray[1] + '-' + datearray[0] + '-' + datearray[2];

						var days = 1;
						var newdate1 = new Date(newdatemdy);
						var deductDate = newdate1.setDate(newdate1.getDate() - days);
						var dd = new Date(deductDate);
						//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
						var end_date = ('0' + dd.getDate()).slice(-2) + '-' + ('0' + (dd.getMonth()+1)).slice(-2) + '-' + dd.getFullYear();

						var start_date_curr = $('#modalOpenResponsibilities input[name="start_date_curr"]').val();
						if(start_date_curr != ''){
							$('#modalOpenResponsibilities input[name="end_date_curr"]').val(end_date);
						}

					}
				}
			})
		})

		$('.datepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		})


		if($('input[name="day_rate"]').val() == 0){
			$(".calcRate").trigger('change');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		}
	

		
		
		
		
		
		$('input, textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})
		$('input, select').on('change', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})


		$('.sdatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalOpenResponsibilities input[name="start_date"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalOpenResponsibilities input[name="start_date"]').val('');
					}
				}
			})
		})

		$('.edatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		})


		$(document).on('change', "#careerForm .attachBtn", function(e){
			readFileURL(this, '#attachCareer');
			$("#caBtn").addClass('flash');
			$('#sAlert').fadeIn(200);
		})
		$(document).on("click", "#careerForm .delAttach", function(e){
			var key = $(this).data('key')
			var app = $(this);
			$.ajax({
				url: "ajax/delete_benefit_attach.php",
				data: {id: $("#caID").val(), key: key, field: 'career'},
				success: function(result){
					//$('#dump').html(result);
					app.parent().remove();
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?>&nbsp;&nbsp;<b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});
		$('#careerForm input, #careerForm textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		})
		$('#careerForm .datepick').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: lang,//lang+'-th',
			todayHighlight: true,
		}).on('changeDate', function(ev){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		});	



	})


	var currentTab = 0;
	showTab(currentTab);

	function showTab(n) {
	  var x = document.getElementsByClassName("tab"); 

	  console.log(x);
	  x[n].style.display = "block";
	
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	  }
	  if (n == (x.length - 1)) {
	    document.getElementById("nextBtn").innerHTML = "Submit";
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Next";
	  }
	}

	function nextPrev(n) {
	  var x = document.getElementsByClassName("tab");
	  x[currentTab].style.display = "none";
	  currentTab = currentTab + n;
	  if (currentTab >= x.length) {
	    SaveNewUsersssForm();
	    return false;
	  }
	 showTab(currentTab);
	}


	var currentTab2 = 0;
	showTab2(currentTab2);

	function showTab2(n) {

	  console.log(n);

	  var x = document.getElementsByClassName("tab2"); 

	  if(n == 4 && $('#endOfEmployment').is(':checked') )
	  {
	  	x[4].style.display = "none";
	  }

	  else if(n == 3 && $('#endOfEmployment').is(':not(:checked)') )
	  {
	  	x[4].style.display = "none";
	  	x[3].style.display = "block";
	  	$('#emp_status3val').css('display','block');

	  } 
	  else if(n == 2 &&  $('#endOfEmployment').is(':not(:checked)') )
	  {
	  	x[4].style.display = "none";
	  	x[3].style.display = "none";
	  	x[2].style.display = "block";
	  }
	  else if(n == 1 &&  $('#endOfEmployment').is(':not(:checked)') )
	  {
	  	x[4].style.display = "none";
	  	x[3].style.display = "none";
	  	x[2].style.display = "none";
	  	x[1].style.display = "block";
	  }	  
	  else if(n == 0 &&  $('#endOfEmployment').is(':not(:checked)') )
	  {
	  	x[4].style.display = "none";
	  	x[3].style.display = "none";
	  	x[2].style.display = "none";
	  	x[1].style.display = "none";
	  	x[0].style.display = "block";
	  }
	  else
	  {
	  	x[n].style.display = "block";
	  }


	  // check here if the checkbox is checked and show submit according to it 

	  if( $('#endOfEmployment').is(':not(:checked)'))
		{
			var submitShowValue = 1;
		}
		else
		{
			var submitShowValue = 2;
		}

	
	  if (n == 0) {
	    document.getElementById("prevBtn2").style.display = "none";
	  } else {
	    document.getElementById("prevBtn2").style.display = "inline";
	  }
	  if (n == (x.length - submitShowValue)) {
	    document.getElementById("nextBtn2").innerHTML = "Submit";
	  } else {
	    document.getElementById("nextBtn2").innerHTML = "Next";
	  }
	}

	function nextPrev2(n) {


	  var x = document.getElementsByClassName("tab2");
	  x[currentTab2].style.display = "none";
	  currentTab2 = currentTab2 + n;


	  console.log(currentTab2 +'-'+ x.length);


		if($('#endOfEmployment').is(':checked'))
		{
			if(currentTab2 == 4)
			{
				SaveEmployementDataForm();
	    		return false;
			}
		}
		else
		{
			if(currentTab2 == 5)
			{
				SaveEmployementDataForm();
	    		return false;
			}
		}


	  // if (currentTab2 >= x.length) {
	  //   SaveEmployementDataForm();
	  //   return false;
	  // }


	  if( $('#endOfEmployment').is(':not(:checked)'))
		{
			if(currentTab2 == 2)
			{
				currentTab2 = currentTab2 +1 ;
			}
			else if(currentTab2 == 3)
			{
				currentTab2 = 3 -2 ;
			}
			else 
			{
				currentTab2 =currentTab2;
			}

			$('#emp_status3val').css('display','block');
			$('#emp_status2val').css('display','none');


			$('.noticeDateDiv').css('display','block');

		}



		if($('#endOfEmployment').is(':checked'))
		{


			$('#emp_status3val').css('display','none');
			$('#emp_status2val').css('display','block');

			var resign_date2Variable = $('#resign_date2').val();

			if(currentTab2 == 2 && resign_date2Variable == '')
			{
				// disable the next 
				$("#nextBtn2").prop('disabled', true);
			}
			else
			{
				$("#nextBtn2").prop('disabled', false);
			}

			$('.noticeDateDiv').css('display','none');


		}

		console.log(currentTab2);

			   

	 
	  	showTab2(currentTab2);

	}	

	function backPrev2(n) {


	  var x = document.getElementsByClassName("tab2");
	  x[currentTab2].style.display = "none";
	  currentTab2 = currentTab2 + n;
	  if (currentTab2 >= x.length) {
	    return false;
	  }


	  if( $('#endOfEmployment').is(':not(:checked)'))
		{
			if(currentTab2 == 2)
			{

				console.log('2tab');
				currentTab2 = 2 -1 ;
			}
			else if(currentTab2 == 3)
			{
				console.log('3tab');

				currentTab2 = 3 ;

			}		
			else if(currentTab2 == 4)
			{
				console.log('4tab');

				currentTab2 = 4 -1 ;
			}
			else 
			{
				console.log('elsetab');

				currentTab2 =currentTab2;
			}
			$('#emp_status3val').css('display','none');
			$('.noticeDateDiv').css('display','block');

		}	 

		if($('#endOfEmployment').is(':checked'))
		{

			$('#emp_status3val').css('display','block');
			$('#emp_status2val').css('display','none');

		
			$('.noticeDateDiv').css('display','none');
			

			

		}


		var resign_date2Variable = $('#resign_date2').val();

		if(currentTab2 == 2 && resign_date2Variable == '')
		{
			// disable the next 
			$("#nextBtn2").prop('disabled', true);
		}
		else
		{
			$("#nextBtn2").prop('disabled', false);
		}

		console.log(currentTab2);

	  	showTab2(currentTab2);

	}


	function SaveNewUsersssForm(){

		var formData = new FormData($('#modalOpenResponsibilities #careerForm')[0]);

		$.ajax({
			url: "ajax/update_career_responsibilities.php",
			type: "POST", 
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				//$("#dump").html(data); return false;
				if(data.result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(v){
							window.location.reload();
						}
					})
					
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
						duration: 2,
						callback: function(v){
							// window.location.reload();
						}
					})
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
					callback: function(v){
						// window.location.reload();
					}
				})
			}
		});

	}


	//=================================== SCRIPT TO CHECK ACTIVE TAB IN WORK INFO SECTION TO HIDE THE UPDATE BUTTON===================//
		$(document).on("click", ".checkWorkTabForUpdateButton", function(e){

			var getActiveTab = $(this).attr('href');
			if(getActiveTab == '#tab_work')
			{
				// hide the update button 
				$('#submitBtn').css('display','none');
			}
			else
			{
				// show button 	
				$('#submitBtn').css('display','');
			}
		});

	//=================================== SCRIPT TO CHECK ACTIVE TAB IN WORK INFO SECTION TO HIDE THE UPDATE BUTTON===================//



	// =========================== IF END DATE IS FILLED IN SHOW STATUS ACCORDING TO THAT =============================//



		$(document).on("change", "#resign_date2", function(e){

			var resign_date2ValueVar = $('#resign_date2').val();

			if(resign_date2ValueVar == '')
			{
				$("#nextBtn2").prop('disabled', true);
			}
			else
			{
				$("#nextBtn2").prop('disabled', false);
			}

		});		



	// =========================== IF END DATE IS FILLED IN SHOW STATUS ACCORDING TO THAT =============================//



	function SaveEmployementDataForm(){

		var formData = new FormData($('#modalOpenEmploymentData #employementDataForm')[0]);

		$.ajax({
			url: "ajax/update_employment_data.php",
			type: "POST", 
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
					if(data.result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
							callback: function(v){
								window.location.reload();
							}
						})
						
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
							duration: 2,
							callback: function(v){
							}
						})
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
						callback: function(v){
							// window.location.reload();
						}
					})
				}
		});

	}



	// ======================HIDE THE DATA IS UPDATED MESSAGE ON POPUP CLOSE ===============//



		$(document).on("click", ".closeEditEmploymentDataPopup", function(e){

			$('#sAlert').css('display','none');
		});		



	// ======================HIDE THE DATA IS UPDATED MESSAGE ON POPUP CLOSE ===============//
	</script>