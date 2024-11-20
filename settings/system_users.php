<?
	$employees = getJsonUserEmployees($cid, $lang);
	$compusers = getJsonComusersss($cid,'sys');
	$emps = getEmployees($cid, 0);
	$compEmail = checkCompanySUbEmail($cid);
	$password = generateStrongPassword(8, false);//randomPassword();

	if(isset($_GET['userid'])){
		$condition1 = "AND id = '".$_GET['userid']."'";
	}else{
		$condition1 = "";
	}


	$users = array();
	$sql = "SELECT * FROM ".$cid."_users WHERE type NOT IN('emp','comp') ".$condition1." ";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){ 
			$users[] = $row;
			$users11[$row['id']] = $row['username'];
			$copy_from[] = array('data'=>$row['id'], 'value'=>$row['name']);
		}
	}else{
		echo mysqli_error($dbc);
	}
	if(!$users){$users = array();}
	if(!$copy_from){$copy_from = array();}
	//var_dump($users); exit;

	if(isset($_GET['userid'])){
		$userFiltval = $users11[$_GET['userid']];
	}else{ $userFiltval = '';}
	
?>

<style>
	.disabled {
		cursor:not-allowed;
	}
	.disabled i {
		color:#bbb;
	}
	table.basicTable.tac th {
		text-align:center;
		min-width:75px;
	}
	table.basicTable.tac td {
		text-align:center;
	}
	.SumoSelect{
		width: 99% !important;
		/*min-width: 200px !important;*/
		padding: 4px 0 0 10px !important;
		border:0 !important;
	}
	.SumoSelect > .CaptionCont {
		background:transparent !important;
		font-weight:600;
	}

	#AccessRightsForm .optWrapper.okCancelInMulti.selall.multiple {
	    min-width: 150px;
	}

	.SumoSelect p.btnOk, p.btnOk:hover {
	    background: green;
	    color: #fff;
	    border: 1px solid green;
	}

	.SumoSelect > .optWrapper.multiple > .MultiControls > p.btnOk:hover {
	    background: green !important;
	    color: #fff !important;
	    border: 1px solid green !important;
	}

	.SumoSelect p.btnCancel, p.btnCancel:hover {
	    background: #d32c2c;
	    color: #fff;
	    border: 1px solid #d32c2c;
	}

	.SumoSelect > .optWrapper.multiple > .MultiControls > p.btnCancel:hover {
	    background: #d32c2c !important;
	    color: #fff !important;
	    border: 1px solid #d32c2c !important;
	}


	/* pre-next css*/

	input {
	  padding: 10px;
	  width: 100%;
	  border: 1px solid #aaaaaa;
	}

	/* Hide all steps by default: */
	.tab {
	  display: none;
	}

	/* pre-next css*/

	
</style>

	<link rel="stylesheet" href="../assets/css/croppie_users.css?<?=time()?>" />

	<h2><i class="fa fa-user"></i>&nbsp; <?=$lng['System users']?></h2>
	
	<div class="main" style="display:none">
		<div style="padding:0 0 0 20px" id="dump"></div>

		<div class="row mb-2">
			<div class="col-md-2">
				<label style="font-weight: 600;">Search Users:</label>
				<input type="text" name="nameFilter" value="<?=$userFiltval?>" id="UserNameFilter" placeholder="Enter username here...">

			</div>
			
			<div class="col-md-8" style="visibility: hidden;"></div>
			<div class="col-md-2">
				<button type="button" class="btn btn-primary btn-fr mt-2" id="add_Newuser"><i class="fa fa-plus"></i>&nbsp; <?=$lng['Add new user']?></button>
			</div>
			
		</div>
			 
		<table border="0" class="basicTable pad010">
			<thead>
				<tr>
					<th class="tac" style="width:1px; padding:0 5px"><i class="fa fa-image fa-lg"></i></th>
					<th><?=$lng['Type']?></th> 
					<th><?=$lng['Name']?></th> 
					<th><?=$lng['Username']?></th> 
					<th><?=$lng['Phone']?></th> 
					<th><?=$lng['System users']?></th>
					<th><?=$lng['Company users']?></th>
					<th><?=$lng['Access Rights']?></th>
					<th><?=$lng['Access start']?></th>
					<th><?=$lng['Access end']?></th>
					<th><?=$lng['Status']?></th>
					<th><i class="fa fa-trash fa-lg"></i></th>
				</tr>
			</thead>
			<tbody>
			<? if($users){ 
				foreach($users as $k=>$v){ $pid = $cid.'_'.$v['username'];?>
				<tr>
					<td class="tac" style="padding:0 !important;">
						<center><img style="height:28px; width:28px; margin:2px; cursor:default" class="img-tooltip" data-id="<?=$v['id']?>" title="<img src=../<?=$v['img'].'?'.time()?> />" data-toggle="tooltip" data-placement="right" src="../<?=$v['img'].'?'.time()?>" /></center>
					</td>
					
					<td><?=$v['type']?></td>
					<td><?=$v['name']?></td>
					<td><?=$v['username']?></td>
					<td><?=$v['phone']?></td>
					
					<? if($_SESSION['rego']['standard'][$standard]['set_permissions']){ ?>
						<td class="tac"><a title="<?=$lng['Set permissions']?>" class="permissions" data-id="<?=$v['id']?>"><i class="fa fa-cog fa-lg"></i></a></td>

						<?if(strpos($AllUsers[$v['username']][0]->com_access, $cid) !== false && $AllUsers[$v['username']][0]->com_status == 1){ ?>
							<td class="tac"><a title="<?=$lng['Company users']?>" class="" data-id="<?=$v['id']?>"><i class="fa fa-check fa-lg"></i></a></td>
						<?}else{ ?>
							<td class="tac"></td>
						<?}?>
					
						<td class="tac"><a title="<?=$lng['Access Rights']?>" class="AccessRights" data-id="<?=$v['id']?>"><i class="fa fa-cog fa-lg"></i></a></td>
					<? } ?>
					
					<td><?=$v['access_start']?></td>
					<td><?=$v['access_end']?></td>
					<td><?=$def_status[$v['status']]?></td>
					
					<td>
						<? if($compEmail[$v['username']] == $v['username']){ }else{ ?>
							<a class="delUser" data-emp="<?=$v['emp_id']?>" data-id="<?=$v['id']?>" data-type="<?=$v['type']?>" data-ref="<?=$v['ref']?>"><i class="fa fa-trash fa-lg"></i></a>
						<? } ?>
					</td>
					
				</tr>
			<? } }else{ ?>
				<tr>
					<td colspan="13" style="font-size:14px;color:#000;text-align:center;padding:6px 10px !important; background:#ff6; font-weight:600">
						<?=$lng['No data available in Database']?>
					</td>
				</tr>
			<? } ?>  
			</tbody>
		</table>
    
    	<div style="height:50px"></div> 

	</div>
	
	<!------ Permission Modal  -------->
	<div class="modal fade" id="modalSetPermissions" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="min-width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Set permissions']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form id="permissionForm" style="position:relative; <? if(!$_SESSION['rego']['standard'][$standard]['set_permissions']){echo 'display:none';}?>">
				    	<fieldset disabled>
							<input id="user_id" name="id" type="hidden" value=""  />
							<table class="basicTable" style="margin-top:0px; width:100%; table-layout:auto">
								<thead>
									<tr>
										<th class="tal" colspan="11" style="padding:4px; vertical-align: bottom !important; font-size:18px">
											<table border="0" style="width:100%;">
												<tr>
													<td style="padding:1px 0 0 1px">
														<img id="permImg" style="height:60px; display:block;" src="../images/profile_image.jpg" />
													</td>
													<td style="vertical-align:bottom; padding-bottom:5px;">
														<span style="color:#a00" id="sysUser"></span>
													</td>
													<td style="vertical-align:bottom">
														<?=$lng['Copy permissions from']?> : <input style="background:transparent; width:250px; border-bottom:1px solid #ccc; font-size:16px; padding:0; margin-left:5px" placeholder="<?=$lng['Type for hints']?> ..." id="copy_from" type="text" />
													</td>
													<td style="width:90%; padding:0 5px 7px 20px; vertical-align:bottom;">
														<span id="accessMsg"></span>
													</td>
													<td style="padding-bottom:8px; vertical-align:bottom">
														<button type="submit" class="btn btn-primary" id="save_settings"><i class="fa fa-save"></i>&nbsp; <?=$lng['Update permissions']?></button>
													</td>
												</tr>
											</table>
										</th> 
									</tr>
								</thead>
							</table>
						
					
							<table class="basicTable table-responsive" style="margin-top:10px; width:100%; table-layout:auto">
								<thead>
									<tr style="line-height:100%; background:#393; border-bottom:1px solid #030">
										<th style="color:#fff" class="tal"><?=$lng['Module']?></th>
										<th style="color:#fff" class="tal"><?=$lng['Section']?></th>
										<th style="color:#fff; width:90%" colspan="20"><?=$lng['Permissions']?></th>
									</tr>
								</thead>
								<tbody>
								
								<!--EMPLOYEE REGISTER //////////////////////////////////////////////////////////////////// --> 
									<tr>
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="6">
											<input name="employee[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[access]" value="1" class="cMod aEmp checkbox"><span> <?=$lng['Employee register']?></span></label><br>
											<label><input disabled type="checkbox" class="allEmp cBox checkbox"><span> <?=$lng['Select all']?></span></label>
										</th>
										<th class="tal"><?=$lng['Employee list']?></th>
										<td class="tal">
											<input name="employee[add]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add new']?></span></label>
										</td>
										<td>
											<input name="employee[import]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[import]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Import']?></span></label>
										</td>
										<td>
											<input name="employee[export]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[export]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Export']?></span></label>
										</td>
										<td>
											<input name="employee[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[del]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td style="width:80%"></td>
										<td>
											<input name="employee[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[report]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Report']?></span></label>
										</td>
										<td>
											<input name="employee[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[archive]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Archive']?></span></label>
										</td>
										<td>
											<input name="employee[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee[settings]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Settings']?></span></label>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Employee info']?></th>
										<td>
											<input name="employee_info[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_info[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="employee_info[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_info[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="employee_info[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_info[del]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Financial info']?></th>
										<td>
											<input name="employee_finance[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_finance[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="employee_finance[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_finance[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="employee_finance[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_finance[del]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Other benefits']?></th>
										<td>
											<input name="employee_benefit[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_benefit[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="employee_benefit[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_benefit[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="employee_benefit[add]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_benefit[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Historical records']?></th>
										<td>
											<input name="employee_history[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_history[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="employee_history[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_history[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="employee_history[add]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_history[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Workpermit']?></th>
										<td>
											<input name="employee_permit[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_permit[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="employee_permit[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_permit[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="employee_permit[add]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="employee_permit[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>

								<!--LEAVE MODULE //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="3">
											<input name="leave[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave[access]" value="1" class="cMod aLea checkbox"><span> <?=$lng['Leave module']?></span></label><br>
											<label><input disabled type="checkbox" class="allLea cBox checkbox"><span> <?=$lng['Select all']?></span></label>
										</th>
										<th class="tal"><?=$lng['Leave application']?></th>
										<td>
											<input name="leave_application[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_application[view]" value="1" class="cLea cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="leave_application[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_application[edit]" value="1" class="cLea cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="leave_application[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_application[del]" value="1" class="cLea cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td>
											<input name="leave_application[request]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_application[request]" value="1" class="cLea cBox checkbox"><span><?=$lng['Request']?></span></label>
										</td>
										<td>
											<!-- <input name="leave_application[review]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_application[review]" value="1" class="cLea cBox checkbox"><span><?=$lng['Review']?></span></label> -->
											<input name="leave_application[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_application[approve]" value="1" class="cLea cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td>
											
										</td>
										<td></td><td></td><td style="width:80%"></td>
										<td>
											<input name="leave[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave[report]" value="1" class="cLea cBox checkbox"><span><?=$lng['Report']?></span></label>
										</td>
										<td>
											<input name="leave[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave[archive]" value="1" class="cLea cBox checkbox"><span><?=$lng['Archive']?></span></label>
										</td>
										<td>
											<input name="leave[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave[settings]" value="1" class="cLea cBox checkbox"><span><?=$lng['Settings']?></span></label>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Leave calendar']?></th>
										<td>
											<input name="leave_calendar[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_calendar[view]" value="1" class="cLea cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="leave_calendar[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_calendar[edit]" value="1" class="cLea cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Approve for payroll']?></th>
										<td>
											<input name="leave_approve[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[view]" value="1" class="cLea cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="leave_approve[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[edit]" value="1" class="cLea cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="leave_approve[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[del]" value="1" class="cLea cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td>
											<input name="leave_approve[request]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[request]" value="1" class="cLea cBox checkbox"><span><?=$lng['Request']?></span></label>
										</td>
										<td>
											<input name="leave_approve[review]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[review]" value="1" class="cLea cBox checkbox"><span><?=$lng['Review']?></span></label>
										</td>
										<td>
											<input name="leave_approve[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[approve]" value="1" class="cLea cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td>
											<input name="leave_approve[lock]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="leave_approve[lock]" value="1" class="cLea cBox checkbox"><span><?=$lng['Lock']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td>
									</tr>

								<!--TIME MODULE //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="5">
											<input name="time[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time[access]" value="1" class="cMod aTim checkbox"><span> <?=$lng['Time module']?></span></label><br>
											<label><input disabled type="checkbox" class="allTim cBox checkbox"><span> <?=$lng['Select all']?></span></label>
										</th>
										<th class="tal"><?=$lng['Import timesheet']?></th>
										<td>
											<input name="time_import[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_import[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="time_import[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_import[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="time_import[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_import[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td>
											<input name="time_import[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_import[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td style="width:80%"></td>
										<td>
											<input name="time[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time[report]" value="1" class="cTim cBox checkbox"><span><?=$lng['Report']?></span></label>
										</td>
										<td>
											<input name="time[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time[archive]" value="1" class="cTim cBox checkbox"><span><?=$lng['Archive']?></span></label>
										</td>
										<td>
											<input name="time[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time[settings]" value="1" class="cTim cBox checkbox"><span><?=$lng['Settings']?></span></label>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Time attendance']?></th>
										<td>
											<input name="time_attendance[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_attendance[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="time_attendance[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_attendance[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="time_attendance[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_attendance[del]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td>
											<input name="time_attendance[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_attendance[approve]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Monthly attendance']?></th>
										<td>
											<input name="time_monthly[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_monthly[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="time_monthly[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_monthly[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="time_monthly[review]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_monthly[review]" value="1" class="cTim cBox checkbox"><span><?=$lng['Review']?></span></label>
										</td>
										<td>
											<input name="time_monthly[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_monthly[approve]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td>
											<input name="time_monthly[lock]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_monthly[lock]" value="1" class="cTim cBox checkbox"><span><?=$lng['Lock']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Monthly planning']?></th>
										<td>
											<input name="time_planning[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_planning[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="time_planning[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_planning[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="time_planning[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_planning[del]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Shift requests']?></th>
										<td>
											<input name="time_shift[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_shift[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="time_shift[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_shift[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="time_shift[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_shift[del]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td>
											<input name="time_shift[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="time_shift[approve]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
								
								<!--PAYROLL MODULE //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="7">
											<input name="payroll[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll[access]" value="1" class="cMod aPay checkbox"><span> <?=$lng['Payroll module']?></span></label><br>
											<label><input disabled type="checkbox" class="allPay cBox checkbox"><span> <?=$lng['Select all']?></span></label>
										</th>
										<th class="tal"><?=$lng['Monthly attendance']?></th>
										<td>
											<input name="payroll_attendance[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_attendance[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_attendance[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_attendance[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td style="width:80%"></td>
										<td>
											<input name="payroll[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll[report]" value="1" class="cPay cBox checkbox"><span><?=$lng['Report']?></span></label>
										</td>
										<td>
											<input name="payroll[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll[archive]" value="1" class="cPay cBox checkbox"><span><?=$lng['Archive']?></span></label>
										</td>
										<td>
											<input name="payroll[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll[settings]" value="1" class="cPay cBox checkbox"><span><?=$lng['Settings']?></span></label>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Payroll results']?></th>
										<td>
											<input name="payroll_result[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_result[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_result[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_result[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="payroll_result[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_result[approve]" value="1" class="cPay cBox checkbox"><span><?=$lng['Approve']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Government forms']?></th>
										<td>
											<input name="payroll_forms[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_forms[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_forms[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_forms[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Export center']?></th>
										<td>
											<input name="payroll_export[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_export[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_export[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_export[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Variable benefits']?></th>
										<td>
											<input name="payroll_benefits[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_benefits[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_benefits[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_benefits[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Calculations']?></th>
										<td>
											<input name="payroll_calculations[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_calculations[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_calculations[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_calculations[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Historical data']?></th>
										<td>
											<input name="payroll_historical[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_historical[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="payroll_historical[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="payroll_historical[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>

								<!--COMMUNICATION CENTER ////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
											<input name="comm_center[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[access]" value="1" class="cMod accBen checkbox"><span> <?=$lng['Communication center']?></span></label>
										</th>
										<th class="tal">
										</th>
										<td>
											<input name="comm_center[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[view]" value="1" class="ccBen cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="comm_center[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[edit]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
											<input name="comm_center[del]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[del]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Delete']?></span></label>
										</td>
										<td>
											<input name="comm_center[need_approver]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[need_approver]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Need approver']?></span></label>
										</td>
										<td>
											<input name="comm_center[approve]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[approve]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Can be approver']?></span></label>
										</td>
										<td>
											<input name="comm_center[private_msg]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="comm_center[private_msg]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Can see Private Messages']?></span></label>
										</td>
										<td></td><td></td><td style="width:80%"></td>
										<td>
											<!-- <input name="expences[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[report]" value="1" class="cBen cBox checkbox"><span><?=$lng['Report']?></span></label> -->
										</td>
										<td>
											<!-- <input name="expences[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[archive]" value="1" class="cBen cBox checkbox"><span><?=$lng['Archive']?></span></label> -->
										</td>
										<td>
											<!-- <input name="expences[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[settings]" value="1" class="cBen cBox checkbox"><span><?=$lng['Settings']?></span></label> -->
										</td>
									</tr>
								<!--COMMUNICATION CENTER ////////////////////////////////////////////////////////////// --> 


								<!--BENEFITS & EXPENCES //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
											<input name="expences[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[access]" value="1" class="cMod aBen checkbox"><span> <?=$lng['Benefits & Expences']?></span></label>
										</th>
										<th class="tal">
										</th>
										<td>
											<input name="expences[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[view]" value="1" class="cBen cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="expences[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[edit]" value="1" class="cBen cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td style="width:80%"></td>
										<td>
											<input name="expences[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[report]" value="1" class="cBen cBox checkbox"><span><?=$lng['Report']?></span></label>
										</td>
										<td>
											<input name="expences[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[archive]" value="1" class="cBen cBox checkbox"><span><?=$lng['Archive']?></span></label>
										</td>
										<td>
											<input name="expences[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="expences[settings]" value="1" class="cBen cBox checkbox"><span><?=$lng['Settings']?></span></label>
										</td>
									</tr>

								<!--PROJECTS //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
											<input name="project[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="project[access]" value="1" class="cMod aPro checkbox"><span> <?=$lng['Projects']?></span></label>
										</th>
										<th class="tal">
										</th>
										<td>
											<input name="project[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="project[view]" value="1" class="cPro cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="project[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="project[edit]" value="1" class="cPro cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td style="width:80%"></td>
										<td>
											<input name="project[report]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="project[report]" value="1" class="cPro cBox checkbox"><span><?=$lng['Report']?></span></label>
										</td>
										<td>
											<input name="project[archive]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="project[archive]" value="1" class="cPro cBox checkbox"><span><?=$lng['Archive']?></span></label>
										</td>
										<td>
											<input name="project[settings]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="project[settings]" value="1" class="cPro cBox checkbox"><span><?=$lng['Settings']?></span></label>
										</td>
									</tr>

								<!--SETTINGS //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
											<input name="settings[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="settings[access]" value="1" class="cMod aSet checkbox"><span> <?=$lng['Settings']?></span></label>
										</th>
										<th class="tal">
										</th>
										<td>
											<input name="settings[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="settings[view]" value="1" class="cSet cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="settings[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="settings[edit]" value="1" class="cSet cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>

								<!--SUPPORT DESK //////////////////////////////////////////////////////////////////// --> 
									<tr style="border-top:2px solid #ddd">
										<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
											<input name="support[access]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="support[access]" value="1" class="cMod aSup checkbox"><span> <?=$lng['Support desk']?></span></label>
										</th>
										<th class="tal">
										</th>
										<td>
											<input name="support[view]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="support[view]" value="1" class="cSup cBox checkbox"><span><?=$lng['View']?></span></label>
										</td>
										<td>
											<input name="support[edit]" type="hidden" value="0"  />
											<label><input disabled type="checkbox" name="support[edit]" value="1" class="cSup cBox checkbox"><span><?=$lng['Edit']?></span></label>
										</td>
										<td>
										</td>
										<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
									</tr>
									
				        		</tbody>
							</table>	
				      	</fieldset>
					</form>

					<button class="btn btn-primary btn-fr mt-3 mr-3" type="button" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<!------ Permission Modal  -------->


	<!------ Access rights Modal  -------->
	<div class="modal fade" id="modalAccessRights" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="min-width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Access Rights']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form id="AccessRightsForm" style="position:relative; <? if(!$_SESSION['rego']['standard'][$standard]['set_permissions']){echo 'display:none';}?>">
				    	<fieldset disabled>
							<input id="user_id" name="id" type="hidden" value=""  />
							<table class="basicTable" style="margin-top:0px; width:100%; table-layout:auto">
								<thead>
									<tr>
										<th class="tal" colspan="11" style="padding:4px; vertical-align: bottom !important; font-size:18px">
											<table border="0" style="width:100%;">
												<tr>
													<td style="padding:1px 0 0 1px">
														<img id="permImg" style="height:60px; display:block;" src="../images/profile_image.jpg" />
													</td>
													<td style="vertical-align:bottom; padding-bottom:5px;">
														<span style="color:#a00" id="sysUser"></span>
													</td>
													<td style="vertical-align:bottom">
														<?=$lng['Copy access from']?> : <input style="background:transparent; width:250px; border-bottom:1px solid #ccc; font-size:16px; padding:0; margin-left:5px" placeholder="<?=$lng['Type for hints']?> ..." id="copy_from" type="text" />
													</td>
													<td style="width:90%; padding:0 5px 7px 20px; vertical-align:bottom;">
														<span id="accessMsg"></span>
														
													</td>
													<td style="padding-bottom:8px; vertical-align:bottom">
														<button type="submit" class="btn btn-primary" id="save_settingsss"><i class="fa fa-save"></i>&nbsp; <?=$lng['Update Access']?></button>
													</td>
												</tr>
											</table>
										</th> 
									</tr>
								</thead>
							</table>

							
							
							<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto;">
								<thead>
									<tr style="line-height:100%; background:#09c; color:#fff;">
										
										<!-- <th style="color:#fff"><?=$lng['Entities']?></th>
										<th style="color:#fff"><?=$lng['Branches']?></th>
										<th style="color:#fff"><?=$lng['Divisions']?></th>
										<th style="color:#fff"><?=$lng['Departments']?></th>
										<th style="color:#fff"><?=$lng['Teams']?></th> -->
										<?if(count($entities) > 1){ ?>
											<th style="color:#fff"><?=$lng['Company']?></th>
										<? } ?>
										<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
											<th style="color:#fff"><?=$parameters[1][$lang]?></th>
										<? } ?>
										<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
											<th style="color:#fff"><?=$parameters[2][$lang]?></th>
										<? } ?>
										<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
											<th style="color:#fff"><?=$parameters[3][$lang]?></th>
										<? } ?>
										<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
											<th style="color:#fff"><?=$parameters[4][$lang]?></th>
										<? } ?>

									
									</tr>
								</thead>
								<tbody>
									<tr style="background:#f9f9f9">
										<input type="hidden" name="access">	
										<input type="hidden" name="access_selection">
												
										<?if(count($entities) > 1){ ?>
											<td style="padding:0">
												<select name="entities" multiple="multiple" id="userEntities">
												<? foreach($entities as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>
												
											</td>
										<? } ?>
										
										<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
											<td style="padding:0">
												<select name="branches" multiple="multiple" id="userBranches">
												<? unset($branches[1]);
												foreach($branches as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>

										<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
											<td style="padding:0">
												<select name="divisions" multiple="multiple" id="userDivisions">
												<? unset($divisions[1]);
												foreach($divisions as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>

										<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
											<td style="padding:0">
												<select name="departments" multiple="multiple" id="userDepartments">
												<? unset($departments[1]);
												foreach($departments as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>

										<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
											<td style="padding:0">
												<select name="teams" multiple="multiple" id="userTeams">
												<? unset($teams[1]);
												foreach($teams as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v['code'].' - '.$v[$lang]?></option>
												<? } ?>
												</select>		
											</td>
										<? } ?>
									</tr>
								</tbody>
								<tbody id="accessBody">

								</tbody>
							</table>
					
				      	</fieldset>
					</form>

					<div class="clear"></div>
					<button class="btn btn-primary btn-fr mt-3 mr-3" type="button" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<!------ Access rights Modal -------->


	<!------ Prev-Next Modal -------->
	<div class="modal fade" id="modalPrevnext" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document" style="min-width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=$lng['Add new user']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form id="regForm">
					    <!------ 1st tab user info start ---->
					    <div class="tab">  
						  	<input type="hidden" name="name" id="name" />
							<input type="hidden" name="emp_id" id="emp_id" />
							<input type="hidden" name="img" id="img" value="images/profile_image.jpg" />
							<input type="hidden" name="img_data" id="img_data" value="" />
							<table border="0" style="width:100%">
	            				<tr>
	              					<td class="vat" style="padding:0 15px 0 0; border-right:1px #eee solid; width:80%">
										<table class="basicTable inputs" border="0">
											<tbody>
											<tr>
												<th><i class="man"></i><?=$lng['Name']?></th>
												<td><input placeholder="<?=$lng['Type for hints']?> ..." id="system_user_name" type="text" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['email']?></th>
												<!-- <td><input onKeyUp="$('#username').val(this.value);" onChange="$('#username').val(this.value);" id="email" type="text" value="" /></td> -->
												<td><input onKeyUp="$('#username').val(this.value);" onChange="checkEmail(this.value);" id="email" type="text" value="" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Username']?></th>
												<td><input readonly class="nofocus" name="username" id="username" type="text" value="" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Password']?></th>
												<td><input autocomplete="off" name="password" id="password" type="text" value="<?=$password?>" />
													<input type="hidden" id="hiddpassword" value="">
												</td>
											</tr>
											<tr>
												<th><?=$lng['Phone']?></th>
												<td><input name="personal_phone" type="text" value="" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Type']?></th>
												<td>
													<select name="type" id="type" style="width:100%">
														<option value="sys"><?=$user_type['sys']?></option>
														<option value="app"><?=$user_type['app']?></option>
													</select>
												</td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Status']?></th>
												<td colspan="2">
													<select name="status" id="status" style="width:100%">
														<? foreach($def_status as $k=>$v){ ?>
															<option value="<?=$k?>"><?=$v?></option>
														<? } ?>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
	                				<td class="vat" style="width:1%; padding:5px 0 0 15px;">
										<div id="upload-demo" style="margin:0 0 5px;"></div>
										<input style="height:0; visibility:hidden" id="selectUserImg" type="file" name="user_img" />
										<? //if($admin){ ?>
										<button onclick="$('#selectUserImg').click();" type="button" id="userBut" style="width:100%; margin:0" class="btn btn-primary btn-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$lng['Select picture']?></button>
										<? //} ?>
									</td>
	         					</tr>
							</table>
						</div>
						<!------ 1st tab user info end ---->

						<!------ 2nd tab user permissions start ---->
					  	<div class="tab">
					  		<fieldset>
					  			<h2><i class="fa fa-cog"></i> <?=$lng['Set permissions']?></h2>
					  			<table class="basicTable table-responsive" style="margin-top:10px; width:100%; table-layout:auto">
									<thead>
										<tr style="line-height:100%; background:#393; border-bottom:1px solid #030">
											<th style="color:#fff" class="tal"><?=$lng['Module']?></th>
											<th style="color:#fff" class="tal"><?=$lng['Section']?></th>
											<th style="color:#fff; width:90%" colspan="20"><?=$lng['Permissions']?></th>
										</tr>
									</thead>
									<tbody>
									
									<!--EMPLOYEE REGISTER //////////////////////////////////////////////////////////////////// --> 
										<tr>
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="6">
												<input name="employee[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[access]" value="1" class="cMod aEmp checkbox"><span> <?=$lng['Employee register']?></span></label><br>
												<label><input disabled type="checkbox" class="allEmp cBox checkbox"><span> <?=$lng['Select all']?></span></label>
											</th>
											<th class="tal"><?=$lng['Employee list']?></th>
											<td class="tal">
												<input name="employee[add]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add new']?></span></label>
											</td>
											<td>
												<input name="employee[import]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[import]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Import']?></span></label>
											</td>
											<td>
												<input name="employee[export]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[export]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Export']?></span></label>
											</td>
											<td>
												<input name="employee[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[del]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td style="width:80%"></td>
											<td>
												<input name="employee[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[report]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Report']?></span></label>
											</td>
											<td>
												<input name="employee[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[archive]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Archive']?></span></label>
											</td>
											<td>
												<input name="employee[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee[settings]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Settings']?></span></label>
											</td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Employee info']?></th>
											<td>
												<input name="employee_info[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_info[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="employee_info[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_info[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="employee_info[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_info[del]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Financial info']?></th>
											<td>
												<input name="employee_finance[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_finance[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="employee_finance[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_finance[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="employee_finance[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_finance[del]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Other benefits']?></th>
											<td>
												<input name="employee_benefit[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_benefit[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="employee_benefit[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_benefit[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="employee_benefit[add]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_benefit[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Historical records']?></th>
											<td>
												<input name="employee_history[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_history[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="employee_history[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_history[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="employee_history[add]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_history[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Workpermit']?></th>
											<td>
												<input name="employee_permit[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_permit[view]" value="1" class="cEmp cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="employee_permit[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_permit[edit]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="employee_permit[add]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="employee_permit[add]" value="1" class="cEmp cBox checkbox"><span><?=$lng['Add']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>

									<!--LEAVE MODULE //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="3">
												<input name="leave[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave[access]" value="1" class="cMod aLea checkbox"><span> <?=$lng['Leave module']?></span></label><br>
												<label><input disabled type="checkbox" class="allLea cBox checkbox"><span> <?=$lng['Select all']?></span></label>
											</th>
											<th class="tal"><?=$lng['Leave application']?></th>
											<td>
												<input name="leave_application[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_application[view]" value="1" class="cLea cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="leave_application[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_application[edit]" value="1" class="cLea cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="leave_application[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_application[del]" value="1" class="cLea cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td>
												<input name="leave_application[request]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_application[request]" value="1" class="cLea cBox checkbox"><span><?=$lng['Request']?></span></label>
											</td>
											<td>
												<!-- <input name="leave_application[review]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_application[review]" value="1" class="cLea cBox checkbox"><span><?=$lng['Review']?></span></label> -->
												<input name="leave_application[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_application[approve]" value="1" class="cLea cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td>
												
											</td>
											<td></td><td></td><td style="width:80%"></td>
											<td>
												<input name="leave[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave[report]" value="1" class="cLea cBox checkbox"><span><?=$lng['Report']?></span></label>
											</td>
											<td>
												<input name="leave[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave[archive]" value="1" class="cLea cBox checkbox"><span><?=$lng['Archive']?></span></label>
											</td>
											<td>
												<input name="leave[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave[settings]" value="1" class="cLea cBox checkbox"><span><?=$lng['Settings']?></span></label>
											</td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Leave calendar']?></th>
											<td>
												<input name="leave_calendar[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_calendar[view]" value="1" class="cLea cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="leave_calendar[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_calendar[edit]" value="1" class="cLea cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Approve for payroll']?></th>
											<td>
												<input name="leave_approve[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[view]" value="1" class="cLea cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="leave_approve[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[edit]" value="1" class="cLea cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="leave_approve[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[del]" value="1" class="cLea cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td>
												<input name="leave_approve[request]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[request]" value="1" class="cLea cBox checkbox"><span><?=$lng['Request']?></span></label>
											</td>
											<td>
												<input name="leave_approve[review]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[review]" value="1" class="cLea cBox checkbox"><span><?=$lng['Review']?></span></label>
											</td>
											<td>
												<input name="leave_approve[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[approve]" value="1" class="cLea cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td>
												<input name="leave_approve[lock]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="leave_approve[lock]" value="1" class="cLea cBox checkbox"><span><?=$lng['Lock']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td>
										</tr>

									<!--TIME MODULE //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="5">
												<input name="time[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time[access]" value="1" class="cMod aTim checkbox"><span> <?=$lng['Time module']?></span></label><br>
												<label><input disabled type="checkbox" class="allTim cBox checkbox"><span> <?=$lng['Select all']?></span></label>
											</th>
											<th class="tal"><?=$lng['Import timesheet']?></th>
											<td>
												<input name="time_import[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_import[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="time_import[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_import[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="time_import[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_import[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td>
												<input name="time_import[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_import[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td style="width:80%"></td>
											<td>
												<input name="time[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time[report]" value="1" class="cTim cBox checkbox"><span><?=$lng['Report']?></span></label>
											</td>
											<td>
												<input name="time[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time[archive]" value="1" class="cTim cBox checkbox"><span><?=$lng['Archive']?></span></label>
											</td>
											<td>
												<input name="time[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time[settings]" value="1" class="cTim cBox checkbox"><span><?=$lng['Settings']?></span></label>
											</td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Time attendance']?></th>
											<td>
												<input name="time_attendance[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_attendance[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="time_attendance[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_attendance[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="time_attendance[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_attendance[del]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td>
												<input name="time_attendance[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_attendance[approve]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Monthly attendance']?></th>
											<td>
												<input name="time_monthly[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_monthly[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="time_monthly[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_monthly[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="time_monthly[review]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_monthly[review]" value="1" class="cTim cBox checkbox"><span><?=$lng['Review']?></span></label>
											</td>
											<td>
												<input name="time_monthly[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_monthly[approve]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td>
												<input name="time_monthly[lock]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_monthly[lock]" value="1" class="cTim cBox checkbox"><span><?=$lng['Lock']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Monthly planning']?></th>
											<td>
												<input name="time_planning[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_planning[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="time_planning[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_planning[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="time_planning[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_planning[del]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Shift requests']?></th>
											<td>
												<input name="time_shift[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_shift[view]" value="1" class="cTim cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="time_shift[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_shift[edit]" value="1" class="cTim cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="time_shift[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_shift[del]" value="1" class="cTim cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td>
												<input name="time_shift[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="time_shift[approve]" value="1" class="cTim cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
									
									<!--PAYROLL MODULE //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px" rowspan="7">
												<input name="payroll[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll[access]" value="1" class="cMod aPay checkbox"><span> <?=$lng['Payroll module']?></span></label><br>
												<label><input disabled type="checkbox" class="allPay cBox checkbox"><span> <?=$lng['Select all']?></span></label>
											</th>
											<th class="tal"><?=$lng['Monthly attendance']?></th>
											<td>
												<input name="payroll_attendance[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_attendance[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_attendance[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_attendance[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td style="width:80%"></td>
											<td>
												<input name="payroll[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll[report]" value="1" class="cPay cBox checkbox"><span><?=$lng['Report']?></span></label>
											</td>
											<td>
												<input name="payroll[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll[archive]" value="1" class="cPay cBox checkbox"><span><?=$lng['Archive']?></span></label>
											</td>
											<td>
												<input name="payroll[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll[settings]" value="1" class="cPay cBox checkbox"><span><?=$lng['Settings']?></span></label>
											</td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Payroll results']?></th>
											<td>
												<input name="payroll_result[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_result[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_result[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_result[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="payroll_result[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_result[approve]" value="1" class="cPay cBox checkbox"><span><?=$lng['Approve']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Government forms']?></th>
											<td>
												<input name="payroll_forms[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_forms[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_forms[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_forms[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Export center']?></th>
											<td>
												<input name="payroll_export[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_export[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_export[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_export[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Variable benefits']?></th>
											<td>
												<input name="payroll_benefits[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_benefits[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_benefits[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_benefits[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Calculations']?></th>
											<td>
												<input name="payroll_calculations[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_calculations[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_calculations[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_calculations[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										<tr>
											<th class="tal"><?=$lng['Historical data']?></th>
											<td>
												<input name="payroll_historical[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_historical[view]" value="1" class="cPay cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="payroll_historical[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="payroll_historical[edit]" value="1" class="cPay cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>

										<!--COMMUNICATION CENTER ////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
												<input name="comm_center[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[access]" value="1" class="cMod accBen checkbox"><span> <?=$lng['Communication center']?></span></label>
											</th>
											<th class="tal">
											</th>
											<td>
												<input name="comm_center[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[view]" value="1" class="ccBen cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="comm_center[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[edit]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
												<input name="comm_center[del]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[del]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Delete']?></span></label>
											</td>
											<td>
												<input name="comm_center[need_approver]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[need_approver]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Need approver']?></span></label>
											</td>
											<td>
												<input name="comm_center[approve]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[approve]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Can be approver']?></span></label>
											</td>
											<td>
												<input name="comm_center[private_msg]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="comm_center[private_msg]" value="1" class="ccBen cBox checkbox"><span><?=$lng['Can see Private Messages']?></span></label>
											</td>
											<td></td><td></td><td></td><td style="width:80%"></td>
											<td>
												<!-- <input name="expences[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[report]" value="1" class="cBen cBox checkbox"><span><?=$lng['Report']?></span></label> -->
											</td>
											<td>
												<!-- <input name="expences[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[archive]" value="1" class="cBen cBox checkbox"><span><?=$lng['Archive']?></span></label> -->
											</td>
											<td>
												<!-- <input name="expences[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[settings]" value="1" class="cBen cBox checkbox"><span><?=$lng['Settings']?></span></label> -->
											</td>
										</tr>
									<!--COMMUNICATION CENTER ////////////////////////////////////////////////////////////// --> 

									<!--BENEFITS & EXPENCES //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
												<input name="expences[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[access]" value="1" class="cMod aBen checkbox"><span> <?=$lng['Benefits & Expences']?></span></label>
											</th>
											<th class="tal">
											</th>
											<td>
												<input name="expences[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[view]" value="1" class="cBen cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="expences[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[edit]" value="1" class="cBen cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td style="width:80%"></td>
											<td>
												<input name="expences[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[report]" value="1" class="cBen cBox checkbox"><span><?=$lng['Report']?></span></label>
											</td>
											<td>
												<input name="expences[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[archive]" value="1" class="cBen cBox checkbox"><span><?=$lng['Archive']?></span></label>
											</td>
											<td>
												<input name="expences[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="expences[settings]" value="1" class="cBen cBox checkbox"><span><?=$lng['Settings']?></span></label>
											</td>
										</tr>

									<!--PROJECTS //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
												<input name="project[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="project[access]" value="1" class="cMod aPro checkbox"><span> <?=$lng['Projects']?></span></label>
											</th>
											<th class="tal">
											</th>
											<td>
												<input name="project[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="project[view]" value="1" class="cPro cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="project[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="project[edit]" value="1" class="cPro cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td style="width:80%"></td>
											<td>
												<input name="project[report]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="project[report]" value="1" class="cPro cBox checkbox"><span><?=$lng['Report']?></span></label>
											</td>
											<td>
												<input name="project[archive]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="project[archive]" value="1" class="cPro cBox checkbox"><span><?=$lng['Archive']?></span></label>
											</td>
											<td>
												<input name="project[settings]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="project[settings]" value="1" class="cPro cBox checkbox"><span><?=$lng['Settings']?></span></label>
											</td>
										</tr>

									<!--SETTINGS //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
												<input name="settings[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="settings[access]" value="1" class="cMod aSet checkbox"><span> <?=$lng['Settings']?></span></label>
											</th>
											<th class="tal">
											</th>
											<td>
												<input name="settings[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="settings[view]" value="1" class="cSet cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="settings[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="settings[edit]" value="1" class="cSet cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>

									<!--SUPPORT DESK //////////////////////////////////////////////////////////////////// --> 
										<tr style="border-top:2px solid #ddd">
											<th class="tal" style="font-weight:600; vertical-align:baseline; width:1px">
												<input name="support[access]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="support[access]" value="1" class="cMod aSup checkbox"><span> <?=$lng['Support desk']?></span></label>
											</th>
											<th class="tal">
											</th>
											<td>
												<input name="support[view]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="support[view]" value="1" class="cSup cBox checkbox"><span><?=$lng['View']?></span></label>
											</td>
											<td>
												<input name="support[edit]" type="hidden" value="0"  />
												<label><input disabled type="checkbox" name="support[edit]" value="1" class="cSup cBox checkbox"><span><?=$lng['Edit']?></span></label>
											</td>
											<td>
											</td>
											<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
										</tr>
										
					        		</tbody>
								</table>
					  		</fieldset>
					  	</div>
					  	<!------ 2nd tab user permissions end ---->

					    <!------ 3rd tab user access rights start ---->
					  	<div class="tab">
					  		<fieldset>
							<h2><i class="fa fa-cog"></i>  <?=$lng['Access Rights']?></h2>
							<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto">
								<thead>
									<tr style="line-height:100%; background:#09c; color:#fff;">
										
										<!-- <th style="color:#fff"><?=$lng['Company']?></th>
										<th style="color:#fff"><?=$lng['Locations']?></th>
										<th style="color:#fff"><?=$lng['Divisions']?></th>
										<th style="color:#fff"><?=$lng['Departments']?></th>
										<th style="color:#fff"><?=$lng['Teams']?></th> -->
										<?if(count($entities) > 1){ ?>
											<th style="color:#fff"><?=$lng['Company']?></th>
										<? } ?>
										<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
											<th style="color:#fff"><?=$parameters[1][$lang]?></th>
										<? } ?>
										<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
											<th style="color:#fff"><?=$parameters[2][$lang]?></th>
										<? } ?>
										<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
											<th style="color:#fff"><?=$parameters[3][$lang]?></th>
										<? } ?>
										<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
											<th style="color:#fff"><?=$parameters[4][$lang]?></th>
										<? } ?>
										
									</tr>
								</thead>
								<tbody>
									<tr style="background:#f9f9f9">
										<input type="hidden" name="access" value="0">	
										<input type="hidden" name="access_selection" value="">

										<input type="hidden" name="entities" value="1">	
										<input type="hidden" name="branches" value="1">	
										<input type="hidden" name="divisions" value="1">	
										<input type="hidden" name="departments" value="1">	
										<input type="hidden" name="teams" value="1">	
										<input type="hidden" name="groups" value="1">	


										<?if(count($entities) > 1){ ?>
											<td style="padding:0">
												<select name="entities" multiple="multiple" id="userEntities">
												<? foreach($entities as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>
											</td>
										<? } ?>
										<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
											<td style="padding:0">
												<select name="branches" multiple="multiple" id="userBranches">
												<? unset($branches[1]);
												foreach($branches as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>									
											</td>
										<? } ?>
										<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
											<td style="padding:0">
												<select name="divisions" multiple="multiple" id="userDivisions">
												<? unset($divisions[1]);
												foreach($divisions as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>
										<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
											<td style="padding:0">
												<select name="departments" multiple="multiple" id="userDepartments">
												<? unset($departments[1]);
												foreach($departments as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>
										<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
											<td style="padding:0">
												<select name="teams" multiple="multiple" id="userTeams">
												<? unset($teams[1]);
												foreach($teams as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>
										
									</tr>
								</tbody>
								<tbody id="accessBody">

								</tbody>
							</table>
							</fieldset>
					    </div>
					    <!------ 3rd tab user access rights end ---->
					  
						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn" onclick="nextPrev(1)"><?=$lng['Next']?></button>
						    </div>
						</div>
					  	<!-- Circles which indicates the steps of the form: -->
					</form>
				</div>
			</div>
		</div>
	</div>

	<!------ Prev-Next Modal -------->

	<!-- PAGE RELATED PLUGIN(S) -->
	<script src="../assets/js/croppie.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>

	<script>


	function checkEmail(email){

		//alert(email);
		if(email !=''){

			$.ajax({
				url: "ajax/check_email_exist.php",
				data: {email: email},
				success: function(response){

					if(response != 'success'){
						//$('#password').val(email).attr('readonly',true);
						$('#hiddpassword').val('removepassreq');
						$('#password').val('').attr("placeholder", "User exist already – Use existing password");
					}else{
						$('#password').val('<?=$password?>');
						$('#hiddpassword').val('');
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
					return false;
				}
			});
		}

		$('#username').val(email);
	}


	$(document).ready(function() {

		var employees = <?=json_encode($employees)?>;
		var compusers = <?=json_encode($compusers)?>;
		var copy_from = <?=json_encode($copy_from)?>;
		var emps = <?=json_encode($emps)?>;
		var parameters = <?=json_encode($parameters)?>;
		var entitiesCount = <?=count($entities)?>;

		var branchesCount = <?=count($branches)?>;
		var divisionsCount = <?=count($divisions)?>;
		var departmentsCount = <?=count($departments)?>;
		var teamsCount = <?=count($teams)?>;

		//============== Access rights ===============
		
		function updateAccessNEW(access, values){

			$.ajax({
				url: "ajax/update_user_access.php",
				data: {access: access, values: values},
				dataType: 'json',
				success: function(result){

					if(entitiesCount > 1){
						$('#modalPrevnext  #userEntities')[0].sumo.unSelectAll();
						$.each(result.entity, function(v){
							$('#modalPrevnext  #userEntities')[0].sumo.selectItem(v);
						})
					}
					
					

					if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
						$('#modalPrevnext  #userBranches')[0].sumo.unSelectAll();
						$.each(result.branch, function(i,v){
							$('#modalPrevnext  #userBranches')[0].sumo.selectItem(v);
						})
					}

					if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
						$('#modalPrevnext  #userDivisions')[0].sumo.unSelectAll();
						$.each(result.division, function(i,v){
							$('#modalPrevnext  #userDivisions')[0].sumo.selectItem(v);
						})
					}
					if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
						$('#modalPrevnext  #userDepartments')[0].sumo.unSelectAll();
						$.each(result.department, function(v){
							$('#modalPrevnext  #userDepartments')[0].sumo.selectItem(v);
						})
					}
					if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
						$('#modalPrevnext #userTeams')[0].sumo.unSelectAll();
						$.each(result.team, function(v){
							$('#modalPrevnext  #userTeams')[0].sumo.selectItem(v);
						})
					}


					$('#modalPrevnext input[name="access"]').val(0);
					$('#modalPrevnext input[name="access_selection"]').val(result.tableRow);
					$('#modalPrevnext #usersAccess tbody#accessBody').html('');
					$('#modalPrevnext #usersAccess tbody#accessBody').html(result.tableRow); //return false;
				}
			});
		}

		function updateAccess(access, values){

			$.ajax({
				url: "ajax/update_user_access.php",
				data: {access: access, values: values},
				dataType: 'json',
				success: function(result){

					if(entitiesCount > 1){
						$('#userEntities')[0].sumo.unSelectAll();
						$.each(result.entity, function(v){
							$('#userEntities')[0].sumo.selectItem(v);
						})
					}

					if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
						$('#userBranches')[0].sumo.unSelectAll();
						$.each(result.branch, function(i,v){
							$('#userBranches')[0].sumo.selectItem(v);
						})
					}
					if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
						$('#userDivisions')[0].sumo.unSelectAll();
						$.each(result.division, function(i,v){
							$('#userDivisions')[0].sumo.selectItem(v);
						})
					}
					if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
						$('#userDepartments')[0].sumo.unSelectAll();
						$.each(result.department, function(v){
							$('#userDepartments')[0].sumo.selectItem(v);
						})
					}
					if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
						$('#userTeams')[0].sumo.unSelectAll();
						$.each(result.team, function(v){
							$('#userTeams')[0].sumo.selectItem(v);
						})
					}

					$('input[name="access"]').val(0);
					$('input[name="access_selection"]').val(result.tableRow);
					$('#usersAccess tbody#accessBody').html('');
					$('#usersAccess tbody#accessBody').html(result.tableRow); //return false;
				}
			});
		}
		
		$('#userEntities').SumoSelect({
			placeholder: '<?=$lng['Select entities']?>',
			captionFormat: '<?=$lng['Entities']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Entities']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#userBranches').SumoSelect({
			placeholder: '<?=$lng['Select branches']?>',
			captionFormat: '<?=$lng['Branches']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Branches']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#userDivisions').SumoSelect({
			placeholder: '<?=$lng['Select divisions']?>',
			captionFormat: '<?=$lng['Divisions']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Divisions']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#userDepartments').SumoSelect({
			placeholder: '<?=$lng['Select departments']?>',
			captionFormat: '<?=$lng['Departments']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Departments']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#userTeams').SumoSelect({
			placeholder: '<?=$lng['Select teams']?>',
			captionFormat: '<?=$lng['Teams']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Teams']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		/*$('#userOrganization').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Organization']?>',
			captionFormat: '<?=$lng['Organization']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Organization']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});*/
		
		// $('#userEntities')[0].sumo.disable();
		// $('#userBranches')[0].sumo.disable();
		// $('#userDivisions')[0].sumo.disable();
		// $('#userDepartments')[0].sumo.disable();
		// $('#userTeams')[0].sumo.disable();
		//$('#userOrganization')[0].sumo.disable();
		
		if(entitiesCount > 1){
			$('#userEntities')[0].sumo.unSelectAll();
		}

		if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
			$('#userBranches')[0].sumo.unSelectAll();
		}
		if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
			$('#userDivisions')[0].sumo.unSelectAll();
		}
		if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
			$('#userDepartments')[0].sumo.unSelectAll();
		}
		if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
			$('#userTeams')[0].sumo.unSelectAll();
		}
		// $('#userOrganization')[0].sumo.unSelectAll();
		
		$("#userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('entities', $('#userEntities').val());
		});

		$("#userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('branches', $('#userBranches').val());
		});
		$("#userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('divisions', $('#userDivisions').val()); 
		});
		$("#userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('departments', $('#userDepartments').val());
		});
		$("#userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('teams', $('#userTeams').val());
		});

		// $("#userOrganization ~ .optWrapper .MultiControls .btnOk").click( function () {
		// 	updateAccess('organization', $('#userOrganization').val());
		// });

		//============== Access rights ===============


		// devbridgeAutocomplete -------------------------------------------
		$('#system_user_name').on('change', function(){
			//alert($(this).val())
			$("#name").val($(this).val());
		})
		
		$('#system_user_name').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
			 onSelect: function (suggestion) {
				$("#emp_id").val(emps[suggestion.data]['emp_id']);
				$("#phone").val(emps[suggestion.data]['phone']);
				$("#email").val(emps[suggestion.data]['email']);
				$("#username").val(emps[suggestion.data]['email']);
				//$("#firstname").val(emps[suggestion.data]['firstname']);
				$("#name").val(emps[suggestion.data]['<?=$lang?>_name']);
				$("#img").val(emps[suggestion.data]['image']);
				$('#upload-demo').css('background-image', 'url(../'+emps[suggestion.data]['image']+')');

				checkEmail(emps[suggestion.data]['email']);
			 }
		});

		$('#UserNameFilter').devbridgeAutocomplete({
			lookup: compusers,
			minChars: 0,
			showNoSuggestionNotice: true,
			onSelect: function (suggestion) {
				//alert(suggestions);
				//alert(suggestion.data);
				window.location.href= '?mn=603&userid='+suggestion.data;
			}
		});	

		
		
		$('#modalAccessRights #copy_from').devbridgeAutocomplete({
			lookup: copy_from,
			minChars: 0,
			onSelect: function (suggestion) {
				getPermissionDataAR(suggestion.data, false)
				
			}
		})

		$('#modalSetPermissions #copy_from').devbridgeAutocomplete({
			lookup: copy_from,
			minChars: 0,
			onSelect: function (suggestion) {
				getPermissionData(suggestion.data, false)
				
			}
		})

		/*.focus(function () {
	        $(this).devbridgeAutocomplete('search', $(this).val())
	    });*/	
		
		var $uploadCrop;
		var maxSize = 2000;
		//var minHeight = 150;
		//var minWidth = 150;
		$uploadCrop = $('#upload-demo').croppie({
			viewport: {
				width: 150,
				height: 150,
				type: 'square'
			},
			boundary: {
				width: 180,
				height: 180
			},
			mouseWheelZoom: true,
			showZoom: true
		});
		
		$('#selectUserImg').on('change', function () { 
			$("#userBut i").removeClass('fa-user').addClass('fa-repeat fa-spin');
			readFile(this);
		});
		
		function readFile(input) {
			if(input.files && input.files[0]) {
				var file = input.files[0];
				var reader = new FileReader();
				reader.onload = function (e) {
					var img = new Image;
					var t = file.type.split('/')[1];
					var n = file.name;
					var s = ~~(file.size/1024);
					var msg = "";
					if(s > maxSize){msg = '<?=$lng['Filesize is to bigg']?> ('+(s/1024).format(2)+' Mb) - Max. '+(maxSize/1000)+' Mb';}
					if(t != 'jpeg' && t != 'png' && t != 'jpg'){msg = "<?=$lng['Please use only ... files']?>";}
					if(msg!=''){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+msg,
							duration: 4,
						})
						$("p#selpic i").removeClass('fa-repeat fa-spin').addClass('fa-user');
						$("#upload").val('');
						return false;
					}
					img.src = e.target.result;
					img.onload = function() {
						$("#userBut i").removeClass('fa-repeat fa-spin').addClass('fa-user');
					};
					//$('#klik').html('');
					//alert(e.target.result)
					$('#orig').attr('src', e.target.result);
					$('#img_data').val(e.target.result);
					$uploadCrop.croppie('bind', {
						url: e.target.result
					});
					$('.upload-demo').addClass('ready');
					$("#message").fadeOut();
				}
				reader.readAsDataURL(input.files[0]);
			}else{
				swal("Sorry - you're browser doesn't support the FileReader API");
			}
		}


		/*$(document).on("click", "#selAllAccess", function(e){
			$.ajax({
				url: "ajax/update_user_all_access.php",
				dataType: 'json',
				success: function(result){

					$('#userTeams').val(result.NewteamIds);
					$("#userTeams ~ .optWrapper .MultiControls .btnOk").click();
					//updateAccess('teams', result.NewteamIds);
					

					///updateAccess('teams', result.NewteamIds);
					//alert(result.NewteamIds);
					//$('#dump').html(result); return false;

					//$('.allAccess').prop('disabled', false);
					//$('input[name="access"]').val(1);
					//$('input[name="access_selection"]').val(result.tableRow);
					//$('#usersAccess tbody#accessBody').html('');
					//$('#usersAccess tbody#accessBody').html(result.tableRow);
				}
			});
		});*/
	
			
		$(document).on("change", ".userType", function(e){
			$.ajax({
				url: "ajax/update_user_type.php",
				data: {id: $(this).data('id'), ref: $(this).data('ref'), value: $(this).val()},
				success: function(result){
					//$('#dump').html(result); return false;
				}
			});
		});
		$(document).on("change", ".userStatus", function(e){
			$.ajax({
				url: "ajax/update_user_status.php",
				data: {id: $(this).data('id'), ref: $(this).data('ref'), value: $(this).val()},
				success: function(result){
					//$('#dump').html(result); return false;
				}
			});
		});



		// SHOW PERMISSION FORM -------------------------------------------------------------------------------------------
		function getPermissionData(id, copy){
			if(copy){
				$("#modalSetPermissions #user_id").val(id);
				$('#modalSetPermissions #copy_from').val('');
			}
			$('#modalSetPermissions #permissionForm input[type="checkbox"]').prop('checked',false);
			//$('input[type="checkbox"]').prop('disabled',true);
			//return false;
			$.ajax({
				url: "ajax/get_permission_data.php",
				data: {id: id},
				dataType: 'json',
				success:function(data){
					if(copy){
						$("#modalSetPermissions #sysUser").html(data.name);
						$("#modalSetPermissions #permImg").prop('src', '../'+data.img);
					}
					//$('#dump').html(data); //return false;
					
					$('#modalSetPermissions #save_settings').css('display','block')
					$('#modalSetPermissions #save_settings').prop('disabled',false)
					$('#modalSetPermissions #permissionForm fieldset').prop('disabled',false)
					$('#modalSetPermissions input[type="checkbox"]').prop('disabled',false);
					$('#modalSetPermissions input[type="checkbox"]').prop('checked',false);
					//return false
					
					$.each(data.permissions, function (key, val) {
						$.each(val, function (k, v) {
							if(v == 1){
								$('#modalSetPermissions #permissionForm input[name="'+key+'['+k+']"]').prop('checked',true)
							}
						});
					});
					//changeSumo = 0;

					$('#modalSetPermissions input.cMod').each(function(){
						if(!$(this).is(':checked')){
							$(this).trigger('change')
						}
					});
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}

		
		$(document).on("click", ".permissions", function(e){
			e.preventDefault();
			getPermissionData($(this).data('id'), true);
			$('#modalSetPermissions').modal('show');
		});


			
		$(document).on("click", "#selAll", function(e){
			$('input[type="checkbox"]').prop('checked', this.checked);
			if(this.checked){
				$('.cBox').prop('disabled', false);
			}else{
				$('.cBox').prop('disabled', true);
			}
		})

		$(document).on("change", ".aEmp", function(e){
			if(!$(this).is(':checked')){
				$('.cEmp').prop('checked', false);
				$('.cEmp').prop('disabled', true);
				$('.allEmp').prop('disabled', true);
			}else{
				$('.cEmp').prop('disabled', false);
				$('.allEmp').prop('disabled', false);
			}
		});
		$(document).on("change", ".allEmp", function(e){
			if(!$(this).is(':checked')){
				$('.cEmp').prop('checked', false);
			}else{
				$('.cEmp').prop('checked', true);
			}
		});
		$(document).on("change", ".aLea", function(e){
			if(!$(this).is(':checked')){
				$('.cLea').prop('checked', false);
				$('.cLea').prop('disabled', true);
				$('.allLea').prop('disabled', true);
			}else{
				$('.cLea').prop('disabled', false);
				$('.allLea').prop('disabled', false);
			}
		});
		$(document).on("change", ".allLea", function(e){
			if(!$(this).is(':checked')){
				$('.cLea').prop('checked', false);
			}else{
				$('.cLea').prop('checked', true);
			}
		});
		$(document).on("change", ".aTim", function(e){
			if(!$(this).is(':checked')){
				$('.cTim').prop('checked', false);
				$('.cTim').prop('disabled', true);
				$('.allTim').prop('disabled', true);
			}else{
				$('.cTim').prop('disabled', false);
				$('.allTim').prop('disabled', false);
			}
		});
		$(document).on("change", ".allTim", function(e){
			if(!$(this).is(':checked')){
				$('.cTim').prop('checked', false);
			}else{
				$('.cTim').prop('checked', true);
			}
		});
		$(document).on("change", ".aPay", function(e){
			if(!$(this).is(':checked')){
				$('.cPay').prop('checked', false);
				$('.cPay').prop('disabled', true);
				$('.allPay').prop('disabled', true);
			}else{
				$('.cPay').prop('disabled', false);
				$('.allPay').prop('disabled', false);
			}
		});
		$(document).on("change", ".allPay", function(e){
			if(!$(this).is(':checked')){
				$('.cPay').prop('checked', false);
			}else{
				$('.cPay').prop('checked', true);
			}
		});
		$(document).on("change", ".aBen", function(e){
			if(!$(this).is(':checked')){
				$('.cBen').prop('checked', false);
				$('.cBen').prop('disabled', true);
			}else{
				$('.cBen').prop('disabled', false);
			}
		});
		$(document).on("change", ".accBen", function(e){
			if(!$(this).is(':checked')){
				$('.ccBen').prop('checked', false);
				$('.ccBen').prop('disabled', true);
			}else{
				$('.ccBen').prop('disabled', false);
			}
		});
		$(document).on("change", ".aPro", function(e){
			if(!$(this).is(':checked')){
				$('.cPro').prop('checked', false);
				$('.cPro').prop('disabled', true);
			}else{
				$('.cPro').prop('disabled', false);
			}
		});
		$(document).on("change", ".aSet", function(e){
			if(!$(this).is(':checked')){
				$('.cSet').prop('checked', false);
				$('.cSet').prop('disabled', true);
			}else{
				$('.cSet').prop('disabled', false);
			}
		});
		$(document).on("change", ".aSup", function(e){
			if(!$(this).is(':checked')){
				$('.cSup').prop('checked', false);
				$('.cSup').prop('disabled', true);
			}else{
				$('.cSup').prop('disabled', false);
			}
		});
			
		// SUBMIT PERMISSION FORM ---------------------------------------------------------------------------------------
		$(document).on('submit','#permissionForm', function(e){
			e.preventDefault();
			var data = $(this).serialize();
			$.ajax({
				url: "ajax/save_user_permissions.php",
				type: 'POST',
				data: data,
				//dataType: 'json',
				success: function(result){
					//$('#dump').html(result); return false;
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Permissions updated successfuly']?>',
							duration: 2,
							callback: function(value){
								location.reload();
							}
						})
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
						})
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});
			
			
		// DELETE USER------------------------------------- DELETE USER
		$('.delUser').confirmation({
			container: 'body',
			rootSelector: '.delUser',
			singleton: true,
			animated: 'fade',
			placement: 'left',
			popout: true,
			html: true,
			title: '<?=$lng['Are you sure']?>',
			//btnOkIcon: '',
			//btnCancelIcon: '',
			btnOkLabel: '<?=$lng['Delete']?>',
			btnCancelLabel: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				$.ajax({
					url: "ajax/delete_user.php",
					data:{id: $(this).data('id'), ref: $(this).data('ref'), type: $(this).data('type'), emp: $(this).data('emp')},
					success: function(result){
						//$('#dump').html(result);
						if(result == 'last'){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;You can not delete the last system user',
								duration: 4,
							})
							return false;
						}
						location.reload();
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
			}
		});
			
	
		//====== Add new sys user =====
		$(document).on("click", "#add_Newuser", function(){

			var parameters = <?=json_encode($parameters)?>;
			var entitiesCount = <?=count($entities)?>;

			$('#modalPrevnext #regForm fieldset').prop('disabled',false)
			$('#modalPrevnext input[type="checkbox"]').prop('disabled',false);
			$('#modalPrevnext input[type="checkbox"]').prop('checked',false);

			$('#modalPrevnext #userEntities').SumoSelect({
				placeholder: '<?=$lng['Select'].' '.$lng['Company']?>',
				captionFormat: '<?=$lng['Company']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Company']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:true, 
				showTitle : false,
				triggerChangeCombined: true,
			});
			$('#modalPrevnext #userBranches').SumoSelect({
				placeholder: '<?=$lng['Select'].' '.$lng['Locations']?>',
				captionFormat: '<?=$lng['Locations']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Locations']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:true, 
				showTitle : false,
				triggerChangeCombined: true,
			});
			$('#modalPrevnext #userDivisions').SumoSelect({
				placeholder: '<?=$lng['Select divisions']?>',
				captionFormat: '<?=$lng['Divisions']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All Divisions']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:true, 
				showTitle : false,
				triggerChangeCombined: true,
			});
			$('#modalPrevnext #userDepartments').SumoSelect({
				placeholder: '<?=$lng['Select departments']?>',
				captionFormat: '<?=$lng['Departments']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All Departments']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:true, 
				showTitle : false,
				triggerChangeCombined: true,
			});
			$('#modalPrevnext #userTeams').SumoSelect({
				placeholder: '<?=$lng['Select teams']?>',
				captionFormat: '<?=$lng['Teams']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All Teams']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:true, 
				showTitle : false,
				triggerChangeCombined: true,
			});

			if(entitiesCount > 1){
				$('#modalPrevnext #userEntities')[0].sumo.unSelectAll();
			}
			if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
				$('#modalPrevnext #userBranches')[0].sumo.unSelectAll();
			}
			if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
				$('#modalPrevnext #userDivisions')[0].sumo.unSelectAll();
			}
			if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
				$('#modalPrevnext #userDepartments')[0].sumo.unSelectAll();
			}
			if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
				$('#modalPrevnext #userTeams')[0].sumo.unSelectAll();
			}
			
			if(entitiesCount > 1){
				$("#modalPrevnext  #userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccessNEW('entities', $('#modalPrevnext #userEntities').val());
				});
			}

			if(parameters[1]['apply_param'] == 1){
				$("#modalPrevnext #userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccessNEW('branches', $('#modalPrevnext #userBranches').val());
				});
			}
			if(parameters[2]['apply_param'] == 1){
				$("#modalPrevnext #userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccessNEW('divisions', $('#modalPrevnext #userDivisions').val());
				});
			}
			if(parameters[3]['apply_param'] == 1){
				$("#modalPrevnext #userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccessNEW('departments', $('#modalPrevnext #userDepartments').val());
				});
			}
			if(parameters[4]['apply_param'] == 1){
				$("#modalPrevnext #userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccessNEW('teams', $('#modalPrevnext #userTeams').val());
				});
			}
			
			
			$("#modalPrevnext").modal('toggle');
		})

		$('#modalPrevnext').on('hidden.bs.modal', function () {
			$(this).find('form#regForm').trigger('reset');
			$('#modalPrevnext #upload-demo').css('background-image', 'url(../images/profile_image.jpg');
		});

		$('.main').fadeIn(200);
	
	})

	


	//Next-prev page scripts
	
	var currentTab = 0; // Current tab is set to be the first tab (0)
	showTab(currentTab); // Display the current tab

	function showTab(n) {
	  // This function will display the specified tab of the form...
	  var x = document.getElementsByClassName("tab"); 
	  x[n].style.display = "block";
	  //... and fix the Previous/Next buttons:
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	    //$('#SaveNewUser').attr('id','nextBtn');
	  }
	  if (n == (x.length - 1)) {
	    document.getElementById("nextBtn").innerHTML = "Submit";
	    
	    //$('#nextBtn').attr('id','SaveNewUser');
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Next";
	    
	    //$('#nextBtn').attr('id','nextBtn'); 
	  }
	  //... and run a function that will display the correct step indicator:
	  //fixStepIndicator(n)
	}

	function nextPrev(n) {
	  // This function will figure out which tab to display
	  var x = document.getElementsByClassName("tab");
	  // Exit the function if any field in the current tab is invalid:
	  //if (n == 1 && !validateForm()) return false;
	  // Hide the current tab:
	  x[currentTab].style.display = "none";
	  // Increase or decrease the current tab by 1:
	  currentTab = currentTab + n;
	  // if you have reached the end of the form...
	  if (currentTab >= x.length) {
	    // ... the form gets submitted:
	    //document.getElementById("regForm").submit();
	    SaveNewUsersssForm();
	    return false;
	  }
	  // Otherwise, display the correct tab:
	  showTab(currentTab);
	}


	function SaveNewUsersssForm(){

		var frm = $('#regForm');
		var data = frm.serialize();
		var file = $('#selectUserImg')[0].files[0];
		
		var err = true;
		if($('user_id').val()==''){err = false};
		if($('#username').val()==''){err = false};
		if($('#hiddpassword').val() == ''){
			if($('#password').val()==''){err = false};
		}
		
		if($('#email').val()==''){err = false};
		if(err==false){
			$('#modalPrevnext').modal('hide');
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
				duration: 4,
			})
			location.reload();
			return false;
		}
		
		if($('#hiddpassword').val() == ''){
			if($('#password').val().length < 8){
				$('#modalPrevnext').modal('hide');
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Password to short min 8 characters']?>',
					duration: 4,
				})
				location.reload();
				return false;
			};
		}

		//if(!file){

			$('#modalPrevnext').modal('hide');

			$.ajax({
				url: "ajax/save_user_data.php",
				type: 'POST',
				data: data,
				success: function(result){
					if(result == 'success'){

						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['New user saved successfully']?>',
							duration: 2,
							callback: function(value){
								location.reload();
							}
						})
				
					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
							duration: 4,
						})
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		//}

		/*var reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onload = function (e) {
			var img = new Image;
			img.src = e.target.result;
			img.onload = function() {
				$uploadCrop.croppie('result', {
					type: 'canvas',
					size: 'viewport'
				}).then(function (resp) {
					data.append('img_data', resp); 
					$.ajax({
						url: ROOT+"settings/ajax/save_user_data.php",
						type: 'POST',
						data: data,
						async: false,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
							//alert(result);
							//$('#dump').html(result);
							location.reload();
							//setTimeout(function(){$('#modalUser').modal('toggle')},500);
							//setTimeout(function(){location.reload();},1000);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError);
						}
					});
				});
			};
		}*/
	}

	

	function getPermissionDataAR(id, copy){

		var parameters = <?=json_encode($parameters)?>;
		var entitiesCount = <?=count($entities)?>;
		var branchesCount = <?=count($branches)?>;
		var divisionsCount = <?=count($divisions)?>;
		var departmentsCount = <?=count($departments)?>;
		var teamsCount = <?=count($teams)?>;

		if(copy){
			$("#modalAccessRights #user_id").val(id);
			$('#modalAccessRights #copy_from').val('');
		}
		$('input[type="checkbox"]').prop('checked',false);
		//$('input[type="checkbox"]').prop('disabled',true);
		//return false;
		$.ajax({
			url: "ajax/get_permission_data.php",
			data: {id: id},
			dataType: 'json',
			success:function(data){

				if(entitiesCount > 1){
					$('#modalAccessRights #userEntities')[0].sumo.unSelectAll();
				}
				
				if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
					$('#modalAccessRights #userBranches')[0].sumo.unSelectAll();
				}
				if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
					$('#modalAccessRights #userDivisions')[0].sumo.unSelectAll();
				}
				if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
					$('#modalAccessRights #userDepartments')[0].sumo.unSelectAll();
				}
				if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
					$('#modalAccessRights #userTeams')[0].sumo.unSelectAll();
				}

				if(copy){
					$("#modalAccessRights #sysUser").html(data.name);
					$("#modalAccessRights #permImg").prop('src', '../'+data.img);
				}
				//$('#dump').html(data); //return false;
				
				$('#modalAccessRights #save_settings').css('display','block')
				$('#modalAccessRights #save_settings').prop('disabled',false)
				$('#modalAccessRights #AccessRightsForm fieldset').prop('disabled',false)
				$('#modalAccessRights input[type="checkbox"]').prop('disabled',false);
				$('#modalAccessRights input[type="checkbox"]').prop('checked',false);
				//return false

				
				//changeSumo = 0;
				if(entitiesCount > 1){
					$('#modalAccessRights #userEntities')[0].sumo.enable();
				}

				if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
					$('#modalAccessRights #userBranches')[0].sumo.enable();
				}
				if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
					$('#modalAccessRights #userDivisions')[0].sumo.enable();
				}
				if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
					$('#modalAccessRights #userDepartments')[0].sumo.enable();
				}
				if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
					$('#modalAccessRights #userTeams')[0].sumo.enable();
				}
				
				
				if(entitiesCount > 1){
					$.each((data.entities).split(','), function(i,v){
						$('#modalAccessRights #userEntities')[0].sumo.selectItem(v);
					})
				}

				if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
					$.each((data.branches).split(','), function(i,v){
						$('#modalAccessRights #userBranches')[0].sumo.selectItem(v);
					})
				}

				if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
					$.each((data.divisions).split(','), function(i,v){
						$('#modalAccessRights #userDivisions')[0].sumo.selectItem(v);
					})
				}
				if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
					$.each((data.departments).split(','), function(i,v){
						$('#modalAccessRights #userDepartments')[0].sumo.selectItem(v);
					})
				}
				if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
					$.each((data.teams).split(','), function(i,v){
						$('#modalAccessRights #userTeams')[0].sumo.selectItem(v);
					})
				}

				$('#modalAccessRights input[name="access"]').val(data.access);
				$('#modalAccessRights input[name="access_selection"]').val(data.access_selection);
				$('#modalAccessRights #usersAccess tbody#accessBody').html(data.access_selection);
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
				})
			}
		});
	}

	/*$(document).on("click", "#selAllAccess", function(e){
		$.ajax({
			url: "ajax/update_user_all_access.php",
			dataType: 'json',
			success: function(result){

	
				//alert(result.NewteamIds);
				//$('#dump').html(result); return false;

				$('.allAccess').prop('disabled', false);
				$('input[name="access"]').val(1);
				$('input[name="access_selection"]').val(result.tableRow);
				$('#usersAccess tbody#accessBody').html('');
				$('#usersAccess tbody#accessBody').html(result.tableRow);
			}
		});
	});*/
	
	

	$(document).on("click", ".AccessRights", function(e){
		e.preventDefault();
		//alert($(this).data('id'));
		getPermissionDataAR($(this).data('id'), true);
		$('#modalAccessRights').modal('show');
	});
		
	$(document).on("click", "#selAll", function(e){
		$('input[type="checkbox"]').prop('checked', this.checked);
		if(this.checked){
			$('.cBox').prop('disabled', false);
		}else{
			$('.cBox').prop('disabled', true);
		}
	})

	
		
	// SUBMIT PERMISSION FORM ---------------------------------------------------------------------------------------
	$(document).on('submit','#AccessRightsForm', function(e){
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			url: "ajax/save_user_access_rights.php",
			type: 'POST',
			data: data,
			//dataType: 'json',
			success: function(result){
				//$('#dump').html(result); return false;
				if(result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Access rights updated successfuly']?>',
						duration: 2,
						callback: function(value){
							//location.reload();
						}
					})
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
						duration: 4,
					})
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
				})
			}
		});
	});

</script>






















